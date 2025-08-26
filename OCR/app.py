from flask import Flask, request, jsonify
from flask_cors import CORS
import torch
import paddle
import paddleocr
import spacy
import cv2
from paddleocr import PaddleOCR
import re
import json
from dateutil import parser
import os
from PIL import Image
import io
import traceback

# === Initialize Flask App ===
app = Flask(__name__)
CORS(app)



# === Load Models Once ===
ocr = PaddleOCR(use_angle_cls=True, lang='en')
nlp = spacy.load("ner_cnn_30e") 

# === Utility Functions ===
def clean_text(text):
    text = re.sub(r'(?<!http)(?<!https)(?<!://):(?=\S)', ': ', text)
    text = re.sub(r'\b(No\.|Num\.)(?=\S)', r'\1 ', text)
    text = re.sub(r'#(?=\S)', '# ', text)
    text = re.sub(r'\b[Rr][Mm]\b', '$', text)
    text = re.sub(r'\$(?=\d)', '$ ', text)
    text = re.sub(r'\s*\|\s*', ' | ', text)
    text = re.sub(r'(\w*(No\.|Num\.|NO\.|NUM\.))(?=\S)', r'\1 ', text)
    text = re.sub(r'\b(InvoiceNo|PhoneNo|InvoiceNum|PhoneNum|AccountNo|AccountNum)(?=\S)', r'\1 ', text)
    text = re.sub(r'(\w*(Date|date))(?=\S)', r'\1 ', text)
    text = re.sub(r'\b(Number|number)(?=\S)', r'\1 ', text)
    text = re.sub(r'(\w*(Total|total))(?=\d)', r'\1 ', text)
    text = re.sub(r'(Ref\.)(?=\S)', r'\1 ', text)  # Add space after 'Ref.'
    text = re.sub(r'(DATE\.|Date\.|date\.)(?=\S)', r'\1 ', text)  # Add space after DATE., Date., or date.
    text = re.sub(r'\b(DATE|date|Date)(?=\S)', r'\1 ', text)  # Add space after DATE, date, or Date
    text = re.sub(r'(?<=No)(?=\S)', ' ', text)  # Add space after 'No'
    text = re.sub(r'(?<=INVOICENO)(?=\S)', ' ', text)  # Add space after 'INVOICENO'
    text = re.sub(r'(?=\+)(?<!\s)', ' ', text)  # Add space before '+'
    text = re.sub(r'(Ref\.)(?=\S)', r'\1 ', text)  # Add space after 'Ref.'
    text = re.sub(r'(DATE\.|Date\.|date\.)(?=\S)', r'\1 ', text)  # Add space after DATE., Date., or date.
    text = re.sub(r'\b(DATE|date|Date)(?=\S)', r'\1 ', text)  # Add space after DATE, date, or Date
    text = re.sub(r'(?<=No)(?=\S)', ' ', text)  # Add space after 'No'
    text = re.sub(r'(?<=INVOICENO)(?=\S)', ' ', text)  # Add space after 'INVOICENO'
    return text

def normalize_date(raw_date):
    try:
        parsed = parser.parse(raw_date, dayfirst=True)
        return parsed.strftime("%Y-%m-%d")
    except Exception as e:
        print(f"[!] Invalid date format: '{raw_date}' - {e}")
        return None

def clean_numeric(text):
    return re.sub(r"[^\d]", "", text)


def process_invoice(image_path):
    def correct_ocr_errors(text):
        return text.replace("I", "1").replace("O", "0")  # Basic OCR correction

    results = ocr.ocr(image_path, cls=True)
    text_data = [entry[1][0] for res in results for entry in res]
    preclassified_text = " ".join(text_data)
    preclassified_text = correct_ocr_errors(preclassified_text)
    doc = nlp(clean_text(preclassified_text))

    invoice_data = {}
    item_list = []
    current_item = {}
    sender_added = False
    total_prices_list = []

    for ent in doc.ents:
        label = ent.label_
        value = ent.text.strip()

        if label == "SENDER":
            # Avoid duplicates or overfitting by checking uniqueness
            if not sender_added or (value not in invoice_data.get("sender", "")):
                invoice_data["sender"] = value
                sender_added = True

        elif label == "INVOICE_DATE":
            norm_date = normalize_date(value)
            if not invoice_data.get("invoice_date"):
                invoice_data["invoice_date"] = norm_date

        elif label == "DUE_DATE":
            norm_date = normalize_date(value)
            if invoice_data.get("invoice_date"):
                invoice_data["due_date"] = norm_date
            else:
                # Transfer DUE_DATE to INVOICE_DATE if invoice_date is missing
                invoice_data["invoice_date"] = norm_date

        elif label == "INVOICE_NUM" and "invoice_num" not in invoice_data:
            value = value.replace("1nvoice", "Invoice").replace("1NV", "INV")
            invoice_data["invoice_num"] = value.split()[0]  # Grab only 'INV-13'

        elif label == "TOTAL_INVOICE_PRICE":
            invoice_data["total_invoice_price"] = value

        elif label == "PHONE_NUM":
            invoice_data["phone_num"] = clean_numeric(value)

        elif label == "EMAIL":
            invoice_data["email"] = value

        elif label == "WEBSITE":
            invoice_data["website"] = value

        elif label == "BANK_NAME":
            invoice_data["bank_name"] = value

        elif label == "ACCOUNT_NUM":
            invoice_data["account_num"] = clean_numeric(value)

        elif label == "ITEM_NAME":
            current_item = {"item_name": value, "quantity": None, "price": None, "total_price": None}

        elif label == "QUANTITY" and current_item:
            current_item["quantity"] = value

        elif label == "PRICE" and current_item:
            current_item["price"] = value

        elif label == "TOTAL_PRICE":
            try:
                price_num = float(value.replace(",", "").replace("RM", "").strip())
                total_prices_list.append((price_num, value))
            except:
                pass

            if current_item:
                current_item["total_price"] = value

                # Heuristic: If quantity missing but price == total, assume quantity = 1
                try:
                    price_val = float(current_item.get("price", "0").replace(",", "").replace("RM", "").strip())
                    total_val = float(value.replace(",", "").replace("RM", "").strip())
                    if not current_item["quantity"] and price_val == total_val:
                        current_item["quantity"] = "1"
                except:
                    pass

                if all(current_item.values()):
                    item_list.append(current_item)
                    current_item = {}

    # Final check to append item if complete
    if current_item and all(current_item.values()):
        item_list.append(current_item)

    # Ensure all expected keys exist
    expected_keys = [
        "invoice_num", "invoice_date", "due_date", "sender",
        "bank_name", "account_num", "phone_num", "email",
        "website", "total_invoice_price"
    ]
    for key in expected_keys:
        invoice_data.setdefault(key, None)

    # Fallback: determine total_invoice_price by selecting the highest total_price
    if not invoice_data["total_invoice_price"] and total_prices_list:
        print("Comparing TOTAL_PRICE values:")
        for price_num, original_text in total_prices_list:
            print(f" - Detected: {original_text} (Parsed: {price_num})")

        # Select the highest value
        highest_total = max(total_prices_list, key=lambda x: x[0])
        invoice_data["total_invoice_price"] = highest_total[1]

    return {
        "invoice_data": invoice_data,
        "items": item_list
    }

# === API Route ===

@app.route('/')
def home():
    return "Flask is up and running!"


@app.route('/predict', methods=['POST'])
def predict():
    try:
        if 'file' not in request.files:
            return jsonify({'error': 'No file provided'}), 400

        file = request.files['file']
        save_path = os.path.join('temp.jpg')
        file.save(save_path)

        result = process_invoice(save_path)

        os.remove(save_path)
        return jsonify(result)

    except Exception as e:
        traceback.print_exc()  
        return jsonify({'error': str(e)}), 500

# === Run App ===
if __name__ == '__main__':
    app.run(port=5000, debug=True)

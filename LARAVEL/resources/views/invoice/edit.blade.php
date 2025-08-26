@extends('layout')

@section('content')
<div class="container" style=" border-radius: 50px; border: 10px solid rgb(204, 211, 214); padding: 20px; background-color:rgb(112, 114, 115); padding: 100px; padding-top: 30px; margin-bottom: 100px" >
    <h1 style="text-align: center;">Edit Invoice</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <style>
        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            background-color: rgb(186, 190, 194);
            border-radius: 15px;
            padding: 50px;
            margin-top: 50px;
        }
        .item-group {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .item-group input {
            flex: 1;
        }
    </style>

    <div class="form-container" >
        <form action="{{ route('invoice.update', $invoice->invoice_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Invoice Number</label>
                <input type="text" name="invoice_num" value="{{ $invoice->invoice_num }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" value="{{ $invoice->date }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" value="{{ $invoice->due_date }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Sender Name</label>
                <input type="text" name="sender_name" value="{{ $invoice->sender_name }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Sender Address</label>
                <textarea name="sender_add" class="form-control">{{ $invoice->sender_add }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Receiver Address</label>
                <textarea name="receiver_add" class="form-control">{{ $invoice->receiver_add }}</textarea>
            </div>

            <!-- <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_num" value="{{ $invoice->phone_num }}" class="form-control">
            </div> -->

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_num" 
                    value="{{ $invoice->phone_num }}" 
                    class="form-control" 
                    pattern="\d+" 
                    inputmode="numeric"
                    title="Please enter numbers only">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ $invoice->email }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="text" name="website" value="{{ $invoice->website }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Bank Name</label>
                <input type="text" name="bank_name" value="{{ $invoice->bank_name }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Account Number</label>
                <input type="text" name="acc_num" 
                    value="{{ $invoice->account_num }}" 
                    class="form-control" 
                    pattern="\d+" 
                    inputmode="numeric"
                    title="Please enter numbers only">
            </div>

            <div class="mb-3">
                <label class="form-label">Template</label>
                <select name="template" class="form-control">
                    <option value="modern" {{ $invoice->template == 'modern' ? 'selected' : '' }}>Modern</option>
                    <option value="minimalist" {{ $invoice->template == 'minimalist' ? 'selected' : '' }}>Minimalist</option>
                    <option value="fancy" {{ $invoice->template == 'fancy' ? 'selected' : '' }}>Fancy</option>
                    <option value="chill" {{ $invoice->template == 'chill' ? 'selected' : '' }}>Chill</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Payment Status</label>
                <select name="payment_status" class="form-control">
                    <option value="pending" {{ $invoice->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $invoice->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ $invoice->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Total Price</label>
                <input type="number" step="0.01" name="total_price" id="total_price" value="{{ $invoice->total_price }}" class="form-control">
            </div>

            <h4>Items</h4>
            <div id="items" class="mb-3">
                @foreach($invoice->items as $index => $item)
                    <div class="item-group">
                        <input type="text" name="items[{{ $index }}][item_name]" value="{{ $item->item_name }}" placeholder="Item Name" class="form-control" required>
                        <input type="number" name="items[{{ $index }}][item_quantity]" value="{{ $item->item_quantity }}" placeholder="Quantity" class="form-control quantity" required>
                        <input type="number" step="0.01" name="items[{{ $index }}][item_unitPrice]" value="{{ $item->item_unitPrice }}" placeholder="Unit Price" class="form-control unitPrice" required>
                        <input type="number" step="0.01" name="items[{{ $index }}][item_totalPrice]" value="{{ $item->item_totalPrice }}" placeholder="Total Price" class="form-control item-total-price" readonly>
                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>

            <br><br>
            <button type="submit" class="btn btn-primary">Update Invoice</button>
        </form>
    </div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function() {
    let itemIndex = {{ count($invoice->items) }};

    document.getElementById("add-item").addEventListener("click", function() {
        let itemGroup = document.createElement("div");
        itemGroup.classList.add("item-group");

        itemGroup.innerHTML = `
            <input type="text" name="items[${itemIndex}][item_name]" placeholder="Item Name" class="form-control" required>
            <input type="number" name="items[${itemIndex}][item_quantity]" placeholder="Quantity" class="form-control quantity" required>
            <input type="number" step="0.01" name="items[${itemIndex}][item_unitPrice]" placeholder="Unit Price" class="form-control unitPrice" required>
            <input type="number" step="0.01" name="items[${itemIndex}][item_totalPrice]" placeholder="Total Price" class="form-control item-total-price" readonly>
            <button type="button" class="btn btn-danger remove-item">Remove</button>
        `;

        document.getElementById("items").appendChild(itemGroup);
        itemIndex++;
    });

    document.getElementById("items").addEventListener("click", function(event) {
        if (event.target.classList.contains("remove-item")) {
            event.target.parentElement.remove();
            calculateTotalPrice();
        }
    });

    document.getElementById("items").addEventListener("input", function(event) {
        if (event.target.classList.contains("quantity") || event.target.classList.contains("unitPrice")) {
            let parent = event.target.closest(".item-group");
            let quantity = parseFloat(parent.querySelector(".quantity").value) || 0;
            let unitPrice = parseFloat(parent.querySelector(".unitPrice").value) || 0;
            let totalPrice = (quantity * unitPrice).toFixed(2);
            parent.querySelector(".item-total-price").value = totalPrice;
            calculateTotalPrice();
        }
    });

    function calculateTotalPrice() {
        let total = 0;
        document.querySelectorAll(".item-total-price").forEach(input => {
            total += parseFloat(input.value) || 0;
        });

        const totalInput = document.getElementById("total_price");
        if (document.activeElement !== totalInput) {
            totalInput.value = total.toFixed(2);
        }
    }
});
</script>

@endsection

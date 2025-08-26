<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePDF($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $items = Item::where('invoice_id', $invoice->invoice_id)->get();

        $data = [
            'title' => 'Invoice',
            'invoice_no' => $invoice->invoice_num ?? 'INV-' . rand(1000, 9999),
            'invoice_date' => $invoice->date ?? now()->format('d-m-Y'),
            'due_date' => $invoice->due_date,
            'sender_name' => $invoice->sender_name,
            'sender_address' => $invoice->sender_add,
            'receiver_address' => $invoice->receiver_add,
            'phone_num' => $invoice->phone_num,
            'email' => $invoice->email,
            'website' => $invoice->website,
            'bank_name' => $invoice->bank_name,
            'account_num' => $invoice->account_num,
            'total_price' => $invoice->total_price,
            'items' => $items,
        ];

        $template = match($invoice->template) {
            'modern' => 'pdf.modern',
            'fancy' => 'pdf.fancy',
            'chill' => 'pdf.chill',
            default => 'pdf.minimalist',
        };


        $pdf = PDF::loadView($template, $data);
        return $pdf->stream('invoice.pdf');
    }
}

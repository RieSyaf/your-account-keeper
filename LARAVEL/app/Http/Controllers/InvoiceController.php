<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Item;
use Carbon\Carbon;

class InvoiceController extends Controller
{



    // public function dashboard()
    // {
        
    //     Invoice::updateOverduePendingInvoices(auth()->id());

    //     // Get the 10 most recent invoices (either created or edited)
    //         $invoices = Invoice::where('user_id', auth()->id())
    //         ->orderBy('updated_at', 'desc') // Order by the latest edit
    //         ->orderBy('created_at', 'desc') // Order by the latest creation if updated_at is the same
    //         ->take(10) // Get only 10 records
    //         ->get();

    //     return view('dashboard', compact('invoices'));
    // }

    public function dashboard()
    {

        Invoice::updateOverduePendingInvoices(auth()->id());
        $user = Auth::user();

        $totalInvoices = Invoice::where('user_id', auth()->id())->count();
        $sentInvoices = Invoice::where('user_id', auth()->id())->where('sender_name', $user->name)->count(); // Adjust based on your logic for sent invoices
        $receivedInvoices = Invoice::where('user_id', auth()->id())->where('sender_name', '!=',  $user->name)->count(); // Adjust based on your logic for received invoices

        $paidCount = Invoice::where('user_id', auth()->id())->where('payment_status', 'paid')->count();
        $pendingCount = Invoice::where('user_id', auth()->id())->where('payment_status', 'pending')->count();
        $overdueCount = Invoice::where('user_id', auth()->id())->where('payment_status', 'unpaid')->count();

        $paidPercentage = $totalInvoices > 0 ? ($paidCount / $totalInvoices) * 100 : 0;
        $pendingPercentage = $totalInvoices > 0 ? ($pendingCount / $totalInvoices) * 100 : 0;
        $overduePercentage = $totalInvoices > 0 ? ($overdueCount / $totalInvoices) * 100 : 0;

        $invoices = Invoice::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc') // Order by the latest edit
            ->orderBy('created_at', 'desc') // Order by the latest creation if updated_at is the same
            ->take(10) // Get only 10 records
            ->get();

        return view('dashboard', compact('totalInvoices', 'sentInvoices', 'receivedInvoices', 'paidPercentage', 'pendingPercentage', 'overduePercentage','paidCount','pendingCount','overdueCount', 'invoices'));
    }


    // Fetch all invoices belonging to the currently logged-in user
    public function index()
    {
        $title = 'All Invoices List';
        Invoice::updateOverduePendingInvoices(auth()->id());

        $invoices = Invoice::where('user_id', auth()->id())->paginate(15); // 15 invoices per page
        return view('invoice.index', compact('invoices', 'title'));
    }

    public function search(Request $request)
    {
        $title = 'Found Invoices List';
        Invoice::updateOverduePendingInvoices(auth()->id());

        // Retrieve the search query from the request
        $query = $request->input('search');

        // Build the query to filter invoices based on the search input
        $invoices = Invoice::where('user_id', auth()->id())
            ->where(function($q) use ($query) {
                $q->where('invoice_num', 'like', "%$query%")
                  ->orWhere('sender_name', 'like', "%$query%")
                  ->orWhere('receiver_add', 'like', "%$query%")
                  ->orWhere('payment_status', 'like', "%$query%");
            })
            ->paginate(15); // 15 invoices per page

        // Return the search results view with the invoices
        return view('invoice.index', compact('invoices', 'title'));
    }

    // Fetch invoices where the logged-in user is the sender
    public function sentInvoices()
    {
        $title = 'Sent Invoices List';
        Invoice::updateOverduePendingInvoices(auth()->id());
        
        $user = Auth::user();
        $invoices = Invoice::where('user_id', auth()->id()) // Filter by user_id
            ->where('sender_name', $user->name) // Filter by sender_name
            ->paginate(10); // 10 invoices per page
        return view('invoice.index', compact('invoices', 'title'));
    }

    // Fetch invoices where the logged-in user is the receiver
    public function receivedInvoices()
    {
        $title = 'Received Invoices List';
        Invoice::updateOverduePendingInvoices(auth()->id());

        $user = Auth::user();
        $invoices = Invoice::where('user_id', auth()->id()) // Filter by user_id
            ->where('sender_name', '!=', $user->name) // Filter invoices where sender_name is not the logged-in user's name
            ->paginate(10); // 10 invoices per page
        return view('invoice.index', compact('invoices', 'title'));
    }

    public function paidInvoices()
    {
        $title = 'Paid Invoices List';
        Invoice::updateOverduePendingInvoices(auth()->id());

        $user = Auth::user();
        $invoices = Invoice::where('user_id', auth()->id()) // Filter by user_id
            ->where('payment_status', 'paid') // Filter by payment_status
            ->paginate(10); // 10 invoices per page
        return view('invoice.index', compact('invoices', 'title'));
    }

    public function pendingInvoices()
    {
        $title = 'Pending Invoices List';
        Invoice::updateOverduePendingInvoices(auth()->id());

        $user = Auth::user();
        $invoices = Invoice::where('user_id', auth()->id()) // Filter by user_id
            ->where('payment_status', 'pending') // Filter by payment_status
            ->paginate(10); // 10 invoices per page
        return view('invoice.index', compact('invoices', 'title'));
    }

    public function unpaidInvoices()
    {
        $title = 'Unpaid Invoices List';
        Invoice::updateOverduePendingInvoices(auth()->id());

        $user = Auth::user();
        $invoices = Invoice::where('user_id', auth()->id()) // Filter by user_id
            ->where('payment_status', 'unpaid') // Filter by payment_status
            ->paginate(10); // 10 invoices per page
        return view('invoice.index', compact('invoices', 'title'));
    }

    // Show the form to create a new invoice
    public function create(Request $request)
    {
        $selectedTemplate = $request->query('template', ''); // Get 'template' from query string, default to empty
        return view('invoice.create', compact('selectedTemplate'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'invoice_num' => 'nullable|string',
            'date' => 'required|date',
            'due_date' => 'nullable|date',
            'sender_name' => 'required|string',
            'sender_add' => 'required|string',
            'receiver_add' => 'required|string',
            'phone_num' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'account_num' => 'nullable|string',
            'total_price' => 'nullable|numeric',
            'template' => 'required|in:modern,minimalist',
            'payment_status' => 'required|in:paid,unpaid,pending',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string',
            'items.*.item_quantity' => 'required|integer|min:1',
            'items.*.item_unitPrice' => 'required|numeric|min:0',
        ]);

        $due_date = $request->due_date ?? \Carbon\Carbon::parse($request->date)->addDays(7)->toDateString();

        // Create invoice and automatically assign user_id
        $invoice = Invoice::create([
            'user_id' => auth()->id(),
            'invoice_num' => $request->invoice_num,
            'date' => $request->date,
            'due_date' => $due_date,
            'sender_name' => $request->sender_name,
            'sender_add' => $request->sender_add,
            'receiver_add' => $request->receiver_add,
            'phone_num' => $request->phone_num,
            'email' => $request->email,
            'website' => $request->website,
            'bank_name' => $request->bank_name,
            'account_num' => $request->account_num,
            'total_price' => $request->total_price,
            'template' => $request->template,
            'payment_status' => $request->payment_status,
        ]);

        // Create invoice items
        foreach ($request->items as $item) {
            Item::create([
                'invoice_id' => $invoice->invoice_id,
                'item_name' => $item['item_name'],
                'item_quantity' => $item['item_quantity'],
                'item_unitPrice' => $item['item_unitPrice'],
                'item_totalPrice' => $item['item_quantity'] * $item['item_unitPrice'],
            ]);
        }

        return redirect()->route('invoice.pdf', ['invoice_id' => $invoice->invoice_id])
            ->with('success', 'Invoice created successfully!');
    }


    // Show the form to edit an existing invoice
    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        // Check if the current user is the creator of the invoice
        if ($invoice->user_id !== auth()->id()) {
            // If not, return an unauthorized response or redirect
            return redirect()->route('invoice.index')->with('error', 'You are not authorized to edit this invoice.');
        }

        return view('invoice.edit', compact('invoice'));
    }

    // Update an existing invoice
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // Check if the current user is the creator of the invoice
        if ($invoice->user_id !== auth()->id()) {
            // If not, return an unauthorized response or redirect
            return redirect()->route('invoice.index')->with('error', 'You are not authorized to update this invoice.');
        }

        // Update invoice fields, excluding 'items'
        $invoice->update($request->except('items'));

        // Optional: delete removed items (if needed)
        $existingItemIds = collect($request->items)->pluck('id')->filter();
        $invoice->items()->whereNotIn('id', $existingItemIds)->delete();

        // Update or create each item
        foreach ($request->items as $itemData) {
            if (isset($itemData['id'])) {
                // Update existing item
                $item = Item::find($itemData['id']);
                if ($item) {
                    $item->update([
                        'item_name' => $itemData['item_name'],
                        'item_quantity' => $itemData['item_quantity'],
                        'item_unitPrice' => $itemData['item_unitPrice'],
                        'item_totalPrice' => $itemData['item_quantity'] * $itemData['item_unitPrice'],
                    ]);
                }
            } else {
                // Create new item linked to the invoice
                $invoice->items()->create([
                    'item_name' => $itemData['item_name'],
                    'item_quantity' => $itemData['item_quantity'],
                    'item_unitPrice' => $itemData['item_unitPrice'],
                    'item_totalPrice' => $itemData['item_quantity'] * $itemData['item_unitPrice'],
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Invoice updated successfully!');
    }

    public function scan(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['success' => false, 'message' => 'No image uploaded.']);
        }

        $image = $request->file('image');
        $imagePath = $image->store('invoices', 'public');

        // Send image to Flask API
        $response = Http::attach(
            'image', file_get_contents(storage_path('app/public/' . $imagePath)), $image->getClientOriginalName()
        )->post('http://127.0.0.1:5000/predict');

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'fields' => $response->json()
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to extract data.']);
        }
    }

    // Delete an invoice
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Delete all related items
        $invoice->items()->delete();

        // Delete the invoice itself
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully!');
    }
}

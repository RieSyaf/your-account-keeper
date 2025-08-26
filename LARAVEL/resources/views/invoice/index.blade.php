@extends('layout')

@section('content')

    <div class="container mt-4" style="border-radius: 50px; border: 10px solid rgb(204, 211, 214); background-color:rgb(112, 114, 115); padding-left: 50px; padding-right: 50px; padding-top: 30px; padding-bottom: 50px; margin-bottom: 100px">
        <div class="header-container d-flex justify-content-between align-items-center">
            <h1>{{$title}}</h1>

            <!-- Optional: Search bar -->
            <form action="{{ route('invoice.search') }}" method="GET">
                <input type="text" name="search" placeholder="Search keywords..." style="border-radius: 20px; width: 300px; height:35px; padding: 10px; border-color: rgb(204, 211, 214);" value="{{ request('search') }}">
                
            </form>
        </div>

        <div class="invoice-container mt-4" style="background-color: rgb(186, 190, 194); border-radius: 30px; padding: 30px; padding-right: 50px; padding-left: 50px; padding-top: 50px;">
            <table class="table table-hover table-bordered bg-white">
                <thead class="table-dark">
                    <tr style="text-align: center;">
                        <th>Num</th>
                        <th>Invoice No.</th>
                        <th>Sender</th>
                        <th>Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $index => $invoice)
                        <tr>
                            <td>{{ $invoices->firstItem() + $index }}</td>
                            <td>{{ $invoice->invoice_num }}</td>
                            <td>{{ $invoice->sender_name }}</td>
                            <td>{{ $invoice->date }}</td>
                            <td>{{ $invoice->due_date }}</td>
                            <td style="text-align: center;">
                                <span class="badge bg-{{ $invoice->payment_status === 'paid' ? 'success' : ($invoice->payment_status === 'pending' ? 'warning' : 'danger') }}" >
                                    {{ ucfirst($invoice->payment_status) }}
                                </span>
                            </td>
                            <td class="action-btns" style="text-align: center;">
                                <!-- View Button with Icon -->
                                <a href="{{ route('invoice.pdf', ['invoice_id' => $invoice->invoice_id]) }}" class="btn btn-info btn-sm" style="margin-right: 5px;"  title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit Button with Icon -->
                                <a href="{{ route('invoice.edit', $invoice->invoice_id) }}" class="btn btn-warning btn-sm" style="margin-right: 5px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Button with Icon -->
                                <form action="{{ route('invoice.destroy', $invoice->invoice_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this invoice?')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection

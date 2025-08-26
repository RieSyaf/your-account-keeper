@extends('layout')

@section('content')

    <div class="container mt-4" style="border-radius: 50px; border: 10px solid rgb(204, 211, 214); background-color:rgb(112, 114, 115); padding-left: 50px; padding-right: 50px; padding-top: 30px; padding-bottom: 50px; margin-bottom: 100px">
        <div class="header-container d-flex justify-content-between align-items-center">
            <!-- Add title or any other elements if needed -->
        </div>

        <!-- Visualization Row -->
        <div class="d-flex justify-content-between mt-4">
            <!-- Total Invoices and Create Button -->
            <div class="total-invoices" style="flex: 0 0 20%; text-align: center; background-color: rgb(186, 190, 194); padding: 20px; border-radius: 30px; margin-right: 20px;">
                <h3>Invoices Saved</h3>
                <h3 style="font-size: 50px;">{{ $totalInvoices }}</h3> <!-- Assuming you pass the total invoice count from controller -->
                <h5>Sent: {{ $sentInvoices }} | Received: {{ $receivedInvoices }}</h5> <!-- Pass sent/received counts from controller -->
                <a href="{{ route('invoice.create') }}" class="btn btn-primary mt-3" style="background-color: rgb(112, 114, 115); font-color: rgb(186, 190, 194); font-size: 20px; font-family: Times New Roman; border: 5px solid; border-radius: 100px; border-color: rgb(8, 9, 9);">Create Invoice</a>
            </div>

            <!-- Payment Status Progression Bar -->
            <div class="payment-progress" style="flex: 0 0 60%; text-align: center; background-color: rgb(186, 190, 194); padding: 20px; display: flex; flex-direction: column; border-top-left-radius: 30px; border-bottom-left-radius: 30px; margin-right: 0px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h5 style="font-size: 50px; text-align: left; margin-top: 30px; flex: 1;">Payments</h5>
                    <div class="legend" style="font-size: 18px; display: flex; align-items: left; justify-content: flex-end;">
                        <div style="display: flex; align-items: center; margin-left: 15px;">
                            <span class="badge bg-success" style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                            <span>Paid</span>
                        </div>
                        <div style="display: flex; align-items: center; margin-left: 15px;">
                            <span class="badge bg-warning" style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                            <span>Pending</span>
                        </div>
                        <div style="display: flex; align-items: center; margin-left: 15px;">
                            <span class="badge bg-danger" style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                            <span>Unpaid</span>
                        </div>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="progress" style="height: 30px; border-radius: 50px; margin-top: 50px; position: relative;">
                    <div class="progress-bar bg-success" style="width: {{ $paidPercentage }}%"
                         data-bs-toggle="tooltip" data-bs-placement="top" title="Paid: {{ ($paidCount) }} invoices"></div>
                    <div class="progress-bar bg-warning" style="width: {{ $pendingPercentage }}%"
                         data-bs-toggle="tooltip" data-bs-placement="top" title="Pending: {{ ($pendingCount) }} invoices"></div>
                    <div class="progress-bar bg-danger" style="width: {{ $overduePercentage }}%"
                         data-bs-toggle="tooltip" data-bs-placement="top" title="Overdue: {{ ($overdueCount) }} invoices"></div>
                </div>
            </div>

            <div class="pay-button" style="flex: 1; text-align: center; background-color: rgb(186, 190, 194); padding: 20px; border-top-right-radius: 30px; border-bottom-right-radius: 30px; margin-right: 0px; margin-left: 0px; padding-top: 35px;">
                <a href="{{ route('invoice.unpaid') }}" class="btn btn-primary mt-3" style="background-color: rgb(112, 114, 115); font-color: rgb(186, 190, 194); font-size: 20px; font-family: Times New Roman; border: 5px solid; border-radius: 30px; border-color: rgb(8, 9, 9);
                    display: block; width: 150px; height: 150px; text-align: center; padding: 0; line-height: 60px;">
                    <span style="display: block; font-size: 50px; margin-top: 10px;">Pay</span><span style="display: block; font-size: 50px;">Now</span>
                </a>
            </div>
        </div>

        <!-- Invoice List -->
        <div class="invoice-container mt-4" style="background-color: rgb(186, 190, 194); border-radius: 30px; padding: 30px; padding-right: 50px; padding-left: 50px;">
            <h2 style="font-size: 50px; color: rgb(112, 114, 115); font-family: Times New Roman; text-align:center;">Recent Activities</h2>
            <table class="table table-hover table-bordered bg-white">
                <thead class="table-dark">
                    <tr style="text-align: center;">
                        <th>Num</th>
                        <th>Invoice No.</th>
                        <th>Sender</th>
                        <th>Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Last Modified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($invoices as $index => $invoice)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $invoice->invoice_num }}</td>
                        <td>{{ $invoice->sender_name }}</td>
                        <td>{{ $invoice->date }}</td>
                        <td>{{ $invoice->due_date }}</td>
                        <td style="text-align: center;">
                            <span class="badge bg-{{ $invoice->payment_status === 'paid' ? 'success' : ($invoice->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($invoice->payment_status) }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            {{ $invoice->updated_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="action-btns" style="text-align: center;">
                                <a href="{{ route('invoice.pdf', ['invoice_id' => $invoice->invoice_id]) }}" class="btn btn-info btn-sm" style="margin-right: 5px;"  title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('invoice.edit', $invoice->invoice_id) }}" class="btn btn-warning btn-sm" style="margin-right: 5px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

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
                        <td colspan="8" class="text-center">No invoices found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });
    </script>

@endsection

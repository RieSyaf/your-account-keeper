<!DOCTYPE html>
<html>
<head>
    <title>Invoice - Fancy Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">


    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            background-image: url("{{ public_path('in_temp_bg/fancy.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 20px;
            font-family: 'Courier', monospace;
        }

        .container {
            width: 70%;
            margin: auto;
            background: none;
        }
        .title {
            text-align: center;
            margin-top: 40px;
        }
        .invoice-details, .payment-details {
            width: 100%;
            margin-bottom: 20px;
        }
        .invoice-details p, .payment-details p {
            margin: 5px 0;
        }
        .address-container {
            width: 100%;
            margin-bottom: 20px;
        }
        .address-container p {
            margin: 0;
        }
        .address-table {
            width: 100%;
            border-collapse: collapse;
        }
        .address-table td {
            width: 50%;
            vertical-align: top;
            padding: 10px;
        }
        .table {
            width: 100%;
        }
        .table th, .table td {
            padding: 8px;
        }
        .total-details {
            margin-top: 20px;
            text-align: right;
        }
        .grand-total {
            font-weight: bold;
            background-color: #4d4b4b;
            font-size: 20px;
            color: #fefeff;
            padding: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="title">
            <h1 style="margin-top: 50px">{{ $title }}</h1>
        </div>

        <div class="invoice-details">
            <h2>Invoice Details</h2>
            <p><strong>Invoice No:</strong> {{ $invoice_no }}</p>
            <p><strong>Invoice Date:</strong> {{ $invoice_date }}</p>
            <p><strong>Due Date:</strong> {{ $due_date }}</p>
        </div>

        <div class="address-container">
            <table class="address-table">
                <tr>
                    <td>
                        <h3>From:</h3>
                        <p><strong>{{ $sender_name }}</strong></p>
                        <p>{{ $sender_address }}</p>
                        <br>
                        @if($phone_num)
                            <p>Phone: {{ $phone_num }}</p>
                        @endif
                        @if($email)
                            <p>Email: {{ $email }}</p>
                        @endif
                        @if($website)
                            <p>Website: {{ $website }}</p>
                        @endif
                    </td>
                    <td>
                        <h3>To:</h3>
                        <p><strong>{{ $receiver_address }}</strong></p>
                    </td>
                </tr>
            </table>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($items as $index => $item)
                    @php
                        $lineTotal = $item->item_quantity * $item->item_unitPrice;
                        $grandTotal += $lineTotal;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->item_quantity }}</td>
                        <td>RM {{ number_format($item->item_unitPrice, 2) }}</td>
                        <td>RM {{ number_format($lineTotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-details">
            @if($total_price > $grandTotal)
                <p><strong>Tax: RM</strong> {{ number_format($total_price - $grandTotal, 2) }}</p>
            @elseif($grandTotal > $total_price)
                <p><strong>Discount: RM</strong> {{ number_format($grandTotal - $total_price, 2) }}</p>
            @endif
            <span class="grand-total">Grand Total: RM {{ number_format($total_price, 2) }}</span>
        </div>

        <div class="payment-details">
            @if($bank_name || $account_num)
                <h2>Payment Details</h2>
                @if($bank_name)
                    <p>Bank Name: {{ $bank_name }}</p>
                @endif
                @if($account_num)
                    <p>Account Number: {{ $account_num }}</p>
                @endif
            @endif
        </div>
    </div>

</body>
</html>

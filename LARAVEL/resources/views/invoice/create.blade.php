@extends('layout')

@section('content')
<div class="container">
    <h1 style=" text-align : center;">Create Invoice</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Message --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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
        .form-label .required-asterisk {
            color: red;
            margin-left: 3px;
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

    <div class="mb-3">
        <label for="invoice_image" class="form-label">Upload Invoice Image (Scan)</label>
        <input type="file" name="invoice_image" id="invoice_image" class="form-control" accept="image/*">
    </div>
    <button type="button" class="btn btn-info" id="scan-invoice-btn">Scan</button>
    <div id="scan-status" style="margin-top: 10px;"></div>
    <img id="invoice-preview" src="#" alt="Invoice Preview" style="max-width: 100%; margin-top: 10px; display: none;">



    <div class="form-container">
        <form action="{{ route('invoice.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="invoice_num" class="form-label">Invoice Number<span class="required-asterisk">*</span></label>
                <input type="text" name="invoice_num" class="form-control" value="{{ old('invoice_num') }}" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date<span class="required-asterisk">*</span></label>
                <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" >
            </div>

            <div class="mb-3">
                <label for="sender_name" class="form-label">Sender Name<span class="required-asterisk">*</span></label>
                <input type="text" name="sender_name" class="form-control" value="{{ old('sender_name', auth()->user()->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="sender_add" class="form-label">Sender Address<span class="required-asterisk">*</span></label>
                <textarea name="sender_add" class="form-control" required>{{ old('sender_add', auth()->user()->address) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="receiver_add" class="form-label">Receiver Address (include receiver's name)<span class="required-asterisk">*</span></label>
                <textarea name="receiver_add" class="form-control" required>{{ old('receiver_add') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="phone_num" class="form-label">Phone Number</label>
                <input type="number" name="phone_num" class="form-control" value="{{ old('phone_num', auth()->user()->phone_num) }}">
            </div>

            <!-- <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_num" 
                    value="{{ old('phone_num', auth()->user()->phone_num) }}" 
                    class="form-control" 
                    pattern="\d+" 
                    inputmode="numeric"
                    title="Please enter numbers only">
            </div> -->

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}">
            </div>

            <div class="mb-3">
                <label for="website" class="form-label">Website</label>
                <input type="text" name="website" class="form-control" value="{{ old('website', auth()->user()->website) }}">
            </div>

            <div class="mb-3">
                <label for="bank_name" class="form-label">Bank Name</label>
                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', auth()->user()->bank_name) }}">
            </div>

            <div class="mb-3">
                <label for="account_num" class="form-label">Account Number</label>
                <input type="number" name="account_num" class="form-control" value="{{ old('account_num', auth()->user()->acc_num) }}">
            </div>

            <!-- <div class="mb-3">
                <label class="form-label">Account Number</label>
                <input type="text" name="acc_num" 
                    value="{{ old('account_num', auth()->user()->acc_num) }}" 
                    class="form-control" 
                    pattern="\d+" 
                    inputmode="numeric"
                    title="Please enter numbers only">
            </div> -->

            <div class="mb-3">
                <label for="template" class="form-label">Template<span class="required-asterisk">*</span></label>
                <select name="template" class="form-control" required>
                    <option value="">-- Select Template --</option>
                    <option value="modern" {{ old('template', $selectedTemplate) == 'modern' ? 'selected' : '' }}>Modern</option>
                    <option value="minimalist" {{ old('template', $selectedTemplate) == 'minimalist' ? 'selected' : '' }}>Minimalist</option>
                    <option value="fancy" {{ old('template', $selectedTemplate) == 'fancy' ? 'selected' : '' }}>Fancy</option>
                    <option value="chill" {{ old('template', $selectedTemplate) == 'chill' ? 'selected' : '' }}>Chill</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="payment_status" class="form-label">Payment Status<span class="required-asterisk">*</span></label>
                <select name="payment_status" class="form-control" required>
                    <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="total_invoice_price" class="form-label">Total Price</label>
                <input type="number" step="0.01" name="total_price" id="total_price" class="form-control" value="{{ old('total_price') }}">
            </div>

            <h4>Items<span class="required-asterisk">*</span></h4>
            <div id="items" class="mb-3">
                @php
                    $oldItems = old('items', [['item_name' => '', 'item_quantity' => '', 'item_unitPrice' => '', 'item_totalPrice' => '']]);
                @endphp

                @foreach ($oldItems as $index => $item)
                    <div class="item-group">
                        <input type="text" name="items[{{ $index }}][item_name]" placeholder="Item Name" class="form-control" required value="{{ $item['item_name'] }}">
                        <input type="number" name="items[{{ $index }}][item_quantity]" placeholder="Quantity" class="form-control quantity" required value="{{ $item['item_quantity'] }}">
                        <input type="number" step="0.01" name="items[{{ $index }}][item_unitPrice]" placeholder="Unit Price" class="form-control unitPrice" required value="{{ $item['item_unitPrice'] }}">
                        <input type="number" step="0.01" name="items[{{ $index }}][item_totalPrice]" placeholder="Total Price" class="form-control item-total-price" required value="{{ $item['item_totalPrice'] }}">
                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>

            <br><br>
            <button type="submit" class="btn btn-primary">Create Invoice</button>
        </form>
    </div>
</div>

<script>
    
    // Dynamically add new item row
    document.getElementById('add-item').addEventListener('click', function () {
        const itemsDiv = document.getElementById('items');
        const index = itemsDiv.children.length;

        const newItemGroup = document.createElement('div');
        newItemGroup.className = 'item-group';
        newItemGroup.innerHTML = `
            <input type="text" name="items[${index}][item_name]" placeholder="Item Name" class="form-control" required>
            <input type="number" name="items[${index}][item_quantity]" placeholder="Quantity" class="form-control quantity" required>
            <input type="number" step="0.01" name="items[${index}][item_unitPrice]" placeholder="Unit Price" class="form-control unitPrice" required>
            <input type="number" step="0.01" name="items[${index}][item_totalPrice]" placeholder="Total Price" class="form-control item-total-price" required>
            <button type="button" class="btn btn-danger remove-item">Remove</button>
        `;
        itemsDiv.appendChild(newItemGroup);
        bindItemEvents(); // bind events to new inputs
    });

    // Remove item row
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-item')) {
            e.target.parentElement.remove();
            calculateTotalPrice(); // recalculate after removal
        }
    });

    function bindItemEvents() {
        document.querySelectorAll('.quantity, .unitPrice').forEach(input => {
            input.removeEventListener('input', calculateTotalPrice); // prevent duplicate bindings
            input.addEventListener('input', calculateTotalPrice);
        });
    }

    function calculateTotalPrice() {
        let total = 0;
        document.querySelectorAll('.item-group').forEach(group => {
            const qty = parseFloat(group.querySelector('.quantity')?.value) || 0;
            const unit = parseFloat(group.querySelector('.unitPrice')?.value) || 0;
            const itemTotal = qty * unit;
            group.querySelector('.item-total-price').value = itemTotal.toFixed(2);
            total += itemTotal;
        });

        const totalPriceInput = document.getElementById('total_price');
        const currentValue = parseFloat(totalPriceInput.value);

        // Only update if the value is missing, empty, or 0
        if (!currentValue || isNaN(currentValue)) {
            totalPriceInput.value = total.toFixed(2);
        }

        if (currentValue < total) {
            totalPriceInput.value = total.toFixed(2);
        }
    }

    // Initial binding and calculation
    bindItemEvents();
    calculateTotalPrice();

    document.getElementById('invoice_image').addEventListener('change', function () {
        const file = this.files[0];
        const preview = document.getElementById('invoice-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });

    document.getElementById('scan-invoice-btn').addEventListener('click', async function () {
        const fileInput = document.getElementById('invoice_image');
        const file = fileInput.files[0];

        if (!file) {
            alert('Please upload an image before scanning.');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        document.getElementById('scan-status').innerText = 'Scanning...';

        try {
            const response = await fetch('http://127.0.0.1:5000/predict', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Scan failed.');

            const data = await response.json();
            const invoice = data.invoice_data;

            document.getElementById('scan-status').innerText = 'Scan successful! Data loaded.';

            // Fill form fields
            document.querySelector('input[name="invoice_num"]').value = invoice.invoice_num || '';
            document.querySelector('input[name="date"]').value = invoice.invoice_date || '';
            document.querySelector('input[name="due_date"]').value = invoice.due_date || '';
            document.querySelector('input[name="sender_name"]').value = invoice.sender || '';
            document.querySelector('textarea[name="sender_add"]').value = ''; // Add if you have this info
            document.querySelector('textarea[name="receiver_add"]').value = ''; // Add if you have this info
            document.querySelector('input[name="phone_num"]').value = invoice.phone_num || '';
            document.querySelector('input[name="email"]').value = invoice.email || '';
            document.querySelector('input[name="website"]').value = invoice.website || '';
            document.querySelector('input[name="bank_name"]').value = invoice.bank_name || '';
            document.querySelector('input[name="account_num"]').value = invoice.account_num || '';
            document.querySelector('select[name="payment_status"]').value = 'pending'; // default
            document.querySelector('[name="total_price"]').value = invoice.total_invoice_price || '';

            const itemsContainer = document.getElementById('items');
            itemsContainer.innerHTML = '';

            (data.items || []).forEach((item, index) => {
                const itemGroup = document.createElement("div");
                itemGroup.classList.add("item-group");

                itemGroup.innerHTML = `
                    <input type="text" name="items[${index}][item_name]" placeholder="Item Name" class="form-control" required value="${item.item_name || ''}">
                    <input type="number" name="items[${index}][item_quantity]" placeholder="Quantity" class="form-control quantity" required value="${item.quantity || 0}">
                    <input type="number" step="0.01" name="items[${index}][item_unitPrice]" placeholder="Unit Price" class="form-control unitPrice" required value="${item.price || 0}">
                    <input type="number" step="0.01" name="items[${index}][item_totalPrice]" placeholder="Total Price" class="form-control item-total-price" required value="${item.total_price || 0}">
                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                `;
                itemsContainer.appendChild(itemGroup);
            });

            // calculateTotalPrice();
        } catch (error) {
            document.getElementById('scan-status').innerText = 'Scan failed. Please try again.';
            console.error(error);
        }
    });

</script>

@endsection




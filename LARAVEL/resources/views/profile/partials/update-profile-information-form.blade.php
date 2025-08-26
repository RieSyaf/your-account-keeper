<style>
    .form-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: rgb(186, 190, 194);
        border-radius: 15px;
        padding: 5px;
        margin-top: 25px;
        width: 100%;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="form-container">
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone_num" 
                value="{{ old('phone_num', auth()->user()->phone_num) }}" 
                class="form-control" 
                pattern="\d+" 
                inputmode="numeric"
                title="Please enter numbers only">
        </div>

        <div class="mb-3">
            <label class="form-label">Account Number</label>
            <input type="text" name="acc_num" 
                value="{{ old('acc_num', auth()->user()->acc_num) }}" 
                class="form-control" 
                pattern="\d+" 
                inputmode="numeric"
                title="Please enter numbers only">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address', auth()->user()->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Bank Name</label>
            <input type="text" name="bank_name" value="{{ old('bank_name', auth()->user()->bank_name) }}" class="form-control">
        </div>

        

        <div class="mb-3">
            <label class="form-label">Website</label>
            <input type="text" name="website" value="{{ old('website', auth()->user()->website) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" style="display: block; margin: 0 auto;">Save Changes</button>
    </form>
</div>

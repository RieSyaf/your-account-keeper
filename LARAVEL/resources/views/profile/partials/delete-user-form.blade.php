<div class="form-container" style="align-items: center; text-align: center;">
    <p>Are you sure you want to delete your account?</p>

    <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        @error('userDeletion.password')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <button type="button" class="btn btn-danger" id="delete-account-button">
            Delete Account
        </button>
    </form>
</div>

<script>
    document.getElementById('delete-account-button').addEventListener('click', function(event) {
        event.preventDefault();

        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            document.getElementById('delete-account-form').submit();
        }
    });
</script>

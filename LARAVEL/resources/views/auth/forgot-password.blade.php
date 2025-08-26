<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset | Your Account Keeper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e2229;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            background-color: rgb(186, 190, 194);
            border-radius: 15px;
            padding: 30px;
            margin-top: 60px;
            margin-bottom: 60px;
            width: 100%;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-title {
            text-align: center;
            font-size: 50px;
            font-weight: bold;
            margin-top: 20px;
            font-family: Courier Prime;
            color: rgb(186, 190, 194);
        }

        .btn-primary {
            background-color: #0d6efd;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .form-check-label {
            margin-left: 8px;
        }

        .flex-end {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-label {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container" style="border: 10px solid rgb(186, 190, 194); border-radius: 30px; padding: 10px; margin-top: 50px; width: 50%;">
        <div class="form-title">YOUR ACCOUNT KEEPER.</div>

        <div class="form-container">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Button -->
                <div class="flex-end">
                    <button type="submit" class="btn-primary" style="background-color:#1e2229;">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

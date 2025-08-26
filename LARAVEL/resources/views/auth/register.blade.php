<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Your Account Keeper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:#1e2229;
            background-image: url('/loginbg3.jpg'); /* Adjust filename and path */
            background-size: cover;      
            background-repeat: no-repeat;
            background-position: center center;
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

        .alert {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-sm {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container" style="border: 10px solid rgb(186, 190, 194); border-radius: 30px; padding: 10px; margin-top: 50px; width: 50%;">
        <div class="form-title">YOUR ACCOUNT KEEPER.</div>

        <div class="form-container">
            @if (session('status'))
                <div class="alert text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Company Name</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required>
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex-end">
                    <a href="{{ route('login') }}" class="text-sm text-decoration-underline">Already registered?</a>
                    <button type="submit" class="btn-primary" style="background-color:#1e2229;">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- You can include your stylesheets here -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            padding: 50px;
        }

        .reset-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="password"] {
            margin-bottom: 15px;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .alert {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="reset-container">
    <h2>Password Reset</h2>

    <!-- Display any errors or messages here -->
    @if(session('status'))
        <div class="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Password Reset Form -->
    <form action="{{ route('resetPassword') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <!-- Email -->
    <input type="email" name="email" required placeholder="Email">
    
    <!-- Password -->
    <input type="password" name="password" required placeholder="New Password">
    
    <!-- Password Confirmation -->
    <input type="password" name="password_confirmation" required placeholder="Confirm Password">
    
    <button type="submit">Reset Password</button>
</form>

</div>

</body>
</html>

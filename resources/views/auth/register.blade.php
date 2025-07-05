<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Tal System Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --gray-light: #e2e8f0;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4f0fb 100%);
            color: var(--dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            width: 100%;
            max-width: 480px;
            padding: 2rem;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            padding: 3rem;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="25" cy="25" r="3" fill="%23e0e7ff"/><circle cx="75" cy="25" r="3" fill="%23e0e7ff"/><circle cx="50" cy="50" r="3" fill="%23e0e7ff"/><circle cx="25" cy="75" r="3" fill="%23e0e7ff"/><circle cx="75" cy="75" r="3" fill="%23e0e7ff"/></svg>');
            background-size: 100px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .back-button {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .logo {
            height: 100px;
            object-fit: contain;
        }

        h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary);
            text-align: center;
        }

        .subtitle {
            color: var(--gray);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--gray);
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: var(--primary);
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
        }

        .decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(to right, rgba(79, 70, 229, 0.1), rgba(245, 158, 11, 0.1));
            filter: blur(60px);
            z-index: 0;
        }

        .decoration-1 {
            top: -100px;
            left: -100px;
        }

        .decoration-2 {
            bottom: -100px;
            right: -100px;
        }

        @media (max-width: 640px) {
            .register-card {
                padding: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column-reverse;
                gap: 1rem;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="decoration decoration-1"></div>
            <div class="decoration decoration-2"></div>

            <div class="logo-container">
                <button onclick="window.history.back()" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <img src="/images/sweet.png" alt="Tal System Management" class="logo">
            </div>

            <h2>Create Your Account</h2>
            <p class="subtitle">Join us to start managing your inventory</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" class="input-field" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @if ($errors->has('name'))
                        <div class="error-message">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @if ($errors->has('email'))
                        <div class="error-message">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" class="input-field" type="password" name="password" required autocomplete="new-password">
                    @if ($errors->has('password'))
                        <div class="error-message">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required autocomplete="new-password">
                    @if ($errors->has('password_confirmation'))
                        <div class="error-message">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <div class="action-buttons">
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        <i class="fas fa-sign-in-alt"></i> Already registered?
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

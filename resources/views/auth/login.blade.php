<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Tal System Management</title>

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

        .login-container {
            width: 100%;
            max-width: 480px;
            padding: 2rem;
        }

        .login-card {
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
        }

        .logo {
            height: 100px;
            object-fit: contain;
            margin-bottom: 1rem;
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

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input {
            margin-right: 0.5rem;
            accent-color: var(--primary);
        }

        .remember-me label {
            margin-bottom: 0;
            font-weight: 500;
            color: var(--gray);
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
            width: 100%;
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

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--gray);
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary);
        }

        .status-message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            background-color: var(--gray-light);
            color: var(--dark);
            text-align: center;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
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


        @media (max-width: 640px) {
            .login-card {
                padding: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">

        <div class="login-card">
            <div class="decoration decoration-1"></div>
            <div class="decoration decoration-2"></div>

            <div class="logo-container">
                <img src="/images/sweet.png" alt="Tal System Management" class="logo">
            </div>

            <h2>Welcome Back</h2>
            <p class="subtitle">Please enter your credentials to access your account</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @if ($errors->has('email'))
                        <div class="error-message">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" class="input-field" type="password" name="password" required autocomplete="current-password">
                    @if ($errors->has('password'))
                        <div class="error-message">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Log In
                </button>

                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </form>
        </div>
    </div>
</body>
</html>

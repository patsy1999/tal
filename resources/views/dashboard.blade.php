@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ __('Dashboard Overview') }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                {{ now()->format('l, F j, Y') }}
            </p>
        </div>
        <div class="mt-3 sm:mt-0">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Regular User' }}
            </span>
        </div>
    </div>
@endsection

@section('content')
    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 capitalize">
                            Welcome, {{ auth()->user()->name }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ __("Here's your account summary") }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ auth()->user()->role === 'admin' ? 'Admin Access' : 'Standard Access' }}
                        </span>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">
                                Account Type
                            </p>
                            <p class="text-lg font-semibold text-gray-900 capitalize">
                                {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Regular User' }} account
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="px-6 py-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('products.index') }}" class="group flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition duration-150">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-900 group-hover:text-blue-600">
                                Manage Products
                            </h4>
                            <p class="text-sm text-gray-500">
                                Full administration
                            </p>
                        </div>
                        <div class="ml-auto text-blue-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                @endif

                <!-- Temperature Log for all users -->
                <a href="{{ route('dashboard.links') }}" class="group flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:shadow-md transition duration-150">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900 group-hover:text-green-600">
                            Tracking Operations
                        </h4>
                        <p class="text-sm text-gray-500">
                            Record  data
                        </p>
                    </div>
                    <div class="ml-auto text-green-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <!-- Product browsing for regular users with tools icon -->
                @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('user.products.list') }}" class="group flex items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:shadow-md transition duration-150">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-900 group-hover:text-indigo-600">
                                Browse Products
                            </h4>
                            <p class="text-sm text-gray-500">
                                View available items
                            </p>
                        </div>
                        <div class="ml-auto text-indigo-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                @endif
            </div>
            {{-- <form method="POST" action="{{ route('send.report.email') }}" class="styled-form">
    @csrf
    <div class="form-group">
        <label for="email" class="form-label">Envoyer à :</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="exemple@email.com" required>
    </div>
    <button type="submit" class="submit-btn">
        <i class="fas fa-paper-plane me-1"></i> Envoyer le PDF
    </button>
</form> --}}
@auth
    @if(auth()->user()->role === 'admin')
    <form action="{{ route('dashboard.send-report-email') }}" method="POST" onsubmit="return confirm('Envoyer le rapport par email ?')" class="email-report-form">
        @csrf
        <div class="form-header">
            <h3><i class="fas fa-paper-plane"></i> Send Withdrawal Rapport</h3>
            <p>Envoyez le rapport PDF par email</p>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Adresse Email</label>
            <div class="input-container">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l'email" required>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="submit-btn">
                <i class="fas fa-paper-plane"></i> Envoyer le rapport
            </button>
        </div>
    </form>
    @auth
    @if(auth()->user()->role === 'admin')
         <form action="{{ route('products.send-stock-report') }}" method="POST" onsubmit="return confirm('Envoyer le rapport par email ?')" class="email-report-form">
        @csrf
        <div class="form-header">
            <h3><i class="fas fa-paper-plane"></i> Send Stock Rapport</h3>
            <p>Envoyez le rapport PDF par email</p>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Adresse Email</label>
            <div class="input-container">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l'email" required>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="submit-btn">
                <i class="fas fa-paper-plane"></i> Envoyer le rapport
            </button>
        </div>
    </form>
    @endif
@endauth


    <style>
        .email-report-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .form-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-header h3 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .form-header p {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #34495e;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 40px;
            font-size: 0.95rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
            color: #2c3e50;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            background-color: white;
        }

        .form-footer {
            margin-top: 2rem;
            text-align: center;
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 12px 24px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .email-report-form {
                padding: 1.5rem;
            }
        }
    </style>

 @endif
@endauth




            <!-- Recent Activity -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Your Activity
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">
                                You logged in {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'some time ago' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 {{ auth()->user()->role === 'admin' ? 'text-purple-400' : 'text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">
                                You have {{ auth()->user()->role === 'admin' ? 'administrator' : 'regular user' }} privileges
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

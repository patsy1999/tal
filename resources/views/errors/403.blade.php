@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div class="text-center">
            <!-- Error Icon -->
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                </svg>
            </div>

            <!-- Heading -->
            <h1 class="text-3xl font-bold text-slate-800 mb-4">
                Access Restricted
            </h1>

            <!-- Message -->
            <p class="text-slate-600 mb-8">
                You don't have permission to access this page. Please contact your administrator if you believe this is an error.
            </p>

            <!-- Fixed Button Group -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <!-- Back Button -->
                <a href="{{ url()->previous() }}"
                   class="flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Go Back
                </a>

                <!-- Dashboard Button -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-slate-200">
                <p class="text-sm text-slate-500">
                    Need help? <span  class="text-blue-600 hover:underline">Contact support</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection


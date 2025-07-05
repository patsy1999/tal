@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8 bg-white shadow-md rounded-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Add Product</h2>

    <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input
                id="name"
                name="name"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select
                id="type"
                name="type"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >
                <option value="">-- Select Type --</option>
                <option value="Électrique">Électrique</option>
                <option value="Mécanique">Mécanique</option>
            </select>
        </div>

        <div>
            <label for="prix" class="block text-sm font-medium text-gray-700 mb-1">Price (MAD)</label>
            <input
                id="prix"
                name="prix"
                type="number"
                step="0.01"
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >
        </div>

        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
            <input
                id="quantity"
                name="quantity"
                type="number"
                min="0"
                max="1000"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition"
            >
                <!-- Save Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7" />
                </svg>
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection

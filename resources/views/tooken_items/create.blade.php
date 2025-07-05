@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6 mt-6">
    <!-- Header -->
    <div class="flex items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
        </svg>
        <h2 class="text-2xl font-bold text-gray-800">Product Withdrawal</h2>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <h3 class="font-medium text-red-800">Please correct these issues:</h3>
            </div>
            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('take-product.store') }}" id="takeForm" class="space-y-6">
        @csrf

        <!-- Type Filter -->
        <div>
            <label for="typeFilter" class="block text-sm font-medium text-gray-700 mb-1">Filter by Category</label>
            <select id="typeFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <option value="">All Categories</option>
                @foreach($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <!-- Product Select -->
        <div>
            <label for="productSelect" class="block text-sm font-medium text-gray-700 mb-1">Select Product</label>
            <select name="product_id" id="productSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                <option value="">-- Select a product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                            data-type="{{ $product->type }}"
                            data-name="{{ $product->name }}"
                            data-quantity="{{ $product->quantity }}"
                            data-price="{{ $product->prix }}">
                        {{ $product->name }} ({{ $product->type }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Product Details Card -->
        <div id="productDetails" class="hidden p-4 bg-gray-50 border border-gray-200 rounded-lg transition-all duration-300">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</p>
                    <p id="pd-name" class="font-medium text-gray-800">-</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Category</p>
                    <p id="pd-type" class="font-medium text-gray-800">-</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Available Stock</p>
                    <p id="pd-quantity" class="font-medium text-gray-800">-</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</p>
                    <p id="pd-price" class="font-medium text-gray-800">- MAD</p>
                </div>
            </div>
        </div>

        <!-- Quantity -->
        <div>
            <label for="takeQuantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity to Withdraw</label>
            <input type="number" name="quantity" id="takeQuantity"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                   min="1" required>
        </div>

        <!-- Reason -->
        <div>
            <label for="reasonSelect" class="block text-sm font-medium text-gray-700 mb-1">Withdrawal Reason</label>
            <select name="reason" id="reasonSelect"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                @foreach($reasons as $reason)
                    <option value="{{ $reason }}">{{ $reason }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                </svg>
                Process Withdrawal
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('productSelect');
        const detailsBox = document.getElementById('productDetails');
        const pdName = document.getElementById('pd-name');
        const pdType = document.getElementById('pd-type');
        const pdQuantity = document.getElementById('pd-quantity');
        const pdPrice = document.getElementById('pd-price');
        const typeFilter = document.getElementById('typeFilter');
        const takeQuantity = document.getElementById('takeQuantity');

        // Update product details when selection changes
        productSelect.addEventListener('change', () => {
            const selected = productSelect.selectedOptions[0];
            if (!selected || !selected.dataset.name) {
                detailsBox.classList.add('hidden');
                return;
            }

            pdName.textContent = selected.dataset.name;
            pdType.textContent = selected.dataset.type;
            pdQuantity.textContent = selected.dataset.quantity;
            pdPrice.textContent = selected.dataset.price;

            // Set max quantity based on available stock
            takeQuantity.max = selected.dataset.quantity;

            // Show details with animation
            detailsBox.classList.remove('hidden');
            detailsBox.classList.add('animate-fade-in');
        });

        // Filter products by type
        typeFilter.addEventListener('change', () => {
            const selectedType = typeFilter.value;
            Array.from(productSelect.options).forEach(option => {
                if (!option.dataset.type) return;
                option.style.display = selectedType === '' || option.dataset.type === selectedType
                    ? 'block' : 'none';
            });
            productSelect.value = '';
            detailsBox.classList.add('hidden');
        });

        // Form validation
        document.getElementById('takeForm').addEventListener('submit', function (e) {
            const selected = productSelect.selectedOptions[0];
            if (selected && parseInt(takeQuantity.value) > parseInt(selected.dataset.quantity)) {
                e.preventDefault();
                alert('Error: Cannot withdraw more than available quantity!');
            }
        });
    });
</script>

<style>
    /* Animation for details box */
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Custom select styling */
    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    /* Enhanced focus states */
    input:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
</style>
@endsection

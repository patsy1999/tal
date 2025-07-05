@extends('layouts.app')

@section('header')
<h1 class="mb-4 text-center elegant-title">Liste des Produits</h1>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
           <div class="flex flex-wrap gap-3 mt-3">
        <a href="{{ route('take-product.create') }}"
           class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            Withdraw Product
        </a>
    </div>
        <div class="col-md-8">
            <form method="GET" action="{{ auth()->user()->role === 'admin' ? route('products.index') : route('user.products.list') }}" class="search-form">
                <div class="search-container">
                    <div class="search-input-group">
                        <span class="search-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input type="text"
                               name="search"
                               placeholder="Rechercher un produit..."
                               value="{{ request('search') }}"
                               class="search-input">
                        @if(request('search'))
                            <button type="button" class="clear-search" onclick="clearSearch()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        @endif
                    </div>
                    <button type="submit" class="search-button">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rest of your table content remains the same -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Nom</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Prix</th>
                    <th class="text-center">Quantité</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="text-center align-middle">{{ $product->name }}</td>
                        <td class="text-center align-middle">{{ $product->type }}</td>
                        <td class="text-center align-middle">{{ number_format($product->prix, 2) }} MAD</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
    <div class="flex items-center justify-center">
        <span class="{{ $product->quantity < 6 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}
                     px-3 py-1 rounded-full text-xs font-medium inline-flex items-center">
            {{ $product->quantity }}
            @if($product->quantity < 6)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                </svg>
            @endif
        </span>
    </div>
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            Aucun produit disponible.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
    </div>
</div>

<style>
    /* Search Bar Styles */
    .search-container {
        display: flex;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-top: 40px

    }

    .search-container:focus-within {
        box-shadow: 0 4px 16px rgba(0, 123, 255, 0.2);
    }

    .search-input-group {
        position: relative;
        flex-grow: 1;
        display: flex;
        align-items: center;
        background: white;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        color: #6c757d;
    }

    .search-input {
        width: 100%;
        padding: 12px 20px 12px 48px;
        border: none;
        font-size: 16px;
        outline: none;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        padding-left: 48px;
    }

    .clear-search {
        position: absolute;
        right: 16px;
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
    }

    .clear-search:hover {
        color: #495057;
    }

    .search-button {
        padding: 0 24px;
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: white;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-button:hover {
        background: linear-gradient(135deg, #3a5ec2, #1a3a8f);
    }

    /* Table Styles (unchanged from your original) */
    .table {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .elegant-title {
    font-weight: 900;
    color: #2c3e50;
    position: relative;
    display: inline-block;
    padding-bottom: 8px;
    text-align: center;
    width: 100%; /* Ensure it takes full width */
}

.elegant-title:after {
    content: '';
    position: absolute;
    width: 60%;
    height: 3px;
    bottom: 0;
    left: 50%; /* Start from center */
    transform: translateX(-50%); /* Center precisely */
    background: linear-gradient(to right, transparent, #4e73df, transparent);
}
}
</style>

<script>
    function clearSearch() {
        const searchInput = document.querySelector('.search-input');
        searchInput.value = '';
        searchInput.focus();

        // Optional: Submit the form immediately after clearing
        searchInput.closest('form').submit();
    }
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container max-w-xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Product</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-semibold">Product Name</label>
            <input
                type="text"
                name="name"
                id="name"
                class="w-full border p-2 rounded"
                value="{{ old('name', $product->name) }}"
                required
            >
        </div>

        <div>
            <label for="type" class="block font-semibold">Type</label>
            <select
                name="type"
                id="type"
                class="w-full border p-2 rounded"
                required
            >
                <option value="">-- Select Type --</option>
                <option value="Électrique" {{ old('type', $product->type) == 'Électrique' ? 'selected' : '' }}>Électrique</option>
                <option value="Mécanique" {{ old('type', $product->type) == 'Mécanique' ? 'selected' : '' }}>Mécanique</option>
            </select>
        </div>

        <div>
            <label for="prix" class="block font-semibold">Price (MAD)</label>
            <input
                type="number"
                step="0.01"
                min="0"
                name="prix"
                id="prix"
                class="w-full border p-2 rounded"
                value="{{ old('prix', $product->prix) }}"
                required
            >
        </div>

        <div>
            <label for="quantity" class="block font-semibold">Quantity</label>
            <input
                type="number"
                min="0"
                name="quantity"
                id="quantity"
                class="w-full border p-2 rounded"
                value="{{ old('quantity', $product->quantity) }}"
                required
            >
        </div>

        <div class="flex justify-between">
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">← Back to list</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Product</button>
        </div>
    </form>
</div>
@endsection

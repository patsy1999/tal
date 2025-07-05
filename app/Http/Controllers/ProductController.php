<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\ProductStockReportMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    // List all products
    public function index(Request $request)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
    $search = $request->input('search');

    $query = Product::query();

    if ($search) {
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%");
    }

    $products = $query->orderBy('quantity', 'asc')->paginate(10);

    return view('products.index', compact('products'));
}


    // Show create form
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
        return view('products.create');
    }

    // Store new product
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Show edit form
    public function edit(Product $product)

    {
        if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
        return view('products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Delete product
    public function destroy(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }


public function sendStockReport(Request $request)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $request->validate([
        'email' => 'required|email'
    ]);

    $products = Product::all();

    $pdf = Pdf::loadView('pdf.product-stock-report', compact('products'));

    Mail::to($request->email)->send(new ProductStockReportMail($pdf->output()));

    return back()->with('success', 'Rapport de stock envoyé avec succès à ' . $request->email);
}


}

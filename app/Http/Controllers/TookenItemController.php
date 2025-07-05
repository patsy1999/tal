<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TookenItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF; // at the top (add this import)



class TookenItemController extends Controller
{

public function downloadPdf($id)
{
    $withdrawal = TookenItem::with(['user', 'product'])->findOrFail($id);

    $pdf = PDF::loadView('tooken_items.pdf', compact('withdrawal'));

    // Optional: customize filename with product name and date
    $filename = 'withdrawal_' . $withdrawal->id . '_' . now()->format('Ymd_His') . '.pdf';

    return $pdf->download($filename);
}


public function index()
{
    $withdrawals = TookenItem::with(['user', 'product'])
        ->latest()
        ->paginate(10);

    $monthlyCount = TookenItem::whereMonth('created_at', now()->month)->count();
    $dailyCount = TookenItem::whereDate('created_at', today())->count();

    return view('tooken_items.index', [
        'withdrawals' => $withdrawals,
        'monthlyCount' => $monthlyCount,
        'dailyCount' => $dailyCount
    ]);
}

    public function create()
    {
        $products = Product::all();
        $types = ['Électrique', 'Mécanique', 'Hydraulique', 'Pneumatique', 'Électronique', 'Thermique', 'Sécurité / Safety'];
        $reasons = [
            'Maintenance',
            'Test',
            'Installation',
            'Réparation',
            'Inspection',
            'Étalonnage', // Calibration
            'Urgence',     // Emergency
            'Remplacement',
            'Mise à niveau', // Upgrade
            'Autre'
        ];

        return view('tooken_items.create', compact('products', 'types', 'reasons'));
    }

   public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'reason' => 'required|string',
    ]);

    $product = Product::findOrFail($request->product_id);

    if ($request->quantity > $product->quantity) {
        return back()->withErrors(['quantity' => 'Quantity exceeds stock!']);
    }

    $product->quantity -= $request->quantity;
    $product->save();

    TookenItem::create([
        'user_id' => auth()->id(),
        'product_id' => $product->id,
        'quantity' => $request->quantity,
        'reason' => $request->reason,
        'taken_at' => now(),
    ]);

    // 🔁 Check user role and redirect accordingly
    if (auth()->user()->role === 'admin') {
        return redirect()->route('products.index')->with('success', 'Product withdrawn successfully.');
    } else {
        return redirect()->route('user.products.list')->with('success', 'Product withdrawn successfully.');
    }
}


}

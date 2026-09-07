<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::all();

        $query = Purchase::with(['supplier', 'items.product']);

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('purchase_date', [$request->start_date, $request->end_date]);
        }

        $purchases = $query->latest()->get();

        return view('purchases.index', compact('purchases', 'suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $cartItems = session()->get('purchase_cart', []);

        return view('purchases.create', compact('suppliers', 'products', 'cartItems'));
    }


    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty'        => 'required|numeric|min:1',
            'price'      => 'required|numeric|min:0',
        ]);

        $product = Product::find($request->product_id);
        $cart = session()->get('purchase_cart', []);

        $cart[] = [
            'product_id' => $product->id,
            'name'       => $product->name,
            'brand'      => $product->brand->name ?? 'Artisan',
            'category'   => $product->category->name ?? 'Clothing',
            'unit'       => $product->unit ?? 'Pcs',
            'qty'        => $request->qty,
            'price'      => $request->price,
            'total'      => $request->qty * $request->price,
        ];

        session()->put('purchase_cart', $cart);

        return redirect()->back();
    }

    public function removeItem($index)
    {
        $cart = session()->get('purchase_cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('purchase_cart', array_values($cart));
        }

        return redirect()->back();
    }

    
    public function store(Request $request)
    {
        $cart = session()->get('purchase_cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Please add at least one product!');
        }

        $request->validate([
            'supplier_id'   => 'required',
            'purchase_date' => 'required|date',
        ]);

        DB::transaction(function() use ($request, $cart) {
            $totalAmount = array_sum(array_column($cart, 'total'));

            $purchase = Purchase::create([
                'order_no'      => 'PO-' . str_pad(Purchase::count() + 1, 4, '0', STR_PAD_LEFT),
                'supplier_id'   => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'notes'         => $request->notes,
                'due'           => $totalAmount,
                'status'        => 'Received',
            ]);

            foreach ($cart as $item) {
                $purchase->items()->create([
                    'product_id'  => $item['product_id'],
                    'qty'         => $item['qty'],
                    'unit_price'  => $item['price'],
                    'total_price' => $item['total'],
                ]);
            }
        });

       
        session()->forget('purchase_cart');

        return redirect()->route('purchases.index')->with('success', 'Purchase Order Created!');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);
        return view('purchases.show', compact('purchase'));
    }
}
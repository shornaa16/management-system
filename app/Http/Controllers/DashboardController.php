<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with summary metrics.
     */
    public function index(): View
    {
        $supplierCount = Supplier::count();
        $productCount = Product::count();
        $purchaseCount = Purchase::count();
        $totalPurchaseAmount = (float) Purchase::sum('subtotal');
        $totalPaid = (float) Purchase::sum('paid');
        $totalDue = (float) Purchase::sum('due');

        $recentPurchases = Purchase::with('supplier')
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'supplierCount',
            'productCount',
            'purchaseCount',
            'totalPurchaseAmount',
            'totalPaid',
            'totalDue',
            'recentPurchases'
        ));
    }
}

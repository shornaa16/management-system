<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;
use App\Services\PurchaseOrderNumberGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseSeeder extends Seeder
{
    public function run(PurchaseOrderNumberGenerator $generator): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $suppliers = Supplier::all();
        $products = Product::all();

        if ($suppliers->isEmpty() || $products->isEmpty() || ! $admin) {
            return;
        }

        $purchases = [
            [
                'supplier' => 'ABC Supplier',
                'date' => now()->subDays(15)->toDateString(),
                'notes' => 'First purchase order of the month',
                'paid' => 0,
                'status' => 'Pending',
                'items' => [
                    ['product' => 'Button', 'qty' => 100, 'price' => 5.00],
                    ['product' => 'Zipper', 'qty' => 50, 'price' => 12.50],
                    ['product' => 'Sewing Needle', 'qty' => 200, 'price' => 2.00],
                ],
            ],
            [
                'supplier' => 'XYZ Trading Co.',
                'date' => now()->subDays(10)->toDateString(),
                'notes' => 'Bulk order - partial payment',
                'paid' => 5000,
                'status' => 'Pending',
                'items' => [
                    ['product' => 'Cotton Yarn', 'qty' => 30, 'price' => 250.00],
                    ['product' => 'Polyester Thread', 'qty' => 100, 'price' => 45.00],
                ],
            ],
            [
                'supplier' => 'Global Textiles Ltd.',
                'date' => now()->subDays(5)->toDateString(),
                'notes' => 'Full payment completed',
                'paid' => null, // will be set to subtotal automatically
                'status' => 'Received',
                'items' => [
                    ['product' => 'Fabric Roll', 'qty' => 10, 'price' => 1200.00],
                    ['product' => 'Elastic Band', 'qty' => 500, 'price' => 8.50],
                    ['product' => 'Velcro Tape', 'qty' => 200, 'price' => 15.00],
                    ['product' => 'Snap Button', 'qty' => 300, 'price' => 3.50],
                ],
            ],
            [
                'supplier' => 'City Hardware Store',
                'date' => now()->subDays(2)->toDateString(),
                'notes' => null,
                'paid' => 0,
                'status' => 'Pending',
                'items' => [
                    ['product' => 'Button', 'qty' => 50, 'price' => 5.50],
                    ['product' => 'Packing Box', 'qty' => 100, 'price' => 25.00],
                ],
            ],
        ];

        foreach ($purchases as $data) {
            DB::transaction(function () use ($data, $generator, $admin, $suppliers, $products) {
                $supplier = $suppliers->firstWhere('name', $data['supplier']);
                if (! $supplier) {
                    return;
                }

                $subtotal = 0;
                $lineItems = [];
                foreach ($data['items'] as $item) {
                    $product = $products->firstWhere('name', $item['product']);
                    if (! $product) {
                        continue;
                    }
                    $total = $item['qty'] * $item['price'];
                    $subtotal += $total;
                    $lineItems[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['qty'],
                        'unit_price' => $item['price'],
                        'total_price' => $total,
                    ];
                }

                if (empty($lineItems)) {
                    return;
                }

                $paid = $data['paid'] ?? 0;
                if ($data['status'] === 'Received' && $paid === null) {
                    $paid = $subtotal;
                }
                $paid = min($paid, $subtotal);
                $due = max(0, $subtotal - $paid);

                $purchase = Purchase::create([
                    'order_no' => $generator->generate(),
                    'supplier_id' => $supplier->id,
                    'purchase_date' => $data['date'],
                    'notes' => $data['notes'],
                    'subtotal' => $subtotal,
                    'paid' => $paid,
                    'due' => $due,
                    'status' => $data['status'],
                    'created_by' => $admin->id,
                ]);

                foreach ($lineItems as $line) {
                    $purchase->items()->create($line);
                }
            });
        }
    }
}

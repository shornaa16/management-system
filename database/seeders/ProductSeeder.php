<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Button',           'status' => 'Active'],
            ['name' => 'Zipper',           'status' => 'Active'],
            ['name' => 'Cotton Yarn',      'status' => 'Active'],
            ['name' => 'Polyester Thread', 'status' => 'Active'],
            ['name' => 'Sewing Needle',    'status' => 'Active'],
            ['name' => 'Fabric Roll',      'status' => 'Active'],
            ['name' => 'Elastic Band',     'status' => 'Active'],
            ['name' => 'Snap Button',      'status' => 'Active'],
            ['name' => 'Velcro Tape',      'status' => 'Active'],
            ['name' => 'Packing Box',      'status' => 'Inactive'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

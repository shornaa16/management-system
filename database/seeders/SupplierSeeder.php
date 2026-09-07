<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'ABC Supplier',
                'mobile_no' => '+8801712345678',
                'email' => 'abc@example.com',
                'address' => 'House 12, Road 5, Dhanmondi, Dhaka 1205, Bangladesh',
                'status' => 'Active',
            ],
            [
                'name' => 'XYZ Trading Co.',
                'mobile_no' => '+8801812345678',
                'email' => 'info@xyztrading.com',
                'address' => 'Plot 8, Industrial Area, Chittagong, Bangladesh',
                'status' => 'Active',
            ],
            [
                'name' => 'Global Textiles Ltd.',
                'mobile_no' => '+8801912345678',
                'email' => 'sales@globaltextiles.com',
                'address' => 'Level 6, BGMEA Bhaban, Karwan Bazar, Dhaka 1215',
                'status' => 'Active',
            ],
            [
                'name' => 'City Hardware Store',
                'mobile_no' => '+8801612345678',
                'email' => null,
                'address' => 'Old Town, Dhaka',
                'status' => 'Active',
            ],
            [
                'name' => 'Pacific Importers',
                'mobile_no' => '+8801512345678',
                'email' => 'contact@pacificimporters.com',
                'address' => 'Kawran Bazar, Dhaka-1215',
                'status' => 'Inactive',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}

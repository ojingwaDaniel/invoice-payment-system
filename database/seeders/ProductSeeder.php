<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example Products
        Product::create([
            'type' => 'product',
            'code' => 'P001',
            'name' => 'Wireless Mouse',
            'category' => 'Accessories',
            'unit' => 'pcs',
            'quantity' => 100,
            'selling_price' => 25,
            'purchase_price' => 15,
        ]);

        Product::create([
            'type' => 'product',
            'code' => 'P002',
            'name' => 'Keyboard',
            'category' => 'Accessories',
            'unit' => 'pcs',
            'quantity' => 80,
            'selling_price' => 30,
            'purchase_price' => 20,
        ]);

        Product::create([
            'type' => 'product',
            'code' => 'P003',
            'name' => 'HD Monitor',
            'category' => 'Electronics',
            'unit' => 'pcs',
            'quantity' => 50,
            'selling_price' => 120,
            'purchase_price' => 90,
        ]);

        // Example Services
        Product::create([
            'type' => 'service',
            'code' => 'S001',
            'name' => 'Computer Repair',
            'category' => 'IT Services',
            'unit' => 'hrs',
            'quantity' => 0, // Services don’t have stock
            'selling_price' => 50,
            'purchase_price' => 0,
        ]);

        Product::create([
            'type' => 'service',
            'code' => 'S002',
            'name' => 'Software Installation',
            'category' => 'IT Services',
            'unit' => 'hrs',
            'quantity' => 0,
            'selling_price' => 30,
            'purchase_price' => 0,
        ]);
    }
}

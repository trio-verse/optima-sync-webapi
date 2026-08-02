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
        // Create 20 random products
        Product::factory(20)->create();

        // Create specific test products (use firstOrCreate to avoid duplicates)
        Product::firstOrCreate(
            ['slug' => 'premium-product'],
            [
                'name' => 'Premium Product',
                'price' => 999.99,
                'description' => 'Our premium product with all features',
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'basic-product'],
            [
                'name' => 'Basic Product',
                'price' => 99.99,
                'description' => 'Our basic product with essential features',
            ]
        );
    }
}
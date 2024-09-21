<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $productTypes = [
            ['name' => 'TAYA'],
            ['name' => 'ELEA'],
            ['name' => 'YUKI'],
            ['name' => 'THALIA'],
            ['name' => 'YUNA'],
            ['name' => 'LUNA'],
            ['name' => 'JOANA'],
            ['name' => 'INARA'],
        ];

        $products = [
            [
                'name' => 'TAYA MARUN',
                'product_type_id' => 1,
                'price' => 1000,
                'stock' => 10,
            ],
            [
                'name' => 'ELEA DUSTY',
                'product_type_id' => 2,
                'price' => 2000,
                'stock' => 20,
            ],
            [
                'name' => 'YUKI DENIM',
                'product_type_id' => 3,
                'price' => 3000,
                'stock' => 30,
            ],
            [
                'name' => 'THALIA HITAM',
                'product_type_id' => 4,
                'price' => 4000,
                'stock' => 40,
            ],
            [
                'name' => 'YUNA BW',
                'product_type_id' => 5,
                'price' => 5000,
                'stock' => 50,
            ],
        ];
        
        foreach ($productTypes as $productType) {
            ProductType::factory()->create($productType);
        }
        foreach ($products as $product) {
            Product::factory()->create($product);
        }
    }
}

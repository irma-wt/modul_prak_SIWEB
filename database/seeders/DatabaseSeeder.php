<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'category_id' => 1,
                'category_name' => 'Sneakers',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),   
            ],
            [
                'category_id' => 2,
                'category_name' => 'Sports',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
        ]
    ]);

    DB::table('products')->insert([
        [
            'product_id' => 1,
            'category_id' => 1,
            'product_name' => 'Nike AirForce 1',
            'product_price' => '100000',
            'product_stock' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),   
        ]
    ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
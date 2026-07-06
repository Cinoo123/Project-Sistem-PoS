<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. ISI DATA AKUN LOGIN KASIR
        DB::table('users')->insert([
            'name' => 'Handi Kasir Utama',
            'email' => 'kasir@burgerkingdom.com',
            'password' => Hash::make('kasir123'), // Password untuk login nanti
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. ISI DAFTAR MENU MAKANAN (CATEGORY: burger) & MINUMAN (CATEGORY: drinks)
        DB::table('menus')->insert([
            // Kelompok Burger
            [
                'name' => 'Classic Beef Burger',
                'price' => 30000,
                'stock' => 50,
                'category' => 'burger',
                'image' => 'burger1.jpg', // Sesuaikan nama file gambar di folder public/images
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Double Cheese Lava Burger',
                'price' => 45000,
                'stock' => 35,
                'category' => 'burger',
                'image' => 'burger2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Crispy Chicken Burger',
                'price' => 28000,
                'stock' => 40,
                'category' => 'burger',
                'image' => 'burger3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kelompok Minuman
            [
                'name' => 'Es Kopi Susu Aren Premium',
                'price' => 18000,
                'stock' => 60,
                'category' => 'drinks',
                'image' => 'drink1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fresh Lemon Tea',
                'price' => 12000,
                'stock' => 100,
                'category' => 'drinks',
                'image' => 'drink2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coca Cola Ice',
                'price' => 10000,
                'stock' => 15,
                'category' => 'drinks',
                'image' => 'drink3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
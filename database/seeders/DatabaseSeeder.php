<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // USERS
        DB::table('users')->insert([
            [
                'name'         => 'Khresnanda Putra Wirawan',
                'email'        => 'khresnanda12@gmail.com',
                'password'     => Hash::make('password'),
                'role'         => 'manager',
                'phone_number' => '081234567890',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Budi Karyawan',
                'email'        => 'budi@burgerjo.com',
                'password'     => Hash::make('password'),
                'role'         => 'karyawan',
                'phone_number' => '081111111111',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Ani Customer',
                'email'        => 'ani@gmail.com',
                'password'     => Hash::make('password'),
                'role'         => 'customer',
                'phone_number' => '082222222222',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        // OUTLETS
        DB::table('outlets')->insert([
            [
                'name'       => 'Burger Jo - Sudirman',
                'location'   => 'Jl. Jend. Sudirman No. 1, Jakarta Pusat',
                'status'     => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Burger Jo - Kemang',
                'location'   => 'Jl. Kemang Raya No. 45, Jakarta Selatan',
                'status'     => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Burger Jo - BSD',
                'location'   => 'BSD City, Jl. Pahlawan Seribu, Tangerang Selatan',
                'status'     => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // MENUS
        DB::table('menus')->insert([
            // Burger
            [
                'name'         => 'Classic Beef Burger',
                'description'  => 'Beef patty juicy 150gr, selada, tomat, bawang, saus spesial, roti brioche.',
                'price'        => 45000,
                'category'     => 'makanan',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Double Smash Burger',
                'description'  => 'Dua beef patty smashed tipis, double keju cheddar, pickles, saus mustard.',
                'price'        => 65000,
                'category'     => 'makanan',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'BBQ Bacon Burger',
                'description'  => 'Beef patty, bacon crispy, saus BBQ smoky, bawang bombay karamel, keju.',
                'price'        => 72000,
                'category'     => 'makanan',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Spicy Volcano Burger',
                'description'  => 'Beef patty pedas, jalapeño, saus volcano extra hot, keju pepper jack.',
                'price'        => 60000,
                'category'     => 'makanan',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Crispy Chicken Burger',
                'description'  => 'Ayam crispy goreng tepung, slaw coleslaw, saus honey mustard.',
                'price'        => 50000,
                'category'     => 'makanan',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Mushroom Swiss Burger',
                'description'  => 'Beef patty, tumis jamur, keju swiss, saus garlic aioli.',
                'price'        => 68000,
                'category'     => 'makanan',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Veggie Burger',
                'description'  => 'Patty dari black bean, alpukat, tomat, selada, saus yogurt.',
                'price'        => 48000,
                'category'     => 'makanan',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Snack
            [
                'name'         => 'Kentang Goreng Reguler',
                'description'  => 'Kentang goreng crispy dengan garam, disajikan dengan saus tomat & mayo.',
                'price'        => 22000,
                'category'     => 'snack',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Loaded Cheese Fries',
                'description'  => 'Kentang goreng dengan saus keju cheddar leleh dan bacon bits.',
                'price'        => 35000,
                'category'     => 'snack',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Onion Rings',
                'description'  => 'Bawang bombay goreng tepung crispy, saus ranch.',
                'price'        => 28000,
                'category'     => 'snack',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Chicken Nuggets 6pcs',
                'description'  => 'Nugget ayam crispy 6 potong, saus BBQ atau saus tomat.',
                'price'        => 30000,
                'category'     => 'snack',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Minuman
            [
                'name'         => 'Cola Float',
                'description'  => 'Minuman cola dingin dengan es krim vanilla di atasnya.',
                'price'        => 22000,
                'category'     => 'minuman',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Milkshake Coklat',
                'description'  => 'Milkshake creamy rasa coklat dengan whipped cream.',
                'price'        => 35000,
                'category'     => 'minuman',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Milkshake Vanilla',
                'description'  => 'Milkshake creamy rasa vanilla klasik dengan whipped cream.',
                'price'        => 35000,
                'category'     => 'minuman',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Lemon Squash',
                'description'  => 'Air soda dengan perasan lemon segar dan mint.',
                'price'        => 18000,
                'category'     => 'minuman',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Es Teh Manis',
                'description'  => 'Teh manis dingin yang menyegarkan.',
                'price'        => 8000,
                'category'     => 'minuman',
                'is_available' => true,
                'outlet_id'    => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
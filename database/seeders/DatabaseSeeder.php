<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Outlet;
use App\Models\Menu;
use App\Models\Promo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo user
        User::create([
            'name'         => 'Demo User',
            'email'        => 'demo@example.com',
            'password'     => Hash::make('password'),
            'phone_number' => '08123456789',
        ]);

        // Outlets
        $outlets = [
            ['name' => 'Burger Bliss Sudirman',  'location' => 'Jl. Sudirman No. 1',      'status' => 'open'],
            ['name' => 'Burger Bliss Gatsu',     'location' => 'Jl. Gatot Subroto No. 5', 'status' => 'open'],
            ['name' => 'Burger Bliss Pahlawan',  'location' => 'Jl. Pahlawan No. 12',     'status' => 'closed'],
        ];

        foreach ($outlets as $outletData) {
            $outlet = Outlet::create($outletData);

            $menus = [
                ['name' => 'Classic Burger',        'description' => 'Beef patty, selada, tomat, keju cheddar.',        'price' => 35000, 'category' => 'Burger',   'is_available' => true],
                ['name' => 'Double Smash Burger',   'description' => 'Dua beef patty smash, saus spesial, pickles.',    'price' => 55000, 'category' => 'Burger',   'is_available' => true],
                ['name' => 'Crispy Chicken Burger', 'description' => 'Ayam crispy juicy, mayo, selada renyah.',         'price' => 40000, 'category' => 'Burger',   'is_available' => true],
                ['name' => 'BBQ Bacon Burger',      'description' => 'Beef patty, bacon crispy, saus BBQ smoky.',       'price' => 60000, 'category' => 'Burger',   'is_available' => true],
                ['name' => 'French Fries Regular',  'description' => 'Kentang goreng renyah, tabur bumbu spesial.',     'price' => 18000, 'category' => 'Snack',    'is_available' => true],
                ['name' => 'Onion Rings',           'description' => 'Bawang bombay goreng tepung crispy.',             'price' => 22000, 'category' => 'Snack',    'is_available' => true],
                ['name' => 'Vanilla Milkshake',     'description' => 'Milkshake vanilla creamy, dingin menyegarkan.',  'price' => 28000, 'category' => 'Beverage', 'is_available' => true],
                ['name' => 'Cola Float',            'description' => 'Soda cola dengan es krim vanilla mengambang.',   'price' => 20000, 'category' => 'Beverage', 'is_available' => true],
            ];

            foreach ($menus as $menuData) {
                Menu::create(array_merge($menuData, ['outlet_id' => $outlet->id]));
            }
        }

        // Promos
        Promo::create([
            'code'            => 'BURGER10',
            'discount_type'   => 'percentage',
            'discount_value'  => 10,
            'min_order'       => 50000,
            'max_uses'        => 100,
            'used_count'      => 0,
            'expiration_date' => now()->addMonths(3),
            'is_active'       => true,
        ]);

        Promo::create([
            'code'            => 'FREEFRIES',
            'discount_type'   => 'fixed',
            'discount_value'  => 18000,
            'min_order'       => 60000,
            'max_uses'        => 50,
            'used_count'      => 0,
            'expiration_date' => now()->addMonths(2),
            'is_active'       => true,
        ]);
    }
}
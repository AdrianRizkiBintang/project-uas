<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\User;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
=======
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
            ['name' => 'Warung Nusantara', 'location' => 'Jl. Sudirman No. 1', 'status' => 'open'],
            ['name' => 'Resto Bahari',     'location' => 'Jl. Gatot Subroto No. 5', 'status' => 'open'],
            ['name' => 'Kedai Kopi Senja', 'location' => 'Jl. Pahlawan No. 12', 'status' => 'closed'],
        ];

        foreach ($outlets as $outletData) {
            $outlet = Outlet::create($outletData);

            // Menus per outlet
            $menus = [
                ['name' => 'Nasi Goreng Spesial',  'description' => 'Nasi goreng dengan telur dan ayam.', 'price' => 25000, 'category' => 'Main Course', 'is_available' => true],
                ['name' => 'Mie Ayam Bakso',        'description' => 'Mie ayam dengan bakso sapi.', 'price' => 20000, 'category' => 'Main Course', 'is_available' => true],
                ['name' => 'Es Teh Manis',          'description' => 'Teh manis dingin segar.', 'price' => 5000,  'category' => 'Beverage',    'is_available' => true],
                ['name' => 'Jus Alpukat',           'description' => 'Jus alpukat kental susu.', 'price' => 15000, 'category' => 'Beverage',    'is_available' => true],
                ['name' => 'Pisang Goreng Keju',    'description' => 'Pisang goreng tabur keju parut.', 'price' => 12000, 'category' => 'Snack',       'is_available' => true],
            ];

            foreach ($menus as $menuData) {
                Menu::create(array_merge($menuData, ['outlet_id' => $outlet->id]));
            }
        }

        // Promos
        Promo::create([
            'code'           => 'HEMAT10',
            'discount_type'  => 'percentage',
            'discount_value' => 10,
            'min_order'      => 30000,
            'max_uses'       => 100,
            'used_count'     => 0,
            'expiration_date' => now()->addMonths(3),
            'is_active'      => true,
        ]);

        Promo::create([
            'code'           => 'DISKON5K',
            'discount_type'  => 'fixed',
            'discount_value' => 5000,
            'min_order'      => 20000,
            'max_uses'       => 50,
            'used_count'     => 0,
            'expiration_date' => now()->addMonths(2),
            'is_active'      => true,
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
        ]);
    }
}

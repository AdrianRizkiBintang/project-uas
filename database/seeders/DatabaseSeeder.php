<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Outlet;
use App\Models\Menu;
use App\Models\Promo;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Review;
use App\Models\Wishlist;

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
        $outlets = [
            ['name' => 'Burger Bliss Sudirman',  'location' => 'Jl. Sudirman No. 1',      'status' => 'open'],
            ['name' => 'Burger Bliss Gatsu',     'location' => 'Jl. Gatot Subroto No. 5', 'status' => 'open'],
            ['name' => 'Burger Bliss Pahlawan',  'location' => 'Jl. Pahlawan No. 12',     'status' => 'closed'],
            ['name' => 'Burger Bliss Kemang',  'location' => 'Jl. Kemang Raya No. 15', 'status' => 'open'],
            ['name' => 'Burger Bliss PIK',     'location' => 'Jl. Pantai Indah Kapuk No. 8', 'status' => 'open'],
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
                ['name' => 'Vanilla Milkshake',     'description' => 'Milkshake vanilla creamy, dingin menyegarkan.',   'price' => 28000, 'category' => 'Beverage', 'is_available' => true],
                ['name' => 'Cola Float',            'description' => 'Soda cola dengan es krim vanilla mengambang.',    'price' => 20000, 'category' => 'Beverage', 'is_available' => true],
                ['name' => 'Cheese Burger', 'description' => 'Beef patty dengan keju leleh premium.', 'price' => 45000, 'category' => 'Burger', 'is_available' => true],
                ['name' => 'Mushroom Burger', 'description' => 'Burger dengan saus jamur creamy.', 'price' => 50000, 'category' => 'Burger', 'is_available' => true],
                ['name' => 'Spicy Jalapeno Burger', 'description' => 'Burger pedas dengan jalapeno segar.', 'price' => 52000, 'category' => 'Burger', 'is_available' => true],
                ['name' => 'Triple Beef Burger', 'description' => 'Tiga lapis beef patty juicy.', 'price' => 75000, 'category' => 'Burger', 'is_available' => true],

                ['name' => 'Loaded Fries', 'description' => 'Kentang goreng dengan keju dan saus spesial.', 'price' => 30000, 'category' => 'Snack', 'is_available' => true],
                ['name' => 'Chicken Nuggets', 'description' => 'Nugget ayam crispy.', 'price' => 25000, 'category' => 'Snack', 'is_available' => true],
                ['name' => 'Mozzarella Stick', 'description' => 'Keju mozzarella goreng.', 'price' => 28000, 'category' => 'Snack', 'is_available' => true],

                ['name' => 'Chocolate Milkshake', 'description' => 'Milkshake coklat premium.', 'price' => 30000, 'category' => 'Beverage', 'is_available' => true],
                ['name' => 'Strawberry Milkshake', 'description' => 'Milkshake strawberry segar.', 'price' => 30000, 'category' => 'Beverage', 'is_available' => true],
                ['name' => 'Iced Lemon Tea', 'description' => 'Teh lemon dingin.', 'price' => 18000, 'category' => 'Beverage', 'is_available' => true],
                ['name' => 'Mineral Water', 'description' => 'Air mineral botol.', 'price' => 10000, 'category' => 'Beverage', 'is_available' => true],
            ];

            foreach ($menus as $menuData) {
                Menu::create(array_merge($menuData, ['outlet_id' => $outlet->id]));
            }
        }

        // PROMOS
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

        Promo::create([
        'code' => 'NEWUSER50',
        'discount_type' => 'fixed',
        'discount_value' => 50000,
        'min_order' => 100000,
        'max_uses' => 100,
        'used_count' => 0,
        'expiration_date' => now()->addMonths(6),
        'is_active' => true,
        ]);

        Promo::create([
        'code' => 'WEEKEND20',
        'discount_type' => 'percentage',
        'discount_value' => 20,
        'min_order' => 80000,
        'max_uses' => 200,
        'used_count' => 0,
        'expiration_date' => now()->addMonths(6),
        'is_active' => true,
        ]);

        // CUSTOMER TAMBAHAN
        $customers = [];

        for ($i = 1; $i <= 30; $i++) {
         $customers[] = [
        'name' => 'Customer ' . $i,
        'email' => 'customer' . $i . '@burgerbliss.com',
        'password' => Hash::make('password'),
        'role' => 'customer',
        'phone_number' => '08' . rand(1111111111, 9999999999),
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

        DB::table('users')->insert($customers);
    

    // USER ADDRESSES
        $customerUsers = User::where('role', 'customer')->get();

        foreach ($customerUsers as $customer) {

    UserAddress::create([
        'user_id' => $customer->id,
        'label' => 'Rumah',
        'address' => 'Jl. Melati No. ' . rand(1, 100) . ', Jakarta',
        'latitude' => -6.200000 + (rand(-1000, 1000) / 100000),
        'longitude' => 106.816666 + (rand(-1000, 1000) / 100000),
        'is_default' => true,
    ]);

    UserAddress::create([
        'user_id' => $customer->id,
        'label' => 'Kantor',
        'address' => 'Jl. Sudirman No. ' . rand(1, 100) . ', Jakarta',
        'latitude' => -6.210000 + (rand(-1000, 1000) / 100000),
        'longitude' => 106.820000 + (rand(-1000, 1000) / 100000),
        'is_default' => false,
    ]);
        }        
    // ORDERS & ORDER ITEMS

    $customers = User::where('role', 'customer')->get();
    $outlets = Outlet::all();
    $menus = Menu::all();
    $promos = Promo::all();

    $statuses = [
    'pending',
    'confirmed',
    'processing',
    'out_for_delivery',
    'completed',
    'cancelled'
];

for ($i = 1; $i <= 50; $i++) {

    $customer = $customers->random();
    $outlet = $outlets->random();

    $customerAddresses = UserAddress::where('user_id', $customer->id)->get();

    $type = rand(0, 1) ? 'delivery' : 'dine_in';

    $selectedPromo = rand(1, 100) <= 20
        ? $promos->random()
        : null;

    $order = Order::create([
        'user_id' => $customer->id,
        'outlet_id' => $outlet->id,
        'type' => $type,
        'status' => $statuses[array_rand($statuses)],
        'payment_method' => rand(0, 1) ? 'cash' : 'qris',
        'payment_status' => rand(0, 1) ? 'paid' : 'unpaid',
        'total_amount' => 0,
        'discount_amount' => $selectedPromo ? 10000 : 0,
        'tip_amount' => rand(0, 1)
         ? rand(5000, 20000)
        : 0,

        'driver_notes' => rand(0, 1)
         ? 'Mohon hubungi saat sampai'
        : null,
        'notes' => rand(0, 1)
            ? 'Tolong jangan terlalu pedas'
            : null,
        'delivery_address_id' => (
            $type === 'delivery' &&
            $customerAddresses->isNotEmpty()
)
            ? $customerAddresses->random()->id
            : null,
        'promo_id' => $selectedPromo?->id,
    ]);

    $outletMenus = Menu::where('outlet_id', $outlet->id)->get();

    $itemCount = rand(1, 4);

    $total = 0;

    for ($j = 1; $j <= $itemCount; $j++) {

        $menu = $outletMenus->random();

        $qty = rand(1, 3);

        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'quantity' => $qty,
            'price_at_time' => $menu->price,
            'notes' => rand(0, 1)
                ? 'Extra saus'
                : null,
        ]);

        $total += ($menu->price * $qty);
    }

   $order->update([
'total_amount' => max(
$total - $order->discount_amount,
0
)
]);

} // <-- penutup for order

// REVIEWS

$completedOrders = Order::where('status', 'completed')->get();

$reviewComments = [
'Burgernya enak banget',
'Pengiriman cepat',
'Kentangnya masih hangat',
'Porsinya pas',
'Saus spesialnya mantap',
'Worth it untuk harganya',
'Packaging rapi',
'Bakal order lagi',
];

foreach ($completedOrders->take(25) as $order) {

Review::create([
    'order_id' => $order->id,
    'user_id' => $order->user_id,
    'rating' => rand(3, 5),
    'courier_rating' => rand(3, 5),
    'comments' => $reviewComments[array_rand($reviewComments)],
]);


}

// WISHLISTS

foreach ($customers as $customer) {

$wishlistMenus = $menus->random(rand(1, 3));

foreach ($wishlistMenus as $menu) {

    Wishlist::firstOrCreate([
        'user_id' => $customer->id,
        'menu_id' => $menu->id,
    ]);
}


}

} 

} 

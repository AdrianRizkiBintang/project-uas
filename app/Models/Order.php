<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Field yang boleh diisi secara massal (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'outlet_id', 'type', 'status',
        'payment_method', 'payment_status',
        'total_amount', 'discount_amount',
        'notes', 'delivery_address_id', 'promo_id',
    ];

    /**
     * Konversi tipe data otomatis untuk kalkulasi harga.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount'    => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Relasi ke model User.
     * Setiap pesanan dimiliki oleh satu user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Outlet.
     * Setiap pesanan berasal dari satu outlet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Relasi ke model OrderItem.
     * Satu pesanan dapat memiliki banyak item menu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke model UserAddress sebagai alamat pengiriman.
     * Hanya berlaku untuk pesanan bertipe delivery.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryAddress()
    {
        return $this->belongsTo(UserAddress::class, 'delivery_address_id');
    }

    /**
     * Relasi ke model Promo.
     * Pesanan bisa menggunakan satu kode promo atau tidak sama sekali.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    /**
     * Relasi ke model Review.
     * Satu pesanan dapat memiliki satu ulasan dari customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
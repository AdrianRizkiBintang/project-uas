<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Menu extends Model
{
    use HasFactory;

    /**
     * Field yang boleh diisi secara massal (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'outlet_id', 'name', 'description',
        'price', 'category', 'image', 'is_available'
    ];

    /**
     * Konversi tipe data otomatis untuk field tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Relasi ke model Outlet.
     * Setiap menu hanya dimiliki oleh satu outlet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Relasi ke model OrderItem.
     * Satu menu dapat muncul di banyak item pesanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function averageRating(): float
    {
        return (float) Review::whereHas('order.items', function ($q) {
            $q->where('menu_id', $this->id);
        })->avg('rating') ?? 0;
    }

    public function reviewCount(): int
    {
        return Review::whereHas('order.items', function ($q) {
            $q->where('menu_id', $this->id);
        })->count();
    }

    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }
}

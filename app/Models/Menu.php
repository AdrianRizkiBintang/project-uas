<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['outlet_id', 'name', 'description', 'price', 'category', 'image', 'is_available'];

    protected $casts = ['price' => 'decimal:2', 'is_available' => 'boolean'];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }
}

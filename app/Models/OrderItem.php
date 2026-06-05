<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'menu_id', 'quantity', 'price_at_time', 'notes'];

    protected $casts = ['price_at_time' => 'decimal:2'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function subtotal(): float
    {
        return $this->quantity * $this->price_at_time;
    }
}

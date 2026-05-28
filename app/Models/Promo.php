<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [ 'code', 'discount_type', 'discount_value', 'min_order', 'max_uses', 'used_count', 'expiration_date', 'is_active'];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order'      => 'decimal:2',
        'expiration_date'=> 'datetime',
        'is_active'      => 'boolean',
    ];

    public function isValid(): bool
    {
       if (!$this->is_active) {
            return false;
        }

        if ($this->expiration_date && $this->expiration_date->isPast()) {
            return false;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }
        return true;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $fillable = ['name', 'phone', 'address'];
    
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
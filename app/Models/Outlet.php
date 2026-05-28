<?php
git push origin main
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'status'];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

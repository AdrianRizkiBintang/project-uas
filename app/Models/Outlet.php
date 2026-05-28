<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> friend-repo/main
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $fillable = ['name', 'location', 'status'];

=======
    protected $fillable = ['name', 'phone', 'address'];
    
>>>>>>> friend-repo/main
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
<<<<<<< HEAD

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
=======
}
>>>>>>> friend-repo/main

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'name',
        'description'
    ];

    public function carts() {
        return $this->belongsToMany(Cart::class, 'cart_item')
            ->withPivot('quantity');
    }

}

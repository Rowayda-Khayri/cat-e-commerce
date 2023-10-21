<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_completed'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->belongsToMany(Item::class, 'cart_item')
            ->withPivot('quantity');
    }

    public function orders() {
        return $this->hasOne(Order::class);
    }
}

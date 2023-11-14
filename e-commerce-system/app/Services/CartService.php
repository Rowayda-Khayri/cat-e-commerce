<?php

namespace App\Services;

use App\Models\User;
use App\Models\Cart;

class CartService
{
    public function getUserActiveCart($userId)
    {
        return Cart::where('user_id', $userId)->where('is_completed', false)->first();
    }
}
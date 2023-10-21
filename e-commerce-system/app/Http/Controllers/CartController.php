<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;

class CartController extends Controller
{

      public function addToCart(Request $request, $itemId) {
          
          $userId = 1; // Replace with the actual user ID
          // Retrieve the quantity from the form input
          $quantity = $request->input('quantity');

          // Check if current user has an active cart with
          $cart = Cart::where('user_id', $userId)->where('is_completed', false)->first();

          if (!$cart) { // No active cart exists
              //Create a new cart record
              $cart = new Cart();
              $cart->user_id = $userId;
              $cart->save();
          }
          
          // Check if the item already exists in the cart (in the pivot table)
          $existingCartItem = $cart->items()->where('item_id', $itemId)->first();

          if ($existingCartItem) {
              // If the item already exists, update the quantity
              $newQuantity = $existingCartItem->pivot->quantity + $quantity;

              // Update the existing pivot record with the new quantity
              $cart->items()->updateExistingPivot($itemId, ['quantity' => $newQuantity]);
          } else {
              // If the item doesn't exist, create a new pivot record
              $cart->items()->attach($itemId, ['quantity' => $quantity]);
          }
          
          // Determine the response type (web or API) and return the appropriate response
          if ($request->wantsJson()) {
              // If it's an API request, return a JSON response
              return response()->json(['message' => 'Item added to cart.'], 200);
          } else {
              // If it's a web request, redirect to a specific route with a success message
              return redirect()->route('store')->with('success', 'Item added to cart.');
          }
      }
        
    }
    

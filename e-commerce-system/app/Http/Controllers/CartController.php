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

          // Check if the item exists in the items table
          $item = Item::find($itemId);

          if (!$item) {
              return response()->json(['error' => 'Item not found.'], 404);
          }
        
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

      public function viewCart(Request $request) {
          $userId = 1; // Replace with the actual user ID

          // Find the active cart for the user
          $cart = Cart::where('user_id', $userId)->where('is_completed', false)->first();

        if (!$cart) {
            $transactionResult = 'failure'; // Set the transaction result to 'failure'
            $totalPrice = 0; // Initialize with a default value

            // Return a response based on the request type (web or API)
            if ($request->wantsJson()) {
                return response()->json(['message' => 'No active cart found.'], 400);
            } else {
                return redirect()->route('store')->with('error', 'No active cart found.');
            }
        }
        
          // Retrieve the items in the cart with their quantities
          $cartItems = $cart->items()->withPivot('quantity')->get();

          // Return JSON for API
          if ($request->expectsJson()) {
              return response()->json(['data' => $cartItems]);
          }
        
          return view('cart', ['cartItems' => $cartItems]);
      }

      public function removeItemFromCart(Request $request, $itemId) {
          $userId = 1; // Replace with the actual user ID 

          // Find the active cart for the user
          $cart = Cart::where('user_id', $userId)->where('is_completed', false)->first();

          // Remove the item from the cart (in the pivot table)
          $cart->items()->detach($itemId);

          // Handle the response based on the request type (web or API)
          return $request->wantsJson()
              ? response()->json(['message' => 'Item removed from the cart.'], 200)
              : redirect()->route('cart')->with('success', 'Item removed from the cart.');
      }
        
    }
    

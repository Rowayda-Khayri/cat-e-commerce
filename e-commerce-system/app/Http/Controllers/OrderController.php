<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function checkout(Request $request) {
        return view('checkout');
    }

    public function processCheckout(Request $request, CartService $cartService) {
        $userId = 1; // Replace with the actual user ID 

        // Find the active cart for the user
        $cart = $cartService->getUserActiveCart($userId);

        $transactionResult = 'success';
        
        if (!$cart) {
            $transactionResult = 'failure';
            $totalPrice = 0; // Initialize with a default value
  
            // Return a response based on the request type (web or API)
            if ($request->expectsJson()) {
                return response()->json(['transactionResult' => $transactionResult, 'totalPrice' => $totalPrice, 'message' => 'No active cart found.'], 400);
            } else {
                return redirect()->route('cart')->with('error', 'No active cart found.');
            }
        }
      
        // Retrieve the items in the cart with their quantities from the pivot table
        $cartItems = $cart->items()->withPivot('quantity')->get();

        $totalPrice = 0;

        foreach ($cartItems as $item) {
            // Get each item's price from the items table and calculate the total cart price
            $itemPrice = $item->price;
            $itemQuantity = $item->pivot->quantity;
            $totalPrice += $itemPrice * $itemQuantity;
        }

        // Check if the user's store credits are sufficient to cover the order total
        $user = User::find($userId);
        $userCredit = $user->store_credit;
  
        if ($userCredit < $totalPrice) {
            $transactionResult = 'failure';
            if ($request->expectsJson()) {
                // Return a JSON response indicating insufficient store credits for the order
                return response()->json(['message' => 'Insufficient store credits for the order.', 'total_price' => $totalPrice, 'user_credit' => $userCredit], 400);
            }
        } else { // User has enough credit
               
                // Deduct the total price from the user's store credits
                $user->store_credit -= $totalPrice;
                $user->save();
  
  
                // Mark the cart as completed
                $cart->update(['is_completed' => true]);
  
                // Save the transaction information in the Order table
                $order = new Order();
                $order->cart_id = $cart->id;
                $order->total = $totalPrice;
                $order->address = $request->input('address');
                $order->telephone = $request->input('telephone');
                $order->save();
  
              // Return a response based on the request type (web or API)
              if ($request->expectsJson()) {
                  return response()->json(['message' => 'Checkout successful.', 'total_price' => $totalPrice], 200);
              }
               
        }
        // In all cases of user credit, return to order result page  
        return view('order-result', compact('transactionResult', 'totalPrice', 'userCredit'));
      
    }
}

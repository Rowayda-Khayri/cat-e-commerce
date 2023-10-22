<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function checkout(Request $request) {
        return view('checkout');
    }

    public function processCheckout(Request $request) {
        $userId = 1; // Replace with the actual user ID 

        // Find the active cart for the user
        $cart = Cart::where('user_id', $userId)->where('is_completed', false)->first();

      $transactionResult = 'success';
      
      if (!$cart) {
          $transactionResult = 'failure';
          $totalPrice = 0; // Initialize with a default value

          // Return a response based on the request type (web or API)
          if ($request->wantsJson()) {
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

      if ($user->store_credit < $totalPrice) {
          $transactionResult = 'failure';
          if ($request->wantsJson()) {
              // Return a JSON response indicating insufficient store credits for the order
              return response()->json(['message' => 'Insufficient store credits for the order.'], 400);
          }
      }

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
      if ($request->wantsJson()) {
          return response()->json(['message' => 'Checkout successful.', 'total_price' => $totalPrice], 200);
      } else {
        return view('order-result', compact('transactionResult', 'totalPrice'));
      }
    }
}

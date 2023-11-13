<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function getAllStoreItems(Request $request)
    {
        // Get all items
        $items = Item::all();

        // Return JSON for API
        if ($request->expectsJson()) {
            return response()->json(['data' => $items]);
        }

        // For web
        return view('store', compact('items'));
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderSalesItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;
class OrderController extends Controller
{
    //
     public function show()
    {
        return Inertia::render('Order', [
            'message' => 'This is a message from Laravel!','orders' => Order::all(),
        ]);
    }

    public function store(Request $request)
    {
 Log::info('Order created:', $request->all());

        // Validate your data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'nullable|string',
            'category' => 'nullable|string',
            'stock_quantity' => 'nullable|integer',
            'attributes' => 'nullable|array',
            'price' => 'nullable|numeric',
        ]);

        // Create the new item
        $item = Item::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'category' => $validated['category'] ?? null,
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'attributes' => $request->input('attributes', []),
            'price' => $validated['price'] ?? 0,
        ]);

        // Return JSON response for Inertia
        return  redirect()->route('item')->with('success', 'Item added!');
    }

    public function update(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'nullable|string',
            'category' => 'nullable|string',
            'stock_quantity' => 'nullable|integer',
            'attributes' => 'nullable|array',
            'price' => 'nullable|numeric',
        ]);
        $item = Item::findOrFail($request->route('id'));
        $item->update($validated);
        return redirect()->route('item')->with('success', 'Item updated!');
    }

}

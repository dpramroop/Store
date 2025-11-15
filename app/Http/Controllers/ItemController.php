<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ItemController extends Controller
{
       public function show()
    {
        return Inertia::render('Item', [
            'message' => 'This is a message from Laravel!','items' => Item::all(),
        ]);
    }

    public function store(Request $request)
    {
 Log::info('Item created:', $request->all());

        // Validate your data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'nullable|string',
            'category' => 'nullable|string',
            'stock_quantity' => 'nullable|integer',
            'attributes' => 'nullable|array',
        ]);

        // Create the new item
        $item = Item::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'category' => $validated['category'] ?? null,
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'attributes' => $request->input('attributes', []),
        ]);

        // Return JSON response for Inertia
        return  redirect()->route('item')->with('success', 'Item added!');;
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
        ]);
        $item = Item::findOrFail($request->route('id'));
        $item->update($validated);
        return response()->json($item);
    }


}

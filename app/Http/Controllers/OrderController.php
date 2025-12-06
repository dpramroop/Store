<?php

namespace App\Http\Controllers;

use App\Models\CourierOrder;
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

    public function getItems()
    {
        return Inertia::render('Order/AddOrder',['items'=>Item::all()]);
    }

    public function store(Request $request)
    {
 Log::info('Order created:', $request->all());


        // Validate your data
        $validated = $request->validate([
            'customer_id' => 'required|numeric',
            'totalprice' => 'nullable|numeric',
            'status' => 'nullable|string',
        ]);

        // Create the new item
        $order = Order::create([
            'customer_id' => $validated['customer_id'],
            'status' => $validated['status'] ?? null,
            'totalprice' => $validated['totalprice'] ?? 0,
        ]);



       foreach($request->orders as $orderitem)
       {
  OrderSalesItem::create(
            [
            'order_id'=>$order->id,
            'sales_item_id'=>$orderitem['item']['id'],
            'quantity'=>$orderitem['quantity'],
            'cost'=>$orderitem['totalcost'],
            ]
            );

       }
    if($request->courierpick!=null)
    {
   CourierOrder::create([
         'order_id'=>$order->id,
        'courier_id'=>$request->courierpick['id'],
        'status'=>'placed',
    ]);
    }


        // Return JSON response for Inertia
        return  redirect()->route('order')->with('success', 'Order added!');
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

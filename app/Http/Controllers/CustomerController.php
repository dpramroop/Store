<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    //
       public function show()
    {
        return Inertia::render('Customer', [
            'message' => 'This is a message from Laravel!','items' => Customer::all(),
        ]);
    }

    public function store(Request $request)
    {
 Log::info('Customer created:', $request->all());

        // Validate your data
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
           'email' => 'required|string|max:255',
        'contact_no' => 'required|string|max:20',
        ]);

        // Create the new item
        $customer = Customer::create([
            'fname' => $validated['fname'],
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'phone' => $validated['contact_no'],
        ]);

        // Return JSON response for Inertia
        return  redirect()->route('customer')->with('success', 'Customer added!');
    }

    public function update(Request $request)
    {
     $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
           'email' => 'required|string|max:255',
        'contact_no' => 'required|string|max:20',
        ]);
        $customer = Customer::findOrFail($request->route('id'));
        $customer->update($validated);
        return redirect()->route('customer')->with('success', 'Customer updated!');
    }
}

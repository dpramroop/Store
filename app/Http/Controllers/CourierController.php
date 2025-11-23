<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Courier;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
class CourierController extends Controller
{
    //
         public function show(Request $request)
    {

        return Inertia::render('Courier', [
            'message' => 'This is a message from Laravel!','couriers' => Courier::all()
        ]);
    }

    public function store(Request $request)
    {
 Log::info('Courier request:', $request->all());

        // Validate your data
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
           'email' => 'required|string|max:255',
        'contact_no' => 'required|string|max:255',
        'cost' => 'required|decimal:2',
        ]);
 Log::info('Courier validated:', $validated);
        // Create the new item
        $courier = Courier::create([
            'fname' => $validated['fname'],
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'contact_no' => $validated['contact_no'],
            'cost' => $validated['cost'],
        ]);

        // Return JSON response for Inertia
        return  redirect()->route('courier')->with('success', 'Courier added!');
    }

    public function update(Request $request)
    {
     $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
           'email' => 'required|string|max:255',
        'contact_no' => 'required|string|max:20',
         'cost' => 'required|numeric',
        ]);
        $courier = Courier::findOrFail($request->route('id'));
        $courier->update($validated);
        return redirect()->route('courier')->with('success', 'Courier updated!');
    }
}

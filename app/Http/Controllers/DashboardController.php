<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    //
          public function show()
    {
        return Inertia::render('Dashboard', [
            'orders' => Order::all(),
        ]);
    }
}

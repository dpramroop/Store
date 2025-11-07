<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/Item', [ItemController::class, 'show'])->middleware(['auth', 'verified'])->name('item');
Route::post('/additem', [ItemController::class, 'store'])->middleware(['auth', 'verified'])->name('items.store');

require __DIR__.'/settings.php';

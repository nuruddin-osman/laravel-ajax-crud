<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/ajaxs/index', [AjaxController::class, 'index'])->name('ajaxs.index');

Route::post('/ajaxs/products', [AjaxController::class, 'store'])->name('products.store');
Route::get('/ajaxs/products/{id}/edit', [AjaxController::class, 'edit'])->name('products.edit');
Route::put('/ajaxs/products/{id}', [AjaxController::class, 'update'])->name('products.update');
Route::delete('/ajaxs/products/{id}', [AjaxController::class, 'destroy'])->name('products.destroy');


require __DIR__.'/auth.php';

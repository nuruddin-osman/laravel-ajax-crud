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

Route::get('/ajaxs/index',[AjaxController::class,'index'])->name('ajaxs.index');
Route::post('/ajaxs/index',[AjaxController::class,'store'])->name('ajaxs.store');
Route::get('/ajaxs/index/{id}/edit',[AjaxController::class,'edit'])->name('ajaxs.edit');
Route::put('/ajaxs/index/{id}', [AjaxController::class, 'update'])->name('ajaxs.update');
Route::delete('/ajaxs/index/{id}',[AjaxController::class,'destroy'])->name('ajaxs.destroy');




require __DIR__.'/auth.php';

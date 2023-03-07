<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Mohon maaf saya menggunakan laravel 9 di karnakan php saya versi 8 atas jadi tidak bisa mengguakna laravel 6/7
|
*/

Route::get('/', function () {
    return view('welcome');
});

// route url /test-grid
Route::get('/test-grid', function () {
    return view('components.grid-system');
});

// route url /test-grid
Route::get('/test-flex', function () {
    return view('components.flex-loyout');
});

// route url dari breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';

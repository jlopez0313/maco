<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


use App\Http\Controllers\TenantsController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function () {
            return Inertia::render('Welcome', [
                'canLogin' => Route::has('login'),
                'canRegister' => false,
                'laravelVersion' => '1.0.0',
            ]);
        });

        Route::get('/dashboard', [TenantsController::class, 'index'])
        ->middleware(['auth', 'verified'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware(['auth', 'verified'])->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware(['auth', 'verified'])->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware(['auth', 'verified'])->name('profile.destroy');
        
    });
}




require __DIR__.'/auth.php';

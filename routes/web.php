<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController ;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/clients', [DashboardController::class, 'listClients'])->name('clients.list');
    Route::get('/tokens', [DashboardController::class, 'listTokens'])->name('tokens.list');
    Route::post('/tokens/revoke/{id}', [DashboardController::class, 'revokeToken'])->name('tokens.revoke');
    Route::post('/clients/create', [DashboardController::class, 'createClient'])->name('clients.create');

    Route::put('/clients/update', [DashboardController::class, 'updateClient'])->name('clients.update');
Route::delete('/clients/{id}', [DashboardController::class, 'deleteClient'])->name('clients.delete');
Route::delete('/tokens/{id}', [DashboardController::class, 'deleteToken'])->name('tokens.destroy');





    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

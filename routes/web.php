<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SSOController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // dashboard
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('logout.all');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');

    // Rute-rute yang memerlukan akses admin
    Route::middleware(['admin'])->group(function () {
        // token
        Route::get('/token-index', [SSOController::class, 'tokenindex'])->name('tokens.index');
        Route::get('/tokens', [SSOController::class, 'listTokens'])->name('tokens.list');
        Route::post('/tokens/revoke/{id}', [SSOController::class, 'revokeToken'])->name('tokens.revoke');
        Route::delete('/tokens/{id}', [SSOController::class, 'deleteToken'])->name('tokens.destroy');
        
        // client
        Route::get('/client-index', [SSOController::class, 'clientindex'])->name('clients.index');
        Route::get('/clients', [SSOController::class, 'listClients'])->name('clients.list');
        Route::post('/clients/create', [SSOController::class, 'createClient'])->name('clients.create');
        Route::put('/clients/update', [SSOController::class, 'updateClient'])->name('clients.update');
        Route::delete('/clients/{id}', [SSOController::class, 'deleteClient'])->name('clients.delete');
        
        // user
        Route::get('/user-index', [SSOController::class, 'userindex'])->name('user.index');
        Route::get('/users', [SSOController::class, 'listUsers'])->name('users.list');
        Route::post('/users/create', [SSOController::class, 'createUser'])->name('users.create');
        Route::put('/users/update', [SSOController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [SSOController::class, 'deleteUser'])->name('users.delete');
    });
});

require __DIR__.'/auth.php';

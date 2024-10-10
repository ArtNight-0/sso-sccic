<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->post('/logout-all', [AuthController::class, 'globalLogout']);

// Client & Token Management Routes
Route::get('/clients', [DashboardController::class, 'listClients']);
Route::get('/tokens', [DashboardController::class, 'listTokens']);

// Route to Get User Info
Route::middleware(['auth:api', 'scope:view-user'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route for Logging Out and Deleting Refresh Token
Route::middleware('auth:api')->get('/logmeout', function (Request $request) {
    $user =  $request->user();
    $accessToken = $user->token();
    
    // Delete the associated refresh tokens
    DB::table('oauth_refresh_tokens')
        ->where('access_token_id', $accessToken->id)
        ->delete();
    
    // Delete access token
    $user->token()->delete();

    return response()->json([
        'message' => 'Successfully logged out',
        'session' => session()->all()
    ]);
});

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

// Route::middleware('auth:api')->post('/logout-all', [AuthController::class, 'globalLogout']);

// Route::get('/clients', [DashboardController::class, 'listClients']);
// Route::get('/tokens', [DashboardController::class, 'listTokens']);

// Route::middleware('auth:api', 'scope:view-user')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->get('/logmeout', function (Request $request) {
//     $user =  $request->user();
//     $accessToken = $user->token();
//     DB::table('oauth_refresh_tokens')
//     ->where('access_token_id', $accessToken->id)
//     ->delete();
//     $user->token()->delete();


//     return response()->json([
//         'message' => 'Successfully logged out',
//         'session' => session()->all()
//     ]);
// });





// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:passport');



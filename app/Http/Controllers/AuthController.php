<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
// use App\Models\Client;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    // Register user melalui API
    public function register(Request $request)
    {
        try {
            // Validasi input pengguna
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            // Buat pengguna baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Menghasilkan token Passport
            $token = $user->createToken('Personal Access Token')->accessToken;

            // Mengirimkan respons berhasil
            return response()->json(['token' => $token], 200);

        } catch (\Exception $e) {
            // Log error dan kirimkan respons error
            \Log::error('Register error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while registering. Please try again later.'], 500);
        }
    }


    // Login user melalui API
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;

            // 
            session(['login_success' => true]);

            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // Logout user dari API
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens->each(function ($token) {
            $token->revoke();
        });

        // Pastikan ini dihapus saat logout
        session()->forget(['login_success', 'welcome_shown']);

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    // Global Logout (logout dari semua sesi)
public function globalLogout(Request $request)
{
    $user = Auth::user();
    $user->tokens->each(function ($token) {
        $token->revoke();
    });

    return response()->json(['message' => 'Logged out from all sessions.']);
}

    public function logoutAll(Request $request)
    {
        $user = Auth::user();
        
        // Dapatkan semua client yang terdaftar di Passport
        $clients = Client::all();
        
        foreach ($clients as $client) {
            // Revoke semua token untuk user ini di setiap client
            $user->tokens->where('client_id', $client->id)->each(function ($token) {
                $token->revoke();
            });
            
            // Jika Anda masih ingin mengirim permintaan logout ke setiap client,
            // Anda perlu menambahkan kolom logout_url ke tabel oauth_clients
            // dan menggunakan $client->logout_url di sini
        }
        
        // Logout dari aplikasi SSO
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('status', 'Anda telah berhasil logout dari semua aplikasi.');
    }
}

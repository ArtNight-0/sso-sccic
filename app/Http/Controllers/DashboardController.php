<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung pengguna online dan offline
        $onlineUsers = DB::table('sessions')
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count();
        $totalUsers = User::count();
        $offlineUsers = $totalUsers - $onlineUsers;

        // Ambil data client
        $clients = Client::all();

        // Hitung pengguna aktif untuk setiap client
        $clientStats = $clients->map(function ($client) {
            $activeUsers = DB::table('sessions')
                ->join('oauth_access_tokens', 'sessions.user_id', '=', 'oauth_access_tokens.user_id')
                ->where('oauth_access_tokens.client_id', $client->id)
                ->whereNotNull('sessions.user_id')  
                ->distinct('sessions.user_id')
                ->count();

            return [
                'name' => $client->name,
                'active_users_count' => $activeUsers
            ];
        });

        return view('dashboard', compact('onlineUsers', 'offlineUsers', 'clientStats'));
    }
   
    public function getStats()
    {
        $activeUsers = User::where('status', 'active')->count();
        $offlineUsers = User::where('status', 'offline')->count();
        $totalClients = Client::count();

        return response()->json([
            'activeUsers' => $activeUsers,
            'offlineUsers' => $offlineUsers,
            'totalClients' => $totalClients
        ]);
    }
}

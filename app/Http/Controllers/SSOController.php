<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SSOController extends Controller
{
//User
    public function userindex(Request $request){
        if ($request->ajax()) {
            return view('sso.users')->render();
        }   
        return view('sso.users');
    }

    public function listUsers(Request $request) 
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'created_at', 'role']);

            return DataTables::of($users)
                ->addColumn('status', function ($user) {
                    $isOnline = DB::table('sessions')
                        ->where('user_id', $user->id)
                        ->exists();

                    if ($isOnline) {
                        return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500 text-white">Online</span>';
                    } else {
                        return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500 text-white">Offline</span>';
                    }
                })
                ->editColumn('role', function ($user) {
                    return $user->role ?? 'N/A';
                })
                ->addColumn('action', function ($user) {
                    return '
                        <button class="px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-2" onclick="editUser('.$user->id.')">Edit</button>
                        <button class="px-3 py-1 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="deleteUser('.$user->id.')">Delete</button>
                    ';
                })
                ->rawColumns(['status', 'role', 'action'])
                ->make(true);
        }
        return response()->json(['error' => 'Permintaan tidak valid.'], 400);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$request->id,
            'role' => 'required|string|in:user,admin', // sesuaikan dengan role yang tersedia
        ]);

        $user = User::findOrFail($request->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

//Client
    public function clientindex(Request $request)
    {
        if ($request->ajax()) {
            return view('sso.clients')->render();
        }
        return view('sso.clients');
    }

     public function listClients(Request $request)
    {
        if ($request->ajax()) {
            $clients = Client::select(['id', 'name', 'secret', 'redirect', 'created_at']);
            return DataTables::of($clients)
                ->addColumn('action', function ($client) {
                    return '<a href="#" class="btn btn-danger">Delete</a>';
                })
                ->make(true);
        }

        return view('sso.clients');
    }
    
    public function createClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'redirect' => 'required|string',
        ]);

        $clientRepository = new ClientRepository();

        $client = $clientRepository->create(
            null, // userId
            $request->name,
            $request->redirect,
            null, // provider
            false, // personalAccess
            false, // password
            true  // confidential
        );

        // Gunakan secret yang dibuat oleh Laravel Passport
        $clientSecret = $client->plainSecret;

        return response()->json([
            'message' => 'Client berhasil dibuat',
            'client_id' => $client->id,
            'client_secret' => $clientSecret // Mengembalikan plain text secret
        ]);
    }
    public function updateClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'redirect' => 'required|string',
        ]);

        $client = Client::findOrFail($request->id);
        $client->name = $request->name;
        $client->redirect = $request->redirect;
        $client->save();

        return response()->json(['message' => 'Client updated successfully']);
    }

    public function deleteClient($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }
    //Token
    public function tokenindex(Request $request){
        if ($request->ajax()) {
            return view('sso.tokens')->render();
        }
        return view('sso.tokens');
    }
    // List Tokens with DataTables
    public function listTokens(Request $request)
    {
        if ($request->ajax()) {
            $tokens = Token::with('client')->select(['id', 'client_id', 'user_id', 'revoked', 'created_at']);
            return DataTables::of($tokens)
                ->addColumn('client', function ($token) {
                    return $token->client->name;
                })
                ->addColumn('action', function ($token) {
                    if (!$token->revoked) {
                        return '<form action="' . route('tokens.revoke', $token->id) . '" method="POST">
                        ' . csrf_field() . '
                        <button type="submit" class="btn btn-warning">Revoke</button>
                        </form>';
                    }
                })
                ->make(true);
        }

        return view('sso.tokens');
    }

    public function revokeToken($id)
    {
        $token = Token::find($id);
        if ($token) {
            $token->revoke();
            return redirect()->back()->with('success', 'Token revoked successfully.');
        }
        
        return redirect()->back()->with('error', 'Token not found.');
    }


    public function deleteToken($id)
    {
        $client = Token::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }
    

}


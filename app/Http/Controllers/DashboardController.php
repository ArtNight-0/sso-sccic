<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

      // List Clients with DataTables
    public function listClients(Request $request)
    {
        if ($request->ajax()) {
            $clients = Client::select(['id', 'name', 'secret', 'redirect']);
            return DataTables::of($clients)
                ->addColumn('action', function ($client) {
                    return '<a href="#" class="btn btn-danger">Delete</a>';
                })
                ->make(true);
        }

        return view('sso.clients');
    }

    // List Tokens with DataTables
    public function listTokens(Request $request)
    {
        if ($request->ajax()) {
            $tokens = Token::with('client')->select(['id', 'client_id', 'user_id', 'revoked']);
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
                dd($token);
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

public function createClient(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'redirect' => 'required|string',
    ]);

    $clientRepository = new ClientRepository();

    $client = $clientRepository->createPasswordGrantClient(
        null,
        $request->name,
        $request->redirect
    );

    // Store the client secret in the session
    session()->flash('new_client_secret', $client->plainSecret);

    return response()->json([
        'message' => 'Client created successfully',
        'client_id' => $client->id,
        'client_secret' => $client->plainSecret
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
    public function deleteToken($id)
    {
        $client = Token::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }
}

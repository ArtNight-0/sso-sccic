<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SSOController extends Controller
{
        public function revokeToken(Request $request)
    {
        $tokenId = $request->user()->token()->id; // Get the user's token ID

        // Revoke the user's token
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Token revoked successfully.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API SSO",
 *     version="1.0.0",
 *     description="API untuk manajemen SSO"
 * )
 */

/**
 * @OA\Tag(
 *     name="SSO",
 *     description="API Endpoints untuk SSO"
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/sso/clients"
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/sso/tokens"
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/sso/tokens/{id}/revoke"
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/sso/clients/{id}"
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/sso/tokens/{id}"
 * )
 */

class SSOController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/sso/clients",
     *     summary="Daftar semua klien SSO",
     *     tags={"SSO"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar klien berhasil diambil",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Client")
     *         )
     *     )
     * )
     */
    public function listClients()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    /**
     * @OA\Get(
     *     path="/api/sso/tokens",
     *     summary="Daftar semua token",
     *     tags={"SSO"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar token berhasil diambil",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Token")
     *         )
     *     )
     * )
     */
    public function listTokens()
    {
        $tokens = Token::with('client:id,name')->select(['id', 'client_id', 'user_id', 'revoked'])->get();
        return response()->json($tokens);
    }

    /**
     * @OA\Post(
     *     path="/api/sso/tokens/{id}/revoke",
     *     summary="Cabut token",
     *     tags={"SSO"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token berhasil dicabut",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Token tidak ditemukan"
     *     )
     * )
     */
    public function revokeToken($id)
    {
        $token = Token::find($id);
        if (!$token) {
            return response()->json(['error' => 'Token not found'], 404);
        }
        $token->revoke();
        return response()->json(['message' => 'Token revoked successfully']);
    }

    /**
     * @OA\Post(
     *     path="/api/sso/clients",
     *     summary="Buat klien baru",
     *     tags={"SSO"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/CreateClientRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Klien berhasil dibuat",
     *         @OA\JsonContent(ref="#/components/schemas/CreateClientResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */
    public function createClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'redirect' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPasswordGrantClient(
            null,
            $request->name,
            $request->redirect
        );

        return response()->json([
            'message' => 'Client created successfully',
            'client_id' => $client->id,
            'client_secret' => $client->plainSecret
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/sso/clients/{id}",
     *     summary="Perbarui klien",
     *     tags={"SSO"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/UpdateClientRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Klien berhasil diperbarui",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Klien tidak ditemukan"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */
    public function updateClient(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'redirect' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $client->name = $request->name;
        $client->redirect = $request->redirect;
        $client->save();

        return response()->json(['message' => 'Client updated successfully']);
    }

    /**
     * @OA\Delete(
     *     path="/api/sso/clients/{id}",
     *     summary="Hapus klien",
     *     tags={"SSO"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Klien berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Klien tidak ditemukan"
     *     )
     * )
     */
    public function deleteClient($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }

    /**
     * @OA\Delete(
     *     path="/api/sso/tokens/{id}",
     *     summary="Hapus token",
     *     tags={"SSO"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Token tidak ditemukan"
     *     )
     * )
     */
    public function deleteToken($id)
    {
        $token = Token::find($id);
        if (!$token) {
            return response()->json(['error' => 'Token not found'], 404);
        }
        $token->delete();

        return response()->json(['message' => 'Token deleted successfully']);
    }
}
<?php

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API SSO SCCIC",
 *     description="Dokumentasi API untuk SSO SCCIC",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Server API SSO SCCIC"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Client",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="redirect", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

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

/**
 * @OA\PathItem(
 *     path="/api/tokens"
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tokens",
 *     summary="List all tokens",
 *     tags={"Tokens"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Token"))
 *     ),
 *     @OA\Response(response=401, description="Unauthenticated")
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/tokens/{id}/revoke"
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tokens/{id}/revoke",
 *     summary="Revoke a token",
 *     tags={"Tokens"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="Token revoked successfully"),
 *     @OA\Response(response="404", description="Token not found"),
 *     @OA\Response(response="401", description="Unauthenticated")
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/clients"
 * )
 */

/**
 * @OA\Post(
 *     path="/api/clients",
 *     summary="Create a new client",
 *     tags={"Clients"},
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/CreateClientRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Client created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/CreateClientResponse")
 *     ),
 *     @OA\Response(response="422", description="Validation error"),
 *     @OA\Response(response="401", description="Unauthenticated")
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/clients/{id}"
 * )
 */

/**
 * @OA\Put(
 *     path="/api/clients/{id}",
 *     summary="Update a client",
 *     tags={"Clients"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/UpdateClientRequest")
 *     ),
 *     @OA\Response(response="200", description="Client updated successfully"),
 *     @OA\Response(response="404", description="Client not found"),
 *     @OA\Response(response="422", description="Validation error"),
 *     @OA\Response(response="401", description="Unauthenticated")
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/clients/{id}",
 *     summary="Delete a client",
 *     tags={"Clients"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="Client deleted successfully"),
 *     @OA\Response(response="404", description="Client not found"),
 *     @OA\Response(response="401", description="Unauthenticated")
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/tokens/{id}"
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/tokens/{id}",
 *     summary="Delete a token",
 *     tags={"Tokens"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="Token deleted successfully"),
 *     @OA\Response(response="404", description="Token not found"),
 *     @OA\Response(response="401", description="Unauthenticated")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Token",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="client_id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="revoked", type="boolean"),
 *     @OA\Property(property="client", ref="#/components/schemas/Client")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Client",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="redirect", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="CreateClientRequest",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="redirect", type="string")
 * )
 */

/**
 * @OA\Schema(
 *     schema="CreateClientResponse",
 *     @OA\Property(property="message", type="string"),
 *     @OA\Property(property="client_id", type="integer"),
 *     @OA\Property(property="client_secret", type="string")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateClientRequest",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="redirect", type="string")
 * )
 */
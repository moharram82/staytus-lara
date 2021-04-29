<?php

namespace App\Http\Controllers\Api;

use App\Actions\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if(! $user || ! Hash::check($request->password, $user->password)) {
            return JsonResponses::sendJsonResponse('fail', 404, 'These credentials do not match our records.');
        }

        $token = $user->createToken($request->token_name);

        $data = [
            'user' => [
                'id' => $user->id,
                'email' => $user->email
            ],
            'token' => $token->plainTextToken,
        ];

        return JsonResponses::sendJsonResponse('success', 201, 'Token created successfully!', $data);
    }

    public function loginResponse(): JsonResponse
    {
        return JsonResponses::sendUnauthorizedResponse();
    }
}

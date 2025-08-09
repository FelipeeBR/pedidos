<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $token = $request->user()->createToken('token')->plainTextToken;

            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Usuário ou senha inválidos',
            ], 404);
        }
    }

    public function logout(User $user): JsonResponse {
        try {
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Logout realizado com sucesso'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Erro ao realizar logout',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

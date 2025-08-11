<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(): JsonResponse {

        try {
            $users = User::all();
            return response()->json([
                'version' => 'v1',
                'status' => true,
                'users' => $users,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao buscar usuários: '. $e->getMessage(),
            ], 500);
        }
        
    }

    public function show(User $user): JsonResponse {
        try {
            return response()->json([
                'version' => 'v1',
                'status' => true,
                'user' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao buscar usuário: '. $e->getMessage(),
            ], 500);
        }
    }

    public function store(UserRequest $request) {
        DB::beginTransaction();
        try {
            $user = User::create($request->all());
            DB::commit();
            return response()->json([
                'version' => 'v1',
                'status' => true,
                'user' => $user,
                'message' => 'Usuário criado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar usuário: '.$e->getMessage(),
            ], 400);
        }
    }

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
}

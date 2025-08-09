<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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
                'error' => 'Erro ao buscar usuários',
                'message' => $e->getMessage()
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
                'error' => 'Erro ao buscar usuário',
                'message' => $e->getMessage()
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
                'error' => 'Erro ao criar usuário',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(): JsonResponse {
        try {
            $user = auth('api')->user();
            $orders = Order::where('user_id', $user->id)->get();
            return response()->json([
                'version' => 'v1',
                'status' => true,
                'orders' => $orders
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao buscar pedidos: '.$e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse {
        DB::beginTransaction();
        try {
            $order = Order::create($request->all());
            DB::commit();
            return response()->json([
                'version' => 'v1',
                'status' => true,
                'order' => $order,
                'message' => 'Pedido criado com sucesso'
            ], 201);
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar pedido: '.$e->getMessage(),
            ], 400);
        }
    }

    public function show(Order $order): JsonResponse {
        try {
            $user = auth('api')->user();
            if($order->user_id !== $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pedido pertence a outro usuário',
                ], 403);
            }
            return response()->json([
                'version' => 'v1',
                'status' => true,
                'order' => $order
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao buscar pedido: '.$e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Order $order): JsonResponse {
        DB::beginTransaction();
        try {
            $user = auth('api')->user();
            if($order->user_id !== $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro ao atualizar pedido',
                ], 403);
            }
            $order->update($request->all());
            DB::commit();
            return response()->json([
                'version' => 'v1',
                'status' => true,
                'order' => $order,
                'message' => 'Pedido atualizado com sucesso'
            ], 200);
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar pedido: '.$e->getMessage(),
            ], 400);
        }
    }

    public function destroy(Order $order): JsonResponse {
        try {
            $user = auth('api')->user();
            if($order->user_id !== $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro ao deletar pedido',
                ], 403);
            }
            $order->delete();
            return response()->json([
                'version' => 'v1',
                'status' => true,
                'message' => 'Pedido excluido com sucesso'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir pedido: '.$e->getMessage(),
            ], 500);
        }
    }
}

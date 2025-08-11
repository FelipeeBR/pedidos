<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();

        return view('dashboard', compact('orders'));
    }

    public function storeOrder(Request $request) {
        $user = Auth::user();
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:pending,delivered,cancelled'],
        ]);

        Order::create([
            'user_id' => $user->id,
            'customer_name' => $validated['customer_name'],
            'order_date' => $validated['order_date'],
            'delivery_date' => $validated['delivery_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Pedido criado com sucesso!');
    }

    public function updateOrder(Request $request, Order $order) {
        $user = Auth::user();

        if($order->user_id !== $user->id) {
            abort(403, 'Não autorizado');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:pending,delivered,cancelled'],
        ]);

        $order->update($validated);

        return redirect()->route('dashboard')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Order $order) {
        $user = Auth::user();

        if($order->user_id !== $user->id) {
            abort(403, 'Não autorizado');
        }

        $order->delete();

        return redirect()->route('dashboard')->with('success', 'Pedido excluido com sucesso!');
    }
}

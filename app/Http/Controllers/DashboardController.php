<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();

        return view('dashboard', compact('orders'));
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // 現在のユーザーの注文履歴を取得
        $orders = Order::with(['foods', 'rice'])->where('user_id', Auth::id())->orderBy('order_date', 'desc')->get();

        return view('user.orders', compact('orders'));
    }
}

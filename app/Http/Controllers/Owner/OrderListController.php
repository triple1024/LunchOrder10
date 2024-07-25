<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Throwable;

class OrderListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function($request, $next){
            $id = $request->route()->parameter('food');//foodのid取得
            if(!is_null($id)){ //null判定
                $order = Order::findOrFail($id);
                if($order->owner_id !== Auth::id()){ // owner_idを直接比較する
                    abort(404);//404画面表示
                }
            }
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'rice', 'foods']);

        return view('owner.orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::with(['user', 'rice', 'foods'])->findOrFail($id);
        return view('owner.orders.show', compact('orders'));
    }
}

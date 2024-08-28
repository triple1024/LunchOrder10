<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Stock;
use App\Models\PrimaryCategory;
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
            $id = $request->route()->parameter('food');
            if(!is_null($id)){
                $order = Order::findOrFail($id);
                if($order->owner_id !== Auth::id()){
                    abort(404);
                }
            }
            return $next($request);
        });
    }
        public function index(Request $request)
    {
        // クエリの初期化
        $query = Order::with(['user', 'rice', 'foods.primaryCategory']);

        // 日付フィルター
        if ($request->filled('start_date')) {
            $query->whereDate('order_date', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('order_date', '<=', $request->input('end_date'));
        }

           // ソート機能
        $sort = $request->input('sort', 'order_date'); // デフォルトで 'order_date' でソート
        $direction = $request->input('direction', 'desc'); // デフォルトで降順
        $query->orderBy($sort, $direction);

        // ページネーションの適用
        $orders = $query->paginate(10);

        // プライマリカテゴリのリストを取得
        $primaryCategories = PrimaryCategory::all();

        // ビューにデータを渡す
        return view('owner.orders.index', compact('orders', 'primaryCategories'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'rice', 'foods'])->findOrFail($id);
        return view('owner.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        // 在庫を元に戻す処理
        foreach ($order->foods as $food) {
            foreach ($food->stock as $stock) {
                $stock->quantity += $food->pivot->quantity; // 在庫量を元に戻す
                $stock->save();
            }
        }
        // 注文をキャンセル（削除）
        $order->delete();

        return redirect()->route('owner.orders.index')->with('status', '注文がキャンセルされました。');
    }

}

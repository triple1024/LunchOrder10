<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Stock;
use App\Models\Order;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function($request, $next){
            $id = $request->route()->parameter('food');//foodのid取得
            if(!is_null($id)){ //null判定
                $food = Food::findOrFail($id);
                if($food->owner_id !== Auth::id()){ // owner_idを直接比較する
                    abort(404);//404画面表示
                }
            }
            return $next($request);
        });
    }
    public function index()
{
    // 在庫データを取得
    $stocks = DB::table('t_stocks')
        ->select('food_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('MAX(sort_order) as sort_order'))
        ->groupBy('food_id')
        ->orderBy('sort_order')
        ->get();

    // 食品名を取得
    $foodNames = DB::table('food')
        ->pluck('name', 'id'); // idをキーにして食品名を取得

    // 今日の注文データを取得（ユーザー情報も含む）
    $todayOrders = Order::with(['foods', 'user']) // user リレーションを追加
        ->whereDate('created_at', now()->format('Y-m-d'))
        ->get()
        ->flatMap(function ($order) use ($foodNames) {
            return $order->foods->map(function ($food) use ($order, $foodNames) {
                return [
                    'user_name' => $order->user->name ?? 'Unknown', // ユーザー名
                    'food_name' => $foodNames[$food->id] ?? 'Unknown', // 食品名を取得
                    'quantity' => $food->pivot->quantity
                ];
            });
        });

    // PrimaryCategory別に在庫をグループ化
    $stocksByCategory = $stocks->groupBy(function ($stock) use ($foodNames) {
        $foodName = $foodNames[$stock->food_id] ?? 'Unknown'; // 食品名を取得
        $food = DB::table('food')->where('id', $stock->food_id)->first();
        $primaryCategory = DB::table('secondary_categories')
            ->join('primary_categories', 'secondary_categories.primary_category_id', '=', 'primary_categories.id')
            ->where('secondary_categories.id', $food->secondary_category_id)
            ->value('primary_categories.name');

        return $primaryCategory;
    });

    return view('owner.stocks.index', compact('stocks', 'todayOrders', 'foodNames', 'stocksByCategory'));
}



    public function reorder(Request $request)
    {
        try {
            $stocks = $request->input('stocks');

            if (empty($stocks)) {
                return response()->json(['error' => 'No stocks data received'], 400);
            }

            Log::info('Reorder request data:', ['stocks' => $stocks]);

            foreach ($stocks as $stock) {
                Log::info('Processing stock:', ['stock' => $stock]);

                if (!isset($stock['id']) || !isset($stock['position'])) {
                    return response()->json(['error' => 'Invalid data structure: Missing id or position'], 400);
                }

                $stockModel = Stock::where('food_id', $stock['id'])->first();
                if (!$stockModel) {
                    Log::warning('Stock not found:', ['food_id' => $stock['id']]);
                    continue; // または、エラーを返す
                }

                $stockModel->sort_order = $stock['position'];
                $stockModel->save();
            }

            return response()->json(['message' => 'Order updated successfully']);
        } catch (\Exception $e) {
            Log::error('Reorder error:', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while updating the order. Please try again later.'], 500);
        }
    }

}

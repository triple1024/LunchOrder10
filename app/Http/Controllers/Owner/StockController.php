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
                    'food_id' => $food->id, // 食品IDも取得
                    'quantity' => $food->pivot->quantity
                ];
            });
        });

    // 在庫の順序に基づいて「本日の注文」を並び替える
    $sortedOrders = $todayOrders->sortBy(function ($order) use ($stocks) {
        // 在庫データから対応する食品のsort_orderを取得
        $stock = $stocks->firstWhere('food_id', $order['food_id']);
        return $stock ? $stock->sort_order : PHP_INT_MAX; // 在庫が見つからない場合は最後に並べる
    });

    //    // プライマリーカテゴリー順序を取得
    // $primaryCategoryOrder = $stocks->map(function ($stock) {
    //     $food = DB::table('food')->where('id', $stock->food_id)->first();
    //     $primaryCategory = DB::table('secondary_categories')
    //         ->join('primary_categories', 'secondary_categories.primary_category_id', '=', 'primary_categories.id')
    //         ->where('secondary_categories.id', $food->secondary_category_id)
    //         ->select('primary_categories.name', 'primary_categories.id')
    //         ->first();
    //     return $primaryCategory ? $primaryCategory->id : null;
    // })->unique()->values()->toArray();

     // プライマリーカテゴリーのID順を取得
    $primaryCategoryOrder = DB::table('primary_categories')
    ->orderBy('id')
    ->pluck('id')
    ->toArray();

    // 今日の注文をプライマリーカテゴリーでグループ化
    $todayOrdersByCategory = $sortedOrders->groupBy(function ($order) {
        $food = DB::table('food')->where('id', $order['food_id'])->first();
        $primaryCategory = DB::table('secondary_categories')
            ->join('primary_categories', 'secondary_categories.primary_category_id', '=', 'primary_categories.id')
            ->where('secondary_categories.id', $food->secondary_category_id)
            ->select('primary_categories.name', 'primary_categories.id')
            ->first();
        return $primaryCategory ? $primaryCategory->id : null;
    });

    // プライマリーカテゴリー名を取得
    $primaryCategoryNames = DB::table('primary_categories')
    ->whereIn('id', $primaryCategoryOrder)
    ->pluck('name', 'id');

    // プライマリーカテゴリー別に注文を並び替え
    $sortedOrdersByCategory = collect($primaryCategoryOrder)->mapWithKeys(function ($categoryId) use ($todayOrdersByCategory) {
        return [$categoryId => $todayOrdersByCategory->get($categoryId, collect())];
    });

    // PrimaryCategory別に在庫をグループ化し、ID順に並べ替え
    $stocksByCategory = $stocks->groupBy(function ($stock) {
        $food = DB::table('food')->where('id', $stock->food_id)->first();
        $primaryCategory = DB::table('secondary_categories')
            ->join('primary_categories', 'secondary_categories.primary_category_id', '=', 'primary_categories.id')
            ->where('secondary_categories.id', $food->secondary_category_id)
            ->select('primary_categories.name', 'primary_categories.id')
            ->first();

        return $primaryCategory ? $primaryCategory->id : null;
    })->sortKeys(); // ID順に並べ替え

    // PrimaryCategory名も取得
    $stocksByCategory = $stocksByCategory->mapWithKeys(function ($stocks, $categoryId) {
        $primaryCategoryName = DB::table('primary_categories')
            ->where('id', $categoryId)
            ->value('name');

        return [$primaryCategoryName => $stocks];
    });

    return view('owner.stocks.index', compact('stocks', 'sortedOrdersByCategory', 'foodNames','primaryCategoryNames', 'stocksByCategory'));
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

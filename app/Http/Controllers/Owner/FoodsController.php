<?php

namespace App\Http\Controllers\Owner;

use App\Constants\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Models\Food;
use App\Models\Image;
use App\Models\Owner;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class FoodsController extends Controller
{
    public function __construct()
    {
        // 認証ミドルウェアを適用し、オーナーが認証されているか確認
        $this->middleware('auth:owners');

        // リクエストごとに、foodのIDが指定されている場合は、foodが存在するか確認
        $this->middleware(function($request, $next){
            $id = $request->route()->parameter('food'); // URLからfoodのIDを取得
            if(!is_null($id)){ // IDが指定されている場合
                $food = Food::find($id); // IDでFoodを取得、存在しない場合はnullを返す
                if(is_null($food) || !$food->owner_id){ // foodが存在しない場合またはowner_idがnullの場合
                    abort(404); // フードが存在しないかowner_idが設定されていない場合は404エラー
                }
            }
            return $next($request); // 次のミドルウェアまたはリクエスト処理へ進む
        });
    }

    /**
     * Display a listing of the resource.
  */
    public function index()
    {
        // SecondaryCategoryのIDをsort_orderでソートして取得
        $sortedCategoryIds = SecondaryCategory::orderBy('sort_order')
            ->pluck('id')
            ->toArray();

        $foods = Food::with(['secondaryCategory', 'foodsImage'])
            ->get()
            ->sortBy(function ($food) use ($sortedCategoryIds) {
                // secondaryCategory の ID に基づいてソート
                return array_search($food->secondaryCategory->id, $sortedCategoryIds);
            });

        // オーナー情報とグループ化された食品をビューに渡す
        return view('owner.foods.index', compact('foods'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // 全てのオーナーがアップロードした画像を取得
        $images = Image::select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();

        // 全カテゴリとそのサブカテゴリを取得
        $categories = PrimaryCategory::with('secondary')->get();

        // 画像とカテゴリ情報をビューに渡す
        return view('owner.foods.create', compact('images', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FoodRequest $request)
    {
        try {
            // トランザクションを開始
            DB::transaction(function () use ($request) {
                // 新しい食品のデータを作成
                $food = Food::create([
                    'owner_id' => Auth::id(),
                    'name' => $request->name,
                    'sort_order' => $request->sort_order,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'can_choose_bread' => $request->can_choose_bread,
                    'is_selling' => $request->is_selling
                ]);

                // 新しい在庫データを作成
                Stock::create([
                    'food_id' => $food->id,
                    'type' => 1,
                    'quantity' => $request->quantity,
                ]);
            }, 2);
        } catch (Throwable $e) {
            Log::error($e); // エラーをログに記録
            throw $e; // エラーを再スロー
        }

        // 成功メッセージを表示して食品一覧にリダイレクト
        return redirect()
            ->route('owner.foods.index')
            ->with(['message' => '食品登録しました。',
            'status' => 'info']);
    }

    public function edit(string $id)
    {
        // 指定されたIDの食品を取得
        $food = Food::findOrFail($id);
        // 食品の在庫数量を合計
        $quantity = Stock::where('food_id', $food->id)->sum('quantity');

          // 全てのオーナーがアップロードした画像を取得
        $images = Image::select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();

        // 全カテゴリとそのサブカテゴリを取得
        $categories = PrimaryCategory::with('secondary')->get();

        // 食品、在庫数量、画像、カテゴリ情報をビューに渡す
        return view('owner.foods.edit', compact('food', 'quantity', 'images', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FoodRequest $request, string $id)
    {
        Log::info('Request data before validation: ', $request->all());

        // バリデーションを実行
        $request->validate([
            'current_quantity' => 'required|integer|min:0',
            'can_choose_bread' => 'required|boolean',
        ]);

        Log::info('Request data: ', $request->all());

        // 指定されたIDの食品を取得
        $food = Food::findOrFail($id);
        // 食品の在庫数量を合計
        $quantity = Stock::where('food_id', $food->id)->sum('quantity');

        Log::info('Current quantity from DB: ' . $quantity);

        // リクエストの数量とDBの数量が一致しない場合
        if ((int)$request->current_quantity !== (int)$quantity) {
            Log::info('Quantity mismatch, redirecting back to edit page');
            return redirect()->route('owner.foods.edit', ['food' => $id])
                ->with(['message' => '在庫数が変更されています。再度確認して下さい。',
                    'status' => 'alert']);
        } else {
            Log::info('Quantities match, proceeding to update');

            try {
                Log::info('Starting transaction for food update');

                // トランザクションを開始
                DB::transaction(function () use ($request, $food) {
                    // 食品情報を更新
                    $food->name = $request->name;
                    $food->secondary_category_id = $request->category;
                    $food->image1 = $request->image1;
                    $food->is_selling = $request->is_selling;
                    $food->can_choose_bread = isset($request->can_choose_bread) ? (bool)$request->can_choose_bread : false;
                    $food->save();

                    Log::info('Food updated: ', $food->toArray());

                    // 新しい在庫数量を設定
                    $newQuantity = ($request->type === \Constant::FOOD_LIST['reduce']) ? -$request->quantity : $request->quantity;

                    // 新しい在庫データを作成
                    Stock::create([
                        'food_id' => $food->id,
                        'type' => $request->type,
                        'quantity' => $newQuantity
                    ]);

                    Log::info('Stock updated with new quantity: ' . $newQuantity);
                }, 2);

                Log::info('Transaction completed successfully');

            } catch (Throwable $e) {
                Log::error('Transaction error: ' . $e->getMessage());
                throw $e; // エラーを再スロー
            }

            // 成功メッセージを表示して食品一覧にリダイレクト
            return redirect()
                ->route('owner.foods.index')
                ->with(['message' => '食品情報を更新しました。',
                'status' => 'info']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 指定されたIDの食品を削除
        Food::findOrFail($id)->delete();

        // 成功メッセージを表示して食品一覧にリダイレクト
        return redirect()
            ->route('owner.foods.index')
            ->with(['message' => '食品を削除しました。',
            'status' => 'alert']);
    }
}


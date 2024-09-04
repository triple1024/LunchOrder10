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
        $this->middleware('auth:owners');

        // $this->middleware(function($request, $next){
        //     $id = $request->route()->parameter('food');//shopのid取得
        //     if(!is_null($id)){ //null判定
        //     $foodsOwnerId = Food::findOrFail($id)->food->id;
        //         $foodId = (int)$foodsOwnerId;//キャスト文字列→数値に型変換
        //         if($foodId !== Auth::id()){
        //             abort(404);//404画面表示
        //         }
        //     }
        //     return $next($request);
        // });

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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $ownerInfo = Owner::with('foods.foodsImage')
        ->where('id', Auth::id())->get();

        return view('owner.foods.index',
        compact('ownerInfo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $food = Food::where('owner_id', Auth::id())
        // ->select('id','name')
        // ->get();

        $images = Image::where('owner_id', Auth::id())
        ->select('id','title','filename')
        ->orderBy('updated_at','desc')
        ->get();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        return view('owner.foods.create',
        compact('images','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FoodRequest $request)
    {
        try{
            DB::transaction(function () use ($request) {
                $food = Food::create([
                    'owner_id' => Auth::id(),
                    'name' => $request->name,
                    'sort_order' => $request->sort_order,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'can_choose_bread' => $request->can_choose_bread,
                    'is_selling' => $request->is_selling
                ]);

                Stock::create([
                    'food_id' => $food->id,
                    'type' => 1,
                    'quantity' => $request->quantity,
                ]);
            },2);
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }


        return redirect()
        ->route('owner.foods.index')
        ->with(['message' => '食品登録しました。',
        'status' => 'info']);
    }

    public function edit(string $id)
    {
        $food = Food::findOrFail($id);
        $quantity = Stock::where('food_id',$food->id)
        ->sum('quantity');

        $images = Image::where('owner_id', Auth::id())
        ->select('id','title','filename')
        ->orderBy('updated_at','desc')
        ->get();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        return view('owner.foods.edit',
            compact('food','quantity','images','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FoodRequest $request, string $id)
{
    Log::info('Request data before validation: ', $request->all());

    $request->validate([
        'current_quantity' => 'required|integer|min:0',
        'can_choose_bread' => 'required|boolean',
    ]);

    Log::info('Request data: ', $request->all());

    $food = Food::findOrFail($id);
    $quantity = Stock::where('food_id', $food->id)->sum('quantity');

    Log::info('Current quantity from DB: ' . $quantity);

    if ((int)$request->current_quantity !== (int)$quantity) {
        Log::info('Quantity mismatch, redirecting back to edit page');
        return redirect()->route('owner.foods.edit', ['food' => $id])
            ->with(['message' => '在庫数が変更されています。再度確認して下さい。',
                'status' => 'alert']);
    } else {
        Log::info('Quantities match, proceeding to update');

        try {
            Log::info('Starting transaction for food update');

            DB::transaction(function () use ($request, $food) {
                $food->name = $request->name;
                $food->secondary_category_id = $request->category;
                $food->image1 = $request->image1;
                $food->is_selling = $request->is_selling;

                // Ensure can_choose_bread is always set and is a boolean
                $food->can_choose_bread = isset($request->can_choose_bread) ? (bool)$request->can_choose_bread : false;
                $food->save();

                Log::info('Food updated: ', $food->toArray());

                $newQuantity = ($request->type === \Constant::FOOD_LIST['reduce']) ? $request->quantity * -1 : $request->quantity;

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
            throw $e;
        }

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
        Food::findOrFail($id)->delete();

        return redirect()
        ->route('owner.foods.index')
        ->with(['message' => '食品を削除しました。',
        'status' => 'alert']);
    }
}

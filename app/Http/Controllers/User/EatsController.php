<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\PrimaryCategory;
use App\Models\Rice;
use App\Models\SecondaryCategory;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');

        // $this->middleware(function($request, $next){
        //     $id = $request->route()->parameter('eat');
        //     if(!is_null($id)){ //null判定
        //     $eatId = Food::availableItems()
        //     ->where('food.id', $id)->exists();
        //         if(!$eatId){
        //             abort(404);//404画面表示
        //         }
        //     }
        //     return $next($request);
        // });
    }
    public function index(Request $request)
    {
        $primaryCategories = PrimaryCategory::with('secondary')->get();
        $secondaryCategories = SecondaryCategory::all();

        // 非ゼロの在庫を持つ食品のIDを取得
        $foodIdsWithStock = Stock::where('quantity', '>', 0)->pluck('food_id')->unique()->toArray();

        // 非ゼロの在庫を持つ食品のみを取得
        $foods = Food::whereIn('id', $foodIdsWithStock)->get();

        return view('user.index', compact('foods', 'secondaryCategories', 'primaryCategories'));
    }

    public function show($id)
    {
        $food = Food::findOrFail($id);
        $quantity = Stock::where('food_id',$food->id)
        ->sum('quantity');

        $rices = Rice::all();

        if ($quantity > 9) {
            $quantity = 9;
        }

        return view('user.show',compact('food','quantity','rices'));
    }
}

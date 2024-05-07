<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $foods = $user->food;

        foreach($foods as $food){


        }
    }

    public function add(Request $request)
    {
        // パンが選択された場合は rice_id を適切なデフォルト値に設定する
        if ($request->secondary_category_id === 3 || $request->secondary_category_id === 4) { // パンのsecondary_category_idに実際の値を置き換えてください
            $request->merge(['rice_id' => null]); // お米が選択できないため、rice_id を null に設定する
        }

        // カートに商品があるか確認
        $eatsCart = Cart::whereHas('cartfoods', function($query) use ($request) {
            $query->where('food_id', $request->food_id);
        })
        ->where('user_id', Auth::id())
        ->first();

        // あれば数量を追加
        if ($eatsCart) {
            $eatsCart->quantity += $request->quantity;
            $eatsCart->save();
        } else {
            // なければ新規作成
            Cart::create([
                'user_id' => Auth::id(),
                'food_id' => $request->food_id,
                'quantity' => $request->quantity,
                'rice_id' => $request->rice_id,
            ]);
        }
        // テスト用のメッセージを表示
        // dd($request);

        // ここでリダイレクトや他の処理を行うことができます
        // return redirect()->route('user.cart.index');
    }
}

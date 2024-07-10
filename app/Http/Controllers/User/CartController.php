<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Rice;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with('foods', 'rices')->findOrFail(Auth::id());
        $foods = $user->foods;
        $rices = $user->rices;

        // foreach($foods as $food){

        // }

        // return view('user.cart.index',compact('food','rices'));
    }

    public function add(Request $request)
    {
        // パンが選択された場合は rice_id を適切なデフォルト値に設定する
        $riceId = null;
        if (!is_null($request->rice_id) && ($request->secondary_category_id === 3 || $request->secondary_category_id === 4)) {
            // お米が選択できないため、rice_id を null に設定する
            $riceId = $request->rice_id;
        }

        // ユーザーのカートを取得または作成
        $cart = Cart::firstOrNew(['user_id' => Auth::id()]);
        if (!is_null($riceId)) {
            $cart->rice_id = $riceId;
        }
        $cart->save();

        // カートに商品があるか確認
        $cartFood = $cart->cartfoods()->where('food_id', $request->food_id)->first();

        // あれば数量を追加
        if ($cartFood) {
            $cartFood->pivot->update(['quantity' => $cartFood->pivot->quantity + $request->quantity]);
        } else {
            // なければ新規作成
            $cart->cartfoods()->attach($request->food_id, ['quantity' => $request->quantity, 'user_id' => Auth::id()]);
        }

        // デバッグ用にカートの内容を表示
        dd($cart->load('cartfoods'));

        // リダイレクト
        return redirect()->route('user.cart.index');
    }



}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use App\Models\Rice;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
        public function index(Request $request)
    {
        $user = User::with('foods')->findOrFail(Auth::id());
        $foods = $user->foods;

        // 現在のユーザーのカートを取得
        $cart = Cart::with(['cartfoods', 'cartfoods.rice'])->where('user_id', Auth::id())->first();
        $riceId = $cart ? $cart->rice_id : null;

        // すべてのRiceを取得
        $rices = Rice::all();

        // カート内のfoodに対応するrice情報を取得
        $cartFoodsWithRice = $cart ? $cart->cartfoods->map(function ($food) use ($riceId) {
            $food->rice = Rice::find($riceId);
            return $food;
        }) : collect();

        return view('user.cart', compact('foods', 'rices', 'riceId', 'cartFoodsWithRice'));
    }


    public function add(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'food_id' => 'required|exists:food,id',
            'rice_id' => 'nullable|exists:rice,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // バリデーションエラーが発生した場合は元のページにリダイレクトしてエラーメッセージを表示
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ユーザーのカートを取得または作成
        $cart = Cart::firstOrNew(['user_id' => Auth::id()]);

        // カート内の合計数量を計算
        $currentQuantity = $cart->cartfoods()->sum('quantity');

           // 追加しようとしている食べ物のprimary_category_idを取得
          // 追加しようとしている食べ物のsecondary_category_idを取得
        $food = Food::find($request->food_id);
        $secondaryCategoryId = $food->secondary_category_id;

          // secondary_category_idが1、2、または13の場合はカート内で合計1つまでしか注文できない
        if (in_array($secondaryCategoryId, [1, 2, 5])) {
            $existingFoods = $cart->cartfoods()->get();
            $totalQuantityForCategory = 0;
            foreach ($existingFoods as $existingFood) {
                if (in_array($existingFood->secondary_category_id, [1, 2, 5])) {
                    $totalQuantityForCategory += $existingFood->pivot->quantity;
                }
            }

            // 新しく追加する量を含めて、カテゴリの合計が1を超える場合はエラー
            if ($totalQuantityForCategory + $request->quantity > 1) {
                return redirect()->back()->with('error', '弁当は1個までしか注文できません。')->withErrors($validator)->withInput();
            }
        }

        // secondary_category_idが3または4（パンの場合）のものを取得
        if (in_array($secondaryCategoryId, [3, 4])) {
            $existingFoods = $cart->cartfoods()->get();
            $totalQuantityForPain = 0;
            foreach ($existingFoods as $existingFood) {
                if (in_array($existingFood->secondary_category_id, [3,4])) {
                    $totalQuantityForPain += $existingFood->pivot->quantity;
                }
            }

            // 新しく追加する量を含めて、パンの合計が2を超える場合はエラー
            if ($totalQuantityForPain + $request->quantity > 2) {
                return redirect()->back()->with('error', 'パンは合計2個までしか注文できません。')->withErrors($validator)->withInput();
            }
        }


       // パンを選択するボタンがクリックされた場合の処理
        if ($request->has('choose_bread')) {
            $riceId = 4; // ご飯なし
            // $quantity = 1; // パンは1個
        } else {
            $riceId = $request->input('rice_id');

            // リクエストで送信された rice_id の値が null または空文字の場合、適切なデフォルト値を設定する
            if (is_null($riceId) || $riceId === '') {
                // パンが選択された場合は rice_id を 4 (ご飯なし) に設定する
                if ($secondaryCategoryId === 3 || $secondaryCategoryId === 4) {
                    $riceId = 4; // 4はご飯なしのIDに対応する値です。適宜修正してください。
                } else {
                    // それ以外の場合、適切なデフォルト値を設定する
                    $riceId = 1; // ここを適切なデフォルト値に修正する必要があります
                }
            }
            // $quantity = $request->quantity;
        }

        $cart->rice_id = $riceId; // rice_id を設定
        $cart->save();

        // カートに商品があるか確認
        $cartFood = $cart->cartfoods()->where('food_id', $request->food_id)->first();

        if ($cartFood) {
            $cartFood->pivot->update(['quantity' => $request->quantity]); // 数量を更新
        } else {
            $cart->cartfoods()->attach($request->food_id, [
                'quantity' => $request->quantity,
                'user_id' => Auth::id()
            ]); // 新規追加
        }

          // パンを選択するボタンがクリックされた場合、ホーム画面にリダイレクト
        if ($request->has('choose_bread')) {
            return redirect()->route('user.eats.index')->with('success', '商品がカートに追加されました。');
        }

        // リダイレクト
        return redirect()->route('user.cart.index')->with('success', '商品がカートに追加されました。');
    }

    public function delete($id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            // 特定の商品を削除
            $cart->cartfoods()->detach($id);

            // カートに他の食べ物がない場合、カート自体も削除
            if ($cart->cartfoods()->count() == 0) {
                $cart->delete();
            }
        }

        return redirect()->route('user.cart.index');
    }

    public function update(Request $request, $foodId)
    {
        // バリデーション
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // ユーザーのカートを取得
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return redirect()->route('user.cart.index')->with('error', 'カートが見つかりませんでした。');
        }

        // カート内の特定の食べ物を取得
        $cartFood = $cart->cartfoods()->where('food_id', $foodId)->first();

        if ($cartFood) {
            // 新しい数量を更新
            $cartFood->pivot->update(['quantity' => $request->quantity]);
        }

        return redirect()->route('user.cart.index')->with('success', '数量が更新されました。');
    }

    public function checkout()
    {
        $cart = Cart::with(['cartfoods', 'cartfoods.rice'])->where('user_id', Auth::id())->first();

        // カートの状態を確認
        // dd($cart);

        if (!$cart) {
            return redirect()->route('user.cart.index')->with('error', 'カートが空です。');
        }

        // 新しい注文を作成
        $order = Order::create([
            'user_id' => Auth::id(),
            'rice_id' => $cart->rice_id,
            'order_date' => now(),
        ]);

         // カート内のフードを注文に追加し、在庫を減らす
        foreach ($cart->cartfoods as $food) {

            $order->foods()->attach($food->id, ['quantity' => $food->pivot->quantity]);

                   // 在庫を減らす
                $stock = Stock::where('food_id', $food->id)->first();
                // dd($stock, $food); // 更新前の状態を確認

                if ($stock) {
                    $stock->quantity -= $food->pivot->quantity;


                    // 在庫が0以下になる場合は、Food の is_selling を 0 に設定
                    if ($stock->quantity <= 0) {
                        $stock->quantity = 0;
                        $food->is_selling = 0;  // Food モデルの is_selling を 0 に設定
                    } else {
                        $food->is_selling = 1;  // 在庫が残っている場合は、is_selling を 1 に設定
                    }


                    $stock->save();
                    $food->save();  // Food モデルの更新を保存
                }
        }

        // カートをクリア
        $cart->cartfoods()->detach();
        $cart->delete();

        return redirect()->route('user.cart.index')->with('success', '注文が完了しました。');
    }


}

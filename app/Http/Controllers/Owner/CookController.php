<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Order;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CookController extends Controller
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
            // 今日の日付を取得
        $today = now()->format('Y-m-d');

        // 当日のご飯の注文量を集計
        $riceOrders = Order::whereDate('order_date', $today)
            ->with(['user', 'rice'])
            ->get();

        $orderCount = $riceOrders->whereIn('rice.id', [1, 2, 3])->count();

        // 注文者ごとに200グラムずつ炊く量を計算
        $riceAmount = $orderCount * 200; // 総炊き上がり量
        $riceCups = ceil($riceAmount / 340 * 2) / 2; // 0.5合単位で切り上げ

        // ビューにデータを渡す
        return view('owner.cooks.index', compact('riceOrders','riceCups'));
        }
}

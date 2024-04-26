<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Rice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Throwable;

class RiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function($request, $next){
            $id = $request->route()->parameter('shop');//shopのid取得
            if(!is_null($id)){ //null判定
            $riceOwnerId = Rice::findOrFail($id)->owner->id;
                $riceId = (int)$riceOwnerId;//キャスト文字列→数値に型変換
                $ownerId = Auth::id();
                if($riceId !== $ownerId){
                    abort(404);//404画面表示
                }
            }
            return $next($request);
        });

        // {
        //     $this->middleware('auth:owners')->only(['edit', 'update', 'destroy']);

        //     $this->middleware(function($request, $next){
        //         $id = $request->route()->parameter('rice');
        //         if(!is_null($id)) {
        //             $rice = Rice::find($id);
        //             if(!$rice || $rice->owner_id !== Auth::id()) {
        //                 abort(404);
        //             }
        //         }
        //         return $next($request);
        //     })->only(['edit', 'update', 'destroy']);
        // }

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rices = Rice::all();

        return view('owner.rices.index', compact('rices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.rices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric','between:1,999'],
            'is_selling' => ['required', 'boolean']
        ]);

        try{
            DB::transaction(function () use ($request) {
                Rice::create([
                    'name' => $request->name,
                    'weight' => $request->weight,
                    'is_selling' => $request->is_selling
                ]);
            },2);
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }

        return redirect()
        ->route('owner.rices.index')
        ->with(['message' => 'ご飯を登録しました。',
        'status' => 'info']);

    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
        {
    //     dd($id);
        $rice = Rice::findOrFail($id);

        return view('owner.rices.edit',
            compact('rice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric','between:1,999'],
            'is_selling' => ['required', 'boolean']
        ]);

        $rice = $request->rice;
        $rice = Rice::findOrFail($id);
        $rice->name = $request->name;
        $rice->weight = $request->weight;
        $rice->is_selling = $request->is_selling;
        $rice->save();

        return redirect()
        ->route('owner.rices.index')
        ->with(['message' => 'ご飯の情報を更新しました。',
        'status' => 'info']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Rice::findOrFail($id)->delete();

        return redirect()
        ->route('owner.rices.index')
        ->with(['message' => 'ご飯を削除しました。',
        'status' => 'alert']);
    }
}

<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Throwable;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:owners');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            // dd($e_all, $q_get, $q_first, $c_test);
            $users = User::select('id','name','email','created_at')
            ->paginate(5);

            return view('owner.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->name;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:Users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
        ->route('owner.users.index')
        ->with(['message' => 'ユーザー登録を実施しました。',
        'status' => 'info']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        // dd($User);
        return view('owner.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()
        ->route('owner.users.index')
        ->with(['message' => 'ユーザー情報を更新しました。',
        'status' => 'info']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        // dd('削除処理');

        return redirect()
        ->route('owner.users.index')
        ->with(['message' => 'ユーザー情報を削除しました。',
        'status' => 'alert']);
    }

    // public function canceledUserIndex(){
    //     $canceledUsers = User::onlyTrashed()->get();
    //     return view('owner.canceled-users', compact('canceledUsers'));
    // }

    // public function canceledUserDestroy($id){
    //     User::onlyTrashed()->findOrFail($id)->forceDelete();
    //     return redirect()->route('owner.canceled-users.index');
    // }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\PrimaryCategory;
use App\Models\Rice;
use App\Models\SecondaryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EatsController extends Controller
{
    public function index(Request $request)
    {
        $foods = Food::all();
        $primaryCategories = PrimaryCategory::with('secondaryCategories')
        ->get();
        $secondaryCategories = SecondaryCategory::all();
        $rices = Rice::all();

        return view('user.index',
        compact('foods','secondaryCategories','primaryCategories','rices'));
    }
}

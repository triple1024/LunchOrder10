<?php

namespace App\Models;

use App\Models\Food;
use App\Models\User;
use App\Models\Rice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rice_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
    public function rice()
    {
        return $this->belongsTo(Rice::class, 'rice_id');
    }

    public function cartfoods()
    {
        return $this->belongsToMany(Food::class, 'cart_food', 'cart_id', 'food_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function riceItem()
    {
        return $this->belongsTo(Rice::class, 'rice_id');
    }
}


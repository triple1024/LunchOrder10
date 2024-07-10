<?php

namespace App\Models;

use App\Models\Owner;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rice extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'weight',
        'is_selling'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'rice_id');
    }
}

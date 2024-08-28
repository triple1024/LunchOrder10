<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Stock extends Model
{
    use HasFactory;

    protected $table = 't_stocks';

    protected $fillable = [
        'food_id',
        'type',
        'quantity',
        'sort_order'
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}

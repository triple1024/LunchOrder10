<?php

namespace App\Models;

use App\Models\Food;
use App\Models\PrimaryCategory;
use App\Models\Rice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'rice_id', 'order_date'];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rice()
    {
        return $this->belongsTo(Rice::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'order_food')->withPivot('quantity')->withTimestamps();
    }

    public function primaryCategory()
    {
        return $this->belongsTo(PrimaryCategory::class);
    }

}


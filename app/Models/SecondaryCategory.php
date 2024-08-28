<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Food;
use App\Models\PrimaryCategory;

class SecondaryCategory extends Model
{
    use HasFactory;
    public function primary()
    {
        return $this->belongsTo(PrimaryCategory::class, 'primary_category_id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class,'secondary_category_id',);
    }
}

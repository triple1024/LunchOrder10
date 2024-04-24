<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'is_selling',
        'sort_order',
        'secondary_category_id',
        'image1',
    ];

    public function foodsImage()
    {
        return $this->belongsTo(Image::class, 'image1','id');
    }
}

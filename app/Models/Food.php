<?php

namespace App\Models;

use App\Models\Image;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
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

    public function secondaryCategory()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    public function primaryCategory()
    {
        return $this->belongsTo(PrimaryCategory::class, 'primary_category_id');
    }


}

<?php

namespace App\Models;

use App\Models\Owner;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'filename',
        'public_id'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

        public function getImageUrlAttribute()
    {
        return Cloudinary::getUrl($this->public_id);
    }
}

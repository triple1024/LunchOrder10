<?php

namespace App\Models;

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
}

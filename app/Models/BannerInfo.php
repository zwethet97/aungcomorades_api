<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'banner_image',
        'title',
        'description'
    ];
}

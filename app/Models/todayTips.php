<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todayTips extends Model
{
    use HasFactory;
    protected $fillable = [
        'tips_id',
        'date',
        'bannerImageOne',
        'imageOneDescription',
        'bannerImageTwo',
        'imageTwoDescription',
        'bannerImageThree',
        'imageThreeDescription',
        'date',
    ];
}

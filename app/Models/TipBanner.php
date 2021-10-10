<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipBanner extends Model
{
    use HasFactory;
    protected $fillable = [
        'bannerImage'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class D2d extends Model
{
    use HasFactory;

    protected $fillable = [
        '2D',
        'time',
        'date',
        'day'
    ];
}

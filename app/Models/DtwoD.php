<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DtwoD extends Model
{
    use HasFactory;
    protected $fillable = [
        '2d_1201',
        'set_1201',
        'value_1201',
        'internet_930',
        'modern_930',
        '2d_430',
        'set_430',
        'value_430',
        'internet_200',
        'modern_200',
        'date',
        'tw_1206',
        'day'
    ];
}

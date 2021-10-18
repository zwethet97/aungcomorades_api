<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'tip_id',
        'date',
        'time',
        'twod',
        'banner_one',
        'banner_two',
        'banner_three',
        'description_one',
        'description_two',
        'description_three',
        'result'
    ];
}

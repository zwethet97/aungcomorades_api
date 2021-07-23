<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DtwoD extends Model
{
    use HasFactory;
    protected $fillable = [
        '2D',
        'modern',
        'internet',
        'time',
        'date',
        'day'
    ];
}

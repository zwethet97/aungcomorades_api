<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DthreeD extends Model
{
    use HasFactory;
    protected $fillable = [
        '3D',
        'modern',
        'internet',
        'set',
        'value',
        'time',
        'date',
        'day'
    ];
}

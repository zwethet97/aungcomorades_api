<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DthreeD extends Model
{
    use HasFactory;
    protected $fillable = [
        'Thai3D',
        'time',
        'date',
        'day'
    ];
}

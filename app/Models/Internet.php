<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internet extends Model
{
    use HasFactory;
    protected $fillable = [
        'internet',
        'time',
        'date',
        'day'
    ];
}

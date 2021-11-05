<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rewards extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'type',
        'receive_from',
        'amount',
        'time'
    ];
}

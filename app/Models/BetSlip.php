<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetSlip extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'forDate',
        'forTime',
        'type',
        'bet-numbers',
        'total-bet-amount',
        'status',
        'selected-total-number'
    ];
}

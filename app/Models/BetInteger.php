<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetInteger extends Model
{
    use HasFactory;
    protected $fillable = [
        'bet-slip-id',
        'integer',
        'amount'
    ];
}

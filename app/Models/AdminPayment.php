<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'accountnumber',
        'platform',
        'username'
    ];
}

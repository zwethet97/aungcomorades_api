<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bettors extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'phone-number',
        'credits',
        'date-of-birth',
        'profile-pic-source',
        'user-level',
        'password',
        'referral-code'
    ];
}

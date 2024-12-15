<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
    /** @use HasFactory<\Database\Factories\AuthenticationFactory> */
    use HasFactory;


    protected $fillable = [
        'email',
        'password',
    ];
}

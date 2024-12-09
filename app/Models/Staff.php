<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'role', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

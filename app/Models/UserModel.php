<?php

namespace App\Models;
use Illuminate\Foundation\Auth\UserModel as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
     use Notifiable;

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Hidden fields when serializing
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Optional: cast for fields
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

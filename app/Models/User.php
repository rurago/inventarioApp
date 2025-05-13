<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',    
        'email',   
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
    ];

    // Reemplaza el campo password usado por Laravel
    public function getAuthPassword()
    {
        return $this->password;
    }
}

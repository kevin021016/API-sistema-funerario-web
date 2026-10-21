<?php

namespace App\Models;


// ESTA LÍNEA ES LA QUE ACTIVA EL createToken()
use Laravel\Sanctum\HasApiTokens; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // REVISA QUE HASAPITOKENS ESTÉ AQUÍ ADENTRO:
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'telefono',
        'last_active_at',
    ];
    
    // ...

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

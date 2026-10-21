<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Colonia extends Model
{
    use HasFactory;

    // Campos que se pueden llenar mediante formularios
    protected $fillable = [
        'nombre',
        'codigo_postal'
    ];

    // Configuración para que las fechas siempre se devuelvan como YYYY-MM-DD
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d',
            'updated_at' => 'datetime:Y-m-d',
        ];
    }
}
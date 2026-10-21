<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    use HasFactory;

    // Campos que se pueden llenar mediante formularios
    protected $fillable = [
        'nombre',
        'apellidos',
        'fecha_nacimiento',
        'calle',
        'entre_calles',
        'colonia',
        'ciudad',
        'codigo_postal',
        'referencia_domicilio',
        'telefono',
        'celular'
    ];

    // Configuración para que las fechas siempre se devuelvan como YYYY-MM-DD
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d',
            'updated_at' => 'datetime:Y-m-d',
            'fecha_nacimiento' => 'date:Y-m-d',
        ];
    }

    // Relación: Un cliente tiene muchos contratos
    public function contratos()
    {
        return $this->hasMany(Contract::class);
    }
}
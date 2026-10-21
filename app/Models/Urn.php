<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urn extends Model
{
    use HasFactory;

    protected $fillable = ['model_name', 'stock'];

    // Relación: Una urna puede estar en muchos contratos
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
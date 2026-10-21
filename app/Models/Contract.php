<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'sale_date',
        'first_payment_date',
        'client_id',
        'urn_id',
        'base_service_id',
        'pet_name',
        'pet_breed',
        'pet_weight',
        'subtotal_services',
        'urn_price',
        'subtotal_extras',
        'total_price',
        'payment_scheme',
        'payment_frequency',
        'payment_amount',
        'total_payments',
        'down_payment',
        'additional_services_json'
    ];

    // Casteamos el campo JSON para usarlo directamente como array en PHP
    protected $casts = [
        'additional_services_json' => 'array',
    ];

    /* |--------------------------------------------------------------------------
    | CAMPOS VIRTUALES (ACCESSORS)
    |--------------------------------------------------------------------------
    | Agregamos estas propiedades para que Laravel las calcule dinámicamente
    | y las envíe en todas las respuestas de la API.
    */
    protected $appends = [
        'remaining_balance',
        'status',
        'payments_total',
        'total_paid'
    ];

    /**
     * Calcula el saldo restante (Total - Enganche/Abonos)
     */
public function getRemainingBalanceAttribute()
{
    return round(
        floatval($this->total_price)
        - floatval($this->total_paid),
        2
    );
}
    public function getPaymentsTotalAttribute()
{
    return $this->payments()->sum('amount');
}
public function getTotalPaidAttribute()
{
    return floatval($this->down_payment)
        + floatval($this->payments_total);
}



    /**
     * Determina el estatus del contrato
     */
    public function getStatusAttribute()
    {
        // Si el saldo pendiente es 0 o menor, está pagado por completo
        return $this->remaining_balance <= 0 ? 'Liquidado' : 'Con Adeudo';
    }

    /* |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */
    public function urn()
    {
        return $this->belongsTo(Urn::class);
    }

    public function baseService()
    {
        return $this->belongsTo(Service::class, 'base_service_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
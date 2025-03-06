<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'landlord_id',
        'tenant_id',
        'start_date',
        'end_date',
        'total_amount',
        'insurance_amount',
        'contract_image',
        'penalty_amount'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function landlord()
{
    return $this->belongsTomany(User::class, 'landlord_id');
}


public function tenant()
{
    return $this->belongsTo(User::class, 'tenant_id');
}
}

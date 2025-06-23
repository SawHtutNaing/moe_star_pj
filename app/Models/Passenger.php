<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'passenger_name',
        'passenger_phone',
        'passenger_nrc',
        'car_front_cabin',
        'passenger_type',
        'passenger_type_pricing',
        'offer_things',
    ];

    protected $casts = [
        'offer_things' => 'array',
        'car_front_cabin' => 'boolean',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function getTotalPricingAttribute()
    {
        $basePrice = $this->passenger_type_pricing;
        $offerPrice = collect($this->offer_things)->sum('pricing');
        $frontCabinFee = Setting::where('name', 'car_front_cabin_fee')->first()->value ?? 0;
        $frontCabinSurcharge = $this->trip->passengers()->where('car_front_cabin', true)->exists() ? $frontCabinFee : 0;
        return $basePrice + $offerPrice + $frontCabinSurcharge;
    }
}

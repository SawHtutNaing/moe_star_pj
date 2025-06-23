<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'start_time',
        'start_car_gate',
        'end_gate',
        'driver_id',
        'car_id',
        'fee_for_driver',
        'car_oil_pricing',
        'fee_for_bridge_pass',
        'fee_for_gate_pass',
        'deductions',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'deductions' => 'array',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
}

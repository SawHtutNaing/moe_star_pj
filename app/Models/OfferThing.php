<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferThing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'pricing', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

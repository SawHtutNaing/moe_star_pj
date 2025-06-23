<?php

namespace Database\Seeders;

use App\Models\PassengerType;
use Illuminate\Database\Seeder;

class PassengerTypeSeeder extends Seeder
{
    public function run(): void
    {
        PassengerType::create(['type' => 'from_gate', 'pricing' => 5000]);
        PassengerType::create(['type' => 'from_route', 'pricing' => 3000]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'name' => 'car_front_cabin_fee',
            'value' => '5000',
        ]);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time')->nullable();
            $table->string('start_car_gate')->nullable();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->decimal('fee_for_driver', 8, 2)->nullable();
            $table->decimal('car_oil_pricing', 8, 2)->nullable();
            $table->decimal('fee_for_bridge_pass', 8, 2)->nullable();
            $table->decimal('fee_for_gate_pass', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};

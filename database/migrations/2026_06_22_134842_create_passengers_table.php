<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('passenger_name')->nullable();
            $table->string('passenger_phone')->nullable();
            $table->string('passenger_nrc')->nullable();
            $table->string('passenger_type')->nullable();
            $table->decimal('passenger_type_pricing', 8, 2)->nullable();
            $table->json('offer_things')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};

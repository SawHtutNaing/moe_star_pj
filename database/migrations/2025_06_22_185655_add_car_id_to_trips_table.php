<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarIdToTripsTable extends Migration
{
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->foreignId('car_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
            $table->dropColumn('car_id');
        });
    }
}

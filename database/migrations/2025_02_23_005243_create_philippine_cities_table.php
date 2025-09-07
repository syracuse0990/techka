<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('philippine_cities', function (Blueprint $table) {
            $table->id();
            $table->string('psgc_code', 20);
            $table->string('city_name', 150);
            $table->string('region_code', 20);
            $table->string('province_code', 20);
            $table->string('city_code', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('philippine_cities');
    }
};

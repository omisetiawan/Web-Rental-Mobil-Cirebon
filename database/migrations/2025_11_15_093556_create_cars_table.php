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
    Schema::create('cars', function (Blueprint $table) {
        $table->id();

        $table->string('brand');
        $table->string('model');
        $table->string('plate_number')->unique();
        $table->integer('year')->index();

        // Make price consistent with integer (Seeder uses integer)
        $table->integer('price_per_day');

        $table->enum('status', ['available', 'rented', 'maintenance'])
            ->default('available')
            ->index();

        // === Missing fields (from seeder) ===
        $table->string('color')->nullable();
        $table->string('fuel_type')->nullable();
        $table->string('transmission')->nullable();
        $table->integer('seat_capacity')->nullable();

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Relasi mobil aman
            $table->foreignId('car_id')
                ->constrained()
                ->restrictOnDelete();

            // Data tamu (karena booking offline)
            $table->string('customer_name');
            $table->string('customer_phone');

            // Informasi booking
            $table->date('start_date');
            $table->date('end_date');

            // Harga final disimpan
            $table->decimal('total_price', 12, 2);

            // Status proses booking
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])
                ->default('pending')
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

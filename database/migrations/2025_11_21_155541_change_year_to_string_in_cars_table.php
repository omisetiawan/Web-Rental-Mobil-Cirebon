<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus index terlebih dahulu
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex(['year']);
        });

        // Backup data sementara
        DB::statement('ALTER TABLE cars ADD year_temp VARCHAR(20)');
        DB::statement('UPDATE cars SET year_temp = CAST(year as CHAR)');

        // Hapus kolom lama
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('year');
        });

        // Buat kolom baru sebagai string
        Schema::table('cars', function (Blueprint $table) {
            $table->string('year', 20)->after('plate_number');
        });

        // Restore data
        DB::statement('UPDATE cars SET year = year_temp');
        DB::statement('ALTER TABLE cars DROP COLUMN year_temp');

        // Tambahkan index kembali
        Schema::table('cars', function (Blueprint $table) {
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus index terlebih dahulu
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex(['year']);
        });

        // Backup data sementara
        DB::statement('ALTER TABLE cars ADD year_temp INT');
        DB::statement('UPDATE cars SET year_temp = CAST(year as UNSIGNED)');

        // Hapus kolom lama
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('year');
        });

        // Buat kolom baru sebagai integer
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('year')->after('plate_number');
        });

        // Restore data
        DB::statement('UPDATE cars SET year = year_temp');
        DB::statement('ALTER TABLE cars DROP COLUMN year_temp');

        // Tambahkan index kembali
        Schema::table('cars', function (Blueprint $table) {
            $table->index('year');
        });
    }
};

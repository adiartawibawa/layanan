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
        Schema::table('layanan_permohonan', function (Blueprint $table) {
            // Menambahkan kolom `status` dengan tipe CHAR untuk menyimpan status terkini.
            $table->char('status')->default('0')->after('formulir');
            // Nilai default `0` bisa disesuaikan, misalnya untuk menunjukkan status awal "DIBUAT".
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanan_permohonan', function (Blueprint $table) {
            // Menghapus kolom `status` jika migrasi dibatalkan.
            $table->dropColumn('status');
        });
    }
};

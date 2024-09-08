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
        Schema::create('layanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->assignOrganization();
            $table->string('nama');
            $table->string('slug');
            $table->char('estimasi');
            $table->text('desc')->nullable();
            $table->text('panduan')->nullable();
            $table->text('prasyarat')->nullable();
            $table->text('formulir')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('layanan_permohonan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->foreignUuid('layanan_id');
            $table->text('prasyarat')->nullable();
            $table->text('formulir')->nullable();
            $table->timestamps();
        });

        Schema::create('layanan_permohonan_history', function (Blueprint $table) {
            $table->id();
            $table->uuidMorphs('permohonan');
            $table->char('status')->default(0); //0:dikirim; 1:diproses; 2:dikembalikan; 3:berhasil; 4:gagal
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_permohonan_history');
        Schema::dropIfExists('layanan_permohonan');
        Schema::dropIfExists('layanans');
    }
};

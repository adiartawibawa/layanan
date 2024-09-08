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
        Schema::create('sekolah_bentuks', function (Blueprint $table) {
            $table->id();
            $table->char('code', 8)->unique();
            $table->string('name');
            $table->string('slug');
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('sekolahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->assignOrganization();
            $table->string('npsn', 8);
            $table->string('nama');
            $table->string('slug');
            $table->char('sekolah_bentuks_code', 8);
            $table->string('status', 10)->nullable();
            $table->text('alamat')->nullable();
            $table->char('desa_code', 10)->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('desa_code')
                ->references('code')
                ->on('desas');

            $table->foreign('sekolah_bentuks_code')
                ->references('code')
                ->on('sekolah_bentuks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah_bentuks');
        Schema::dropIfExists('sekolahs');
    }
};

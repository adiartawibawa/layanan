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
        Schema::create('provinsis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('code', 2)->unique();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->longText('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('kabupatens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('code', 4)->unique();
            $table->char('provinsi_code', 2);
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->longText('meta')->nullable();
            $table->timestamps();

            $table->foreign('provinsi_code')
                ->references('code')
                ->on('provinsis')
                ->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('kecamatans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('code', 7)->unique();
            $table->char('kabupaten_code', 4);
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->longText('meta')->nullable();
            $table->timestamps();

            $table->foreign('kabupaten_code')
                ->references('code')
                ->on('kabupatens')
                ->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('desas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('code', 10)->unique();
            $table->char('kecamatan_code', 7);
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->longText('meta')->nullable();
            $table->timestamps();

            $table->foreign('kecamatan_code')
                ->references('code')
                ->on('kecamatans')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desas');
        Schema::dropIfExists('kecamatans');
        Schema::dropIfExists('kabupatens');
        Schema::dropIfExists('provinsis');
    }
};

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
        Schema::create('jenis_prasaranas', function (Blueprint $table) {
            $table->id();
            $table->char('kode_sarana', 25)->nullable();
            $table->string('name'); // Ruang Sirkulasi, Lapangan, Parkir, Kantin, Lahan Kosong, Tanah
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('referensi_ruangs', function (Blueprint $table) {
            $table->id();
            $table->char('kode_referensi', 25)->nullable();
            $table->string('referensi'); // Ruang Kelas, Ruang Kepsek/Guru, Ruang Laboratorium, Ruang Perpustakaan, Ruang Praktek/bengkel, Ruang Penunjang
            $table->string('name'); // Ruang Sirkulasi, Lapangan, Parkir, Kantin, Lahan Kosong, Tanah
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('tanahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->assignOrganization();
            $table->foreignId('jenis_prasarana_id')->constrained()->references('id')->on('jenis_prasaranas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama');
            $table->string('no_sertifikat');
            $table->decimal('panjang');
            $table->decimal('lebar');
            $table->decimal('luas');
            $table->decimal('luas_tersedia');
            $table->string('kepemilikan'); // Miik, Sewa, Pinjam, Bukan Milik
            $table->decimal('njop')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('bangunans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->assignOrganization();
            $table->foreignId('jenis_prasarana_id')->constrained()->references('id')->on('jenis_prasaranas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('tanah_id')->constrained()->references('id')->on('tanahs')->onUpdate('cascade')->onDelete('cascade');

            $table->char('kode_bangunan', 25)->nullable();
            $table->string('nama');
            $table->decimal('panjang');
            $table->decimal('lebar');
            $table->decimal('luas_tapak_bangunan');
            $table->string('kepemilikan'); // Miik, Sewa, Pinjam, Bukan Milik
            $table->string('peminjam_meminjamkan')->nullable();
            $table->decimal('nilai_aset')->nullable();
            $table->integer('jml_lantai');
            $table->year('tahun_bangun');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_sk_pemakai');
            $table->decimal('volume_pondasi')->nullable();
            $table->decimal('volume_sloop')->nullable();
            $table->decimal('panjang_kuda')->nullable();
            $table->decimal('panjang_kaso')->nullable();
            $table->decimal('panjang_reng')->nullable();
            $table->decimal('luas_tutup_atap')->nullable();
            $table->timestamps();
        });

        Schema::create('ruangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->assignOrganization();
            $table->foreignId('referensi_ruang_id')->constrained()->references('id')->on('referensi_ruangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('bangunan_id')->constrained()->references('id')->on('bangunans')->onUpdate('cascade')->onDelete('cascade');

            $table->char('kode_ruang', 25)->nullable();
            $table->string('nama');
            $table->string('registrasi_ruang');
            $table->integer('lantai_ke');
            $table->decimal('panjang');
            $table->decimal('lebar');
            $table->decimal('luas');
            $table->integer('kapasitas');
            $table->decimal('luas_plester')->nullable();
            $table->decimal('luas_plafond')->nullable();
            $table->decimal('luas_dinding')->nullable();
            $table->decimal('luas_daun_jendela')->nullable();
            $table->decimal('luas_daun_pintu')->nullable();
            $table->decimal('panjang_kusen')->nullable();
            $table->decimal('luas_tutup_lantai')->nullable();
            $table->decimal('luas_instalasi_listrik')->nullable();
            $table->integer('jumlah_instalasi_listrik')->nullable();
            $table->decimal('panjang_instalasi_air')->nullable();
            $table->integer('jumlah_instalasi_air')->nullable();
            $table->integer('panjang_drainase')->nullable();
            $table->decimal('luas_finish_struktur')->nullable();
            $table->decimal('luas_finish_plafond')->nullable();
            $table->decimal('luas_finish_dinding')->nullable();
            $table->decimal('luas_finish_kjp')->nullable();
            $table->timestamps();
        });

        Schema::create('sarpras_kondisis', function (Blueprint $table) {
            $table->id();
            $table->uuidMorphs('kondisi');
            $table->char('kategori', 12);
            $table->string('slug');
            $table->decimal('prosentase')->default(0);
            $table->text('keterangan')->nullable();
            $table->date('tanggal_kondisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_prasaranas');
        Schema::dropIfExists('referensi_ruangs');
        Schema::dropIfExists('tanahs');
        Schema::dropIfExists('bangunans');
        Schema::dropIfExists('ruangs');
        Schema::dropIfExists('sarpras_kondisis');
    }
};

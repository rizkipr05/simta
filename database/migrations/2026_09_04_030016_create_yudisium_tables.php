<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_yudisium', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode');
            $table->string('tahun', 10);
            $table->string('angkatan')->nullable();
            $table->date('tanggal_buka_pendaftaran')->nullable();
            $table->date('tanggal_tutup_pendaftaran')->nullable();
            $table->date('tanggal_yudisium')->nullable();
            $table->string('tempat')->nullable();
            $table->boolean('is_aktif')->default(false);
            $table->string('status')->default('persiapan'); // persiapan, buka, tutup, selesai
            $table->timestamps();
        });

        Schema::create('persyaratan_yudisium', function (Blueprint $table) {
            $table->id();
            $table->string('nama_persyaratan');
            $table->text('deskripsi')->nullable();
            $table->boolean('wajib')->default(true);
            $table->string('tipe_berkas')->nullable(); // pdf, image, any
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persyaratan_yudisium');
        Schema::dropIfExists('periode_yudisium');
    }
};

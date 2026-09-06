<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_yudisium', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('periode_yudisium')->onDelete('cascade');
            $table->date('tanggal_daftar')->nullable();
            $table->string('status')->default('daftar'); // daftar, verifikasi_berkas, eligible, ditolak
            $table->text('catatan')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('berkas_yudisium', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran_yudisium')->onDelete('cascade');
            $table->foreignId('persyaratan_id')->constrained('persyaratan_yudisium')->onDelete('cascade');
            $table->string('file_path');
            $table->bigInteger('file_size')->nullable();
            $table->string('status')->default('uploaded'); // uploaded, verified, rejected
            $table->foreignId('upload_by')->constrained('users');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_yudisium');
        Schema::dropIfExists('pendaftaran_yudisium');
    }
};

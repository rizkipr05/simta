<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('prodi_id')->constrained('program_studi')->onDelete('cascade');
            $table->string('nim', 30)->unique();
            $table->string('nama');
            $table->string('angkatan', 10)->nullable();
            $table->integer('semester')->default(1);
            $table->string('no_hp', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->string('status_skripsi')->default('belum_daftar');
            // Possible: belum_daftar, pengajuan, pembimbing_ditetapkan, sk_pembimbing_disahkan,
            //           bimbingan, siap_ujian, ujian_dijadwalkan, ujian_selesai,
            //           nilai_final, ba_final, menunggu_pengesahan, pengesahan_diupload,
            //           pengesahan_terverifikasi, administrasi_selesai,
            //           eligible_yudisium, mendaftar_yudisium, selesai
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};

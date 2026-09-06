<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skripsi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('bidang_kajian')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->string('status')->default('pengajuan');
            $table->text('catatan_penolakan')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skripsi');
    }
};

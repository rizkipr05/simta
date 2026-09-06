<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bimbingan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skripsi_id')->constrained('skripsi')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->string('bab_bimbingan')->default('Draft Proposal');
            $table->string('topik');
            $table->text('catatan_mahasiswa')->nullable();
            $table->text('catatan_dosen')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->string('status')->default('pending'); // pending, approved, revision, rejected, completed
            $table->timestamp('tanggal_bimbingan')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan');
    }
};

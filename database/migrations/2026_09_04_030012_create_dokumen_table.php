<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skripsi_id')->constrained('skripsi')->onDelete('cascade');
            $table->string('jenis'); // sk_pembimbing, sk_penguji, lembar_pengesahan_draft, lembar_pengesahan_signed, undangan_ujian
            $table->string('nama');
            $table->string('file_path');
            $table->bigInteger('file_size')->nullable();
            $table->string('status')->default('uploaded'); // uploaded, verified, rejected
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};

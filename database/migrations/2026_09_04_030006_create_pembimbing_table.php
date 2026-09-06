<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembimbing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skripsi_id')->constrained('skripsi')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
            $table->tinyInteger('urutan')->default(1); // 1 = Pembimbing I, 2 = Pembimbing II
            $table->date('tanggal_disetujui')->nullable();
            $table->string('status')->default('aktif'); // aktif, nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembimbing');
    }
};

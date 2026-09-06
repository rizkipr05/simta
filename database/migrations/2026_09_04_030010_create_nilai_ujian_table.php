<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained('ujian')->onDelete('cascade');
            $table->foreignId('penguji_id')->constrained('penguji')->onDelete('cascade');
            $table->decimal('nilai_penguasaan_materi', 5, 2)->nullable();
            $table->decimal('nilai_kemampuan_presentasi', 5, 2)->nullable();
            $table->decimal('nilai_penulisan', 5, 2)->nullable();
            $table->decimal('nilai_total', 5, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_ujian');
    }
};

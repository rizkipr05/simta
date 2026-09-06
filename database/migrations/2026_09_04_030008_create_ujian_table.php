<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skripsi_id')->constrained('skripsi')->onDelete('cascade');
            $table->dateTime('jadwal')->nullable();
            $table->string('tempat')->nullable();
            $table->string('ruangan')->nullable();
            $table->string('status')->default('dijadwalkan'); // dijadwalkan, berlangsung, selesai, ditunda
            $table->text('catatan')->nullable();
            $table->foreignId('dijadwalkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ujian');
    }
};

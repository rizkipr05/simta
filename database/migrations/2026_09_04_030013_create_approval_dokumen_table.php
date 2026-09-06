<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumen_id')->constrained('dokumen')->onDelete('cascade');
            $table->foreignId('approved_by')->constrained('users');
            $table->string('status'); // verified, rejected
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_dokumen');
    }
};

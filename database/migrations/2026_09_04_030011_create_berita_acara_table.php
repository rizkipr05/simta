<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained('ujian')->onDelete('cascade');
            $table->string('nomor_ba')->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('predikat')->nullable(); // A, AB, B, BC, C, D
            $table->string('keputusan')->default('lulus'); // lulus, mengulang, tidak_lulus
            $table->text('rekomendasi')->nullable();
            $table->string('file_path')->nullable(); // PDF generated
            $table->string('file_scan')->nullable(); // Scan TTD
            $table->string('status')->default('draft'); // draft, final, verified
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};

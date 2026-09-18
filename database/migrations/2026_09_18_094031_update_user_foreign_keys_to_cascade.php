<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dokumen', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('approval_dokumen', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('berkas_yudisium', function (Blueprint $table) {
            $table->dropForeign(['upload_by']);
            $table->foreign('upload_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_yudisium', function (Blueprint $table) {
            $table->dropForeign(['upload_by']);
            $table->foreign('upload_by')->references('id')->on('users');
        });

        Schema::table('approval_dokumen', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->foreign('approved_by')->references('id')->on('users');
        });

        Schema::table('dokumen', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->foreign('uploaded_by')->references('id')->on('users');
        });
    }
};

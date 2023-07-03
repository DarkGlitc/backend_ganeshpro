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
        Schema::create('gigs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_store');
            $table->string('title');
            $table->string('keywords');
            $table->enum('waktu_penyelesaian', ['1 minggu', '1 bulan','lebih dari 1 bulan'])->default('1 minggu');
            $table->enum('batas_revisi', ['1 minggu', '1 bulan','lebih dari 1 bulan'])->default('1 minggu');
            $table->integer('price');
            $table->string('image');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gigs');
    }
};
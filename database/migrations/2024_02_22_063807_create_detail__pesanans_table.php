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
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('id_details');
            $table->foreignId('katalogs_id');
            $table->foreignId('pesanans_id');
            $table->integer('jumlah');
            $table->foreign('katalogs_id')->references('id_katalogs')->on('katalogs');
            $table->foreign('pesanans_id')->references('id_pesanans')->on('pesanans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail__pesanans');
    }
};

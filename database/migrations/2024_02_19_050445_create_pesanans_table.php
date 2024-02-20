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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanans');
            $table->foreignId('katalogs_id');
            $table->foreignId('users_id');
            $table->integer('quantity');
            $table->bigInteger('total');
            $table->enum('metode_pengiriman', ['pickup', 'delivery']);
            $table->enum('metode_pembayaran', ['cash', 'transfer']);
            $table->enum('status', ['menunggu pembayaran', 'diproses', 'selesai']);
            $table->timestamps();
            $table->foreign('katalogs_id')->references('id_katalogs')->on('katalogs');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};

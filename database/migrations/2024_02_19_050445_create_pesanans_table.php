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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('id_pesanan')->unique();
            $table->foreignId('users_id');
            $table->string('alamat_pengiriman');
            $table->string('no_hp');
            $table->enum('metode_pengiriman', ['Pickup', 'Delivery']);
            $table->enum('metode_pembayaran', ['Cash', 'Transfer']);
            $table->enum('status', ['Menunggu Pembayaran', 'Diproses', 'Selesai', 'Dibatalkan']);
            $table->bigInteger('total');
            $table->string('snaptoken')->nullable();
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};

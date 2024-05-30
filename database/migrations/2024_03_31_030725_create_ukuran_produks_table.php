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
        Schema::create('ukuran_produk', function (Blueprint $table) {
            $table->id('id_ukuran_produk');
            $table->string('produk_id');
            $table->foreignId('ukuran_id');
            $table->foreign('produk_id')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('ukuran_id')->references('id_ukuran')->on('ukuran')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukuran_produk');
    }
};

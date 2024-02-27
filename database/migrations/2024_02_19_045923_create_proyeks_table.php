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
        Schema::create('proyeks', function (Blueprint $table) {
            $table->id('id_proyeks');
            $table->string('nama_pemesan');
            $table->string('instansi');
            $table->string('no_hp');
            $table->string('alamat');
            $table->string('item');
            $table->string('foto_logo');
            $table->string('foto_desain');
            $table->string('deskripsi_proyek');
            $table->integer('jumlah');
            $table->bigInteger('harga_satuan');
            $table->bigInteger('nominal_dp')->nullable();
            $table->date('deadline');
            $table->enum('status_pengerjaan', ['diproses', 'selesai']);
            $table->enum('status_pembayaran', ['belum', 'dp', 'lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};

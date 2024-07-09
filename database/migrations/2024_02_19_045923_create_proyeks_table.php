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
        Schema::create('proyek', function (Blueprint $table) {
            $table->string('id_proyek')->unique();
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
            $table->bigInteger('total');
            $table->date('deadline');
            $table->enum('status_pengerjaan', ['Diproses', 'Selesai', 'Dibatalkan']);
            $table->enum('status_pembayaran', ['Belum', 'DP', 'Lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek');
    }
};

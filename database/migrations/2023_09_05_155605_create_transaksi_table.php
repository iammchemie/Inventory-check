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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_reagensia');
            $table->string('satuan');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->integer('jumlah_masuk');
            $table->integer('jumlah_keluar')->default(0);
            $table->integer('stok');
            $table->date('tanggal_kadaluarsa');
            $table->longText('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

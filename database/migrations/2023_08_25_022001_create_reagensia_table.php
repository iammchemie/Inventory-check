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
        Schema::create('reagensia', function (Blueprint $table) {
            $table->id();
            $table->string('nama_reagensia');
            $table->string('satuan');
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->integer('jumlah_masuk')->nullable();
            $table->integer('jumlah_keluar')->nullable()->default(0);
            $table->integer('stok');
            $table->date('tanggal_kadaluarsa');
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reagensia');
    }
};
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
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id'); // Menyimpan peminjaman_id sebagai foreign key
            $table->foreign('peminjaman_id')->references('id')->on('riwayat_pinjam')->onUpdate('cascade')->onDelete('cascade'); // Pastikan nama tabel 'peminjaman'
            $table->integer('nominal')->nullable(); // Nominal denda yang dikenakan
            $table->timestamp('tanggal_bayar')->nullable(); // Gunakan timestamp untuk menyimpan tanggal dan waktu
            $table->enum('status', ['Lunas', 'Belum Bayar'])->default('Belum Bayar'); // Status denda
            $table->string('keterangan')->nullable(); // Keterangan mengenai denda
            $table->timestamps(); // Timestamp untuk pencatatan pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};

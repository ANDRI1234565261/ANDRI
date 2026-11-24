<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();         // Kode nota unik: LDR-YYYYMMDD-XXXX
            $table->string('nama_pelanggan');                    // Nama Pelanggan
            $table->string('no_hp')->nullable();                 // No HP Pelanggan
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Relasi ke Layanan
            $table->decimal('berat', 8, 2)->default(1);          // Berat cucian (Kg)
            $table->integer('total_harga');                       // Total = harga x berat
            $table->enum('status', ['Proses', 'Selesai'])->default('Proses'); // Status pengerjaan
            $table->enum('status_bayar', ['Belum Lunas', 'Lunas'])->default('Belum Lunas'); // Status pembayaran
            $table->text('catatan')->nullable();                  // Catatan tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

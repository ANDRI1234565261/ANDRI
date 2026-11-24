<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Nama Jenis Layanan: Reguler, Ekspress, Superkilat
            $table->integer('price');             // Harga per Kg
            $table->string('estimation');         // Estimasi Pengerjaan (3-4 hari, 1-2 hari, 5 jam)
            $table->text('description')->nullable(); // Keterangan layanan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // ID Akun Pelanggan
            $table->string('customer_name')->nullable(); // Nama Pelanggan Laundry
            $table->string('order_code')->unique();      // Kode Resi/Nota (contoh: LDR-20261124-XXXX)
            $table->integer('total_price');              // Total Biaya Cucian
            $table->string('status')->default('Pending'); // Status: Pending / Proses Cuci / Selesai / Batal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

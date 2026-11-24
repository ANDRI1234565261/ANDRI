<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');     // Hubungkan ke Header Pesanan
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Hubungkan ke Master Layanan
            $table->integer('quantity');                                                   // Berat (Kg) atau Jumlah Pcs
            $table->integer('price');                                                      // Harga satuan saat order
            $table->integer('subtotal');                                                   // Jumlah x Harga Satuan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->text('customer_address')->nullable()->after('customer_phone');
            $table->string('pickup_type')->default('Antar Sendiri')->after('customer_address'); // Antar Sendiri / Jemput Antar
            $table->string('payment_status')->default('Belum Lunas')->after('status'); // Belum Lunas / Lunas
            $table->text('notes')->nullable()->after('payment_status');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('unit')->default('Kg')->after('price'); // Kg / Pcs / Meter / Pasang
            $table->string('icon')->default('🧺')->after('unit'); // Emoji/Icon identifier
            $table->boolean('is_active')->default(true)->after('estimation');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_phone', 'customer_address', 'pickup_type', 'payment_status', 'notes']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['unit', 'icon', 'is_active']);
        });
    }
};

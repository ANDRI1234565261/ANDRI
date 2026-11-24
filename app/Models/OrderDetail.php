<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Baris rincian ini merujuk ke data master layanan laundry mana
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // Relasi: Baris rincian ini terhubung ke transaksi order mana
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

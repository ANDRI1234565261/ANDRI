<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: 1 Pesanan dimiliki oleh 1 Pengguna (User / Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: 1 Pesanan memiliki banyak rincian layanan yang dipesan (Order Details)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Helper tahapan status cucian untuk Stepper/Timeline
    public static function statusSteps(): array
    {
        return [
            'Pending'      => ['label' => 'Pesanan Diterima', 'icon' => '📥', 'desc' => 'Pesanan masuk dan antre untuk diproses.'],
            'Proses Cuci'  => ['label' => 'Sedang Dicuci & Kering', 'icon' => '🧼', 'desc' => 'Pakaian sedang dicuci bersih & dikeringkan.'],
            'Setrika'      => ['label' => 'Setrika & Finishing', 'icon' => '👔', 'desc' => 'Pakaian disetrika rapi, wangi, dan dipacking.'],
            'Siap Diambil' => ['label' => 'Siap Diambil / Diantar', 'icon' => '✨', 'desc' => 'Cucian selesai dan siap diambil oleh pemilik.'],
            'Selesai'      => ['label' => 'Selesai', 'icon' => '✅', 'desc' => 'Cucian telah diserahkan dan transaksi selesai.'],
            'Batal'        => ['label' => 'Dibatalkan', 'icon' => '❌', 'desc' => 'Pesanan dibatalkan.'],
        ];
    }

    // Mendapatkan index tahapan status saat ini (0 sampai 4)
    public function getStatusStepIndex(): int
    {
        $keys = ['Pending', 'Proses Cuci', 'Setrika', 'Siap Diambil', 'Selesai'];
        $idx = array_search($this->status, $keys);
        return $idx === false ? -1 : $idx;
    }

    // URL WhatsApp untuk mengirim notifikasi/struk langsung ke nomor pelanggan
    public function getWhatsappNotificationUrl(): ?string
    {
        if (!$this->customer_phone) {
            return null;
        }

        // Normalisasi nomor telepon ke format internasional (misal: 0812 -> 62812)
        $phone = preg_replace('/[^0-9]/', '', $this->customer_phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $itemsText = '';
        foreach ($this->orderDetails as $detail) {
            $serviceName = $detail->service->name ?? 'Layanan';
            $itemsText .= "%0A- {$serviceName}: {$detail->quantity} {$detail->service?->unit} (Rp " . number_format($detail->subtotal, 0, ',', '.') . ")";
        }

        $message = "Halo kak *{$this->customer_name}*, terima kasih telah mempercayakan pakaian Anda di *Andri Laundry*! 🧺%0A%0A"
            . "📋 *No. Resi:* `{$this->order_code}`%0A"
            . "📊 *Status Saat Ini:* *{$this->status}*%0A"
            . "💳 *Status Pembayaran:* *{$this->payment_status}*%0A"
            . "💰 *Total Biaya:* Rp " . number_format($this->total_price, 0, ',', '.') . "%0A"
            . "📦 *Rincian Cucian:*{$itemsText}%0A%0A"
            . "Lacak status pakaian Anda kapan saja di website kami dengan memasukkan nomor resi `{$this->order_code}`.%0A%0A"
            . "Salam hangat,%0A*Andri Laundry*";

        return "https://api.whatsapp.com/send?phone={$phone}&text={$message}";
    }
}

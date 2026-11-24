<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Laundry - {{ $order->order_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'Space Mono', monospace; }

        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-receipt {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-8 px-4 flex flex-col items-center justify-center">

    <!-- TOMBOL AKSI ATAS (NO PRINT) -->
    <div class="no-print max-w-md w-full mb-6 flex items-center justify-between gap-3">
        <a href="{{ route('customer.index') }}" class="text-xs font-semibold text-slate-600 hover:text-blue-600 transition flex items-center gap-1 bg-white px-3.5 py-2 rounded-xl shadow-sm border border-slate-200">
            &larr; Beranda
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow-md shadow-blue-500/20 transition flex items-center gap-1.5">
                🖨️ Cetak Struk
            </button>
            @if($order->getWhatsappNotificationUrl())
                <a href="{{ $order->getWhatsappNotificationUrl() }}" target="_blank" class="text-xs font-bold bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl shadow-sm transition flex items-center gap-1.5">
                    💬 WA
                </a>
            @endif
        </div>
    </div>

    <!-- STRUK LAUNDRY KASIR / INVOICE DIGITAL -->
    <div class="print-receipt bg-white max-w-md w-full rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-8 relative">
        <!-- HEADER TOKO -->
        <div class="text-center pb-5 border-b-2 border-dashed border-slate-200">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-600 text-white text-2xl mb-2 shadow-sm">
                🧺
            </div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">ANDRI LAUNDRY</h1>
            <p class="text-xs text-slate-500">Layanan Cuci Bersih, Kering, Setrika Wangi & Higienis</p>
            <p class="text-[11px] text-slate-400 mt-1">Jl. KH. Ahmad Dahlan No. 45 | Telp/WA: 0812-3456-7890</p>
        </div>

        <!-- INFO NOTA -->
        <div class="py-4 border-b border-dashed border-slate-200 text-xs text-slate-600 space-y-1.5">
            <div class="flex justify-between">
                <span class="text-slate-400">No. Resi:</span>
                <span class="font-mono font-bold text-slate-900 tracking-wider">{{ $order->order_code }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Tanggal Masuk:</span>
                <span class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Pelanggan:</span>
                <span class="font-bold text-slate-900">{{ $order->customer_name }}</span>
            </div>
            @if($order->customer_phone)
                <div class="flex justify-between">
                    <span class="text-slate-400">Telepon/WA:</span>
                    <span class="font-mono">{{ $order->customer_phone }}</span>
                </div>
            @endif
            <div class="flex justify-between">
                <span class="text-slate-400">Pengambilan:</span>
                <span class="font-semibold text-slate-800">{{ $order->pickup_type }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Status Pembayaran:</span>
                <span class="font-bold {{ $order->payment_status === 'Lunas' ? 'text-green-600' : 'text-amber-600' }}">
                    {{ strtoupper($order->payment_status) }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Status Cucian:</span>
                <span class="font-bold text-blue-600">{{ strtoupper($order->status) }}</span>
            </div>
        </div>

        <!-- DAFTAR ITEM CUCIAN -->
        <div class="py-4 border-b-2 border-dashed border-slate-200">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Rincian Layanan Cucian</div>
            <div class="space-y-2.5">
                @foreach($order->orderDetails as $detail)
                    <div class="text-xs">
                        <div class="flex justify-between font-semibold text-slate-800">
                            <span>{{ $detail->service->name ?? 'Layanan Laundry' }}</span>
                            <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[11px] text-slate-400">
                            <span>{{ $detail->quantity }} {{ $detail->service?->unit }} &times; Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                            <span>Estimasi: {{ $detail->service?->estimation ?? '1-2 Hari' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TOTAL & CATATAN -->
        <div class="py-4 space-y-2">
            <div class="flex justify-between items-center text-sm">
                <span class="font-bold text-slate-700">TOTAL PEMBAYARAN:</span>
                <span class="text-lg font-black text-slate-900 font-mono">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </span>
            </div>

            @if($order->notes)
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-[11px] text-slate-600">
                    <span class="font-bold text-slate-700 block mb-0.5">Catatan Khusus:</span>
                    {{ $order->notes }}
                </div>
            @endif
        </div>

        <!-- KETENTUAN LAYANAN & QR/BARCODE SIMULASI -->
        <div class="pt-4 border-t border-dashed border-slate-200 text-center">
            <!-- Simulasi Barcode -->
            <div class="font-mono text-xs tracking-[6px] text-slate-400 font-bold mb-1">
                ||| | ||||| || |||| | ||| ||
            </div>
            <div class="font-mono text-[10px] text-slate-400 tracking-wider mb-4">
                {{ $order->order_code }}
            </div>

            <div class="text-[10px] text-slate-400 text-left space-y-1 bg-slate-50 p-3 rounded-xl border border-slate-100">
                <div class="font-bold text-slate-600">Syarat & Ketentuan Pengambilan:</div>
                <p>1. Pengambilan cucian wajib membawa nota ini atau menunjukkan nomor resi resmi.</p>
                <p>2. Komplain/klaim kerusakan atau kehilangan maksimal 1&times;24 jam sejak pakaian diambil.</p>
                <p>3. Pakaian yang tidak diambil lebih dari 30 hari di luar tanggung jawab laundry.</p>
            </div>

            <p class="text-xs font-semibold text-slate-700 mt-4">
                Terima kasih atas kepercayaan Anda di Andri Laundry! 🙏
            </p>
        </div>
    </div>

    <!-- TOMBOL BAWAH (NO PRINT) -->
    <div class="no-print mt-6 text-center text-xs text-slate-500">
        <a href="{{ route('orders.track', ['code' => $order->order_code]) }}" class="text-blue-600 font-semibold hover:underline">
            🔍 Lacak Status Cucian Ini Secara Realtime
        </a>
    </div>

</body>
</html>

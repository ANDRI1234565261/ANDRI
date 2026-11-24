<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Status Pesanan - Andri Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 flex flex-col justify-between">
    <!-- NAVBAR -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('customer.index') }}" class="flex items-center gap-2.5 font-bold text-xl text-blue-600">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                    🧺
                </div>
                <span>Andri<span class="text-slate-900">Laundry</span></span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('customer.index') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition px-3 py-1.5">
                    &larr; Beranda
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold bg-slate-900 text-white px-4 py-2 rounded-xl hover:bg-slate-800 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition shadow-sm">
                        Masuk / Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="max-w-4xl mx-auto px-4 py-10 w-full flex-1">
        <!-- Form Pencarian Resi -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 font-semibold text-xs px-3 py-1 rounded-full border border-blue-200 mb-3">
                🔍 Live Tracking System
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                Lacak Status Cucian Anda
            </h1>
            <p class="text-sm text-slate-500 mt-1 max-w-md mx-auto">
                Ketikkan nomor resi nota laundry Anda di bawah untuk memantau proses pencucian secara realtime.
            </p>

            <form action="{{ route('orders.track') }}" method="GET" class="mt-6 max-w-lg mx-auto flex gap-2">
                <div class="relative flex-1">
                    <input type="text" name="code" value="{{ $code }}" placeholder="Contoh: LDR-20261124-XXXX" required
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-300 rounded-2xl text-slate-800 font-mono font-medium text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none uppercase shadow-sm">
                    <span class="absolute left-4 top-3.5 text-slate-400">🏷️</span>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-2xl shadow-md shadow-blue-500/20 transition flex items-center gap-2 text-sm shrink-0">
                    Lacak
                </button>
            </form>
        </div>

        @if(!empty($code))
            @if($order)
                <!-- HASIL PELACAKAN RESI -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden animate-fade-in">
                    <!-- Header Kartu -->
                    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 p-6 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="text-xs uppercase tracking-wider text-blue-200 font-semibold">Nomor Resi Laundry</div>
                            <div class="text-2xl font-black font-mono mt-0.5 tracking-wider">{{ $order->order_code }}</div>
                            <div class="text-xs text-blue-100 mt-1">Dipesan pada: {{ $order->created_at->format('d M Y, H:i') }} WIB</div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('orders.receipt', $order->order_code) }}" target="_blank"
                               class="bg-white/10 hover:bg-white/20 text-white backdrop-blur border border-white/20 text-xs font-semibold px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                                🖨️ Cetak Nota
                            </a>
                            @if($order->getWhatsappNotificationUrl())
                                <a href="{{ $order->getWhatsappNotificationUrl() }}" target="_blank"
                                   class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                                    💬 WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- STEPPER TIMELINE PROSES CUCIAN -->
                    <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50/50">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-6">Status Pengerjaan</div>

                        @php
                            $steps = [
                                'Pending'      => ['title' => 'Diterima', 'desc' => 'Antrean awal'],
                                'Proses Cuci'  => ['title' => 'Cuci & Kering', 'desc' => 'Mesin higienis'],
                                'Setrika'      => ['title' => 'Setrika Uap', 'desc' => 'Rapi & wangi'],
                                'Siap Diambil' => ['title' => 'Siap Diambil', 'desc' => 'Sudah dipacking'],
                                'Selesai'      => ['title' => 'Selesai', 'desc' => 'Sudah diambil'],
                            ];

                            $currentStatus = $order->status;
                            $stepKeys = array_keys($steps);
                            $currentIndex = array_search($currentStatus, $stepKeys);
                            if ($currentIndex === false && $currentStatus === 'Batal') {
                                $currentIndex = -99;
                            }
                        @endphp

                        @if($currentStatus === 'Batal')
                            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl flex items-center gap-3">
                                <span class="text-2xl">❌</span>
                                <div>
                                    <div class="font-bold text-sm">Pesanan Ini Dibatalkan</div>
                                    <div class="text-xs text-red-600">Pesanan telah dibatalkan oleh pihak pengelola laundry atau pelanggan.</div>
                                </div>
                            </div>
                        @else
                            <div class="relative">
                                <!-- Garis timeline desktop -->
                                <div class="hidden md:block absolute top-1/2 left-6 right-6 h-1 bg-slate-200 -translate-y-6 z-0"></div>
                                <div class="hidden md:block absolute top-1/2 left-6 h-1 bg-blue-600 -translate-y-6 z-0 transition-all duration-500"
                                     style="width: {{ $currentIndex >= 0 ? ($currentIndex / (count($steps) - 1)) * 100 : 0 }}%;"></div>

                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 relative z-10">
                                    @foreach($steps as $key => $info)
                                        @php
                                            $stepIdx = array_search($key, $stepKeys);
                                            $isPassed = $stepIdx <= $currentIndex;
                                            $isCurrent = $stepIdx === $currentIndex;
                                        @endphp
                                        <div class="flex md:flex-col items-center gap-3 md:text-center">
                                            <!-- Bullet Lingkaran -->
                                            <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-sm shrink-0 transition-all shadow-sm
                                                {{ $isCurrent ? 'bg-blue-600 text-white ring-4 ring-blue-100 scale-110' : ($isPassed ? 'bg-blue-600 text-white' : 'bg-white border-2 border-slate-200 text-slate-400') }}">
                                                @if($isPassed && !$isCurrent)
                                                    ✓
                                                @else
                                                    {{ $loop->iteration }}
                                                @endif
                                            </div>

                                            <div>
                                                <div class="text-xs font-bold {{ $isCurrent ? 'text-blue-600' : ($isPassed ? 'text-slate-800' : 'text-slate-400') }}">
                                                    {{ $info['title'] }}
                                                </div>
                                                <div class="text-[11px] text-slate-400">
                                                    {{ $info['desc'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- INFORMASI PELANGGAN & DETAIL -->
                    <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom Kiri: Info Pemilik & Pengiriman -->
                        <div class="space-y-4 text-sm">
                            <div class="font-bold text-slate-900 border-b pb-2 flex items-center gap-2">
                                <span>👤</span> Informasi Pemilik Pakaian
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <span class="text-slate-400">Nama:</span>
                                <span class="col-span-2 font-semibold text-slate-800">{{ $order->customer_name }}</span>

                                <span class="text-slate-400">No. HP/WA:</span>
                                <span class="col-span-2 font-mono text-slate-700">{{ $order->customer_phone ?: '-' }}</span>

                                <span class="text-slate-400">Pengambilan:</span>
                                <span class="col-span-2 font-semibold text-slate-700">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs {{ $order->pickup_type === 'Jemput Antar' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $order->pickup_type }}
                                    </span>
                                </span>

                                @if($order->customer_address)
                                    <span class="text-slate-400">Alamat:</span>
                                    <span class="col-span-2 text-slate-600">{{ $order->customer_address }}</span>
                                @endif

                                @if($order->notes)
                                    <span class="text-slate-400">Catatan:</span>
                                    <span class="col-span-2 text-amber-700 bg-amber-50 p-2 rounded-lg text-xs italic">{{ $order->notes }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Kolom Kanan: Status Finansial & Tagihan -->
                        <div class="space-y-4 text-sm bg-slate-50 p-5 rounded-2xl border border-slate-100">
                            <div class="font-bold text-slate-900 border-b border-slate-200 pb-2 flex items-center justify-between">
                                <span class="flex items-center gap-2">💳 Rincian Pembayaran</span>
                                @if($order->payment_status === 'Lunas')
                                    <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-bold">LUNAS</span>
                                @else
                                    <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-bold">BELUM LUNAS</span>
                                @endif
                            </div>

                            <div class="space-y-2">
                                @foreach($order->orderDetails as $detail)
                                    <div class="flex justify-between items-center text-xs">
                                        <div class="text-slate-700">
                                            <span class="font-semibold">{{ $detail->service->name ?? 'Layanan' }}</span>
                                            <span class="text-slate-400 block">{{ $detail->quantity }} {{ $detail->service?->unit }} @ Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="font-bold text-slate-800">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-slate-200 pt-3 flex justify-between items-center">
                                <span class="font-bold text-slate-700">Total Biaya:</span>
                                <span class="text-xl font-extrabold text-blue-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER KARTU -->
                    <div class="p-6 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                        <div>
                            Jika ada pertanyaan mengenai cucian Anda, silakan hubungi WhatsApp kami di <strong>0812-3456-7890</strong>.
                        </div>
                        <a href="{{ route('customer.index') }}" class="text-blue-600 font-bold hover:underline">
                            + Buat Pesanan Baru
                        </a>
                    </div>
                </div>
            @else
                <!-- KETIKA RESI TIDAK DITEMUKAN -->
                <div class="bg-white rounded-3xl border border-red-200 p-8 text-center max-w-md mx-auto shadow-sm">
                    <div class="w-14 h-14 bg-red-100 text-red-600 text-2xl rounded-2xl flex items-center justify-center mx-auto mb-4">
                        ⚠️
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Nomor Resi Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 mt-2">
                        Resi dengan kode <strong class="text-slate-800 font-mono">{{ $code }}</strong> tidak terdaftar di sistem kami. Mohon periksa kembali kode resi pada nota Anda.
                    </p>
                    <a href="{{ route('orders.track') }}" class="inline-block mt-4 text-xs font-bold text-blue-600 hover:underline">
                        Coba Cari Lagi
                    </a>
                </div>
            @endif
        @endif
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Andri Laundry - Sistem Manajemen Laundry Bersih & Higienis.
    </footer>
</body>
</html>

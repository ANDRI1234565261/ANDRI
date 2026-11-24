<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andri Laundry - Solusi Cuci Pakaian Bersih, Rapi & Higienis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'Space Mono', monospace; }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-500 selection:text-white">

    <!-- 1. TOP ANNOUNCEMENT BAR -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-800 text-white text-xs py-2 px-4 text-center font-medium">
        <span class="inline-flex items-center gap-1.5">
            ✨ <strong>Promo Kilat:</strong> Diskon antar jemput untuk area sekitar & parfum eksklusif tahan hingga 7 hari! 🧺
        </span>
    </div>

    <!-- 2. NAVBAR -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('customer.index') }}" class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center text-2xl shadow-lg shadow-blue-500/25">
                    🧺
                </div>
                <div>
                    <span class="text-xl font-extrabold text-slate-900 tracking-tight">Andri<span class="text-blue-600">Laundry</span></span>
                    <span class="block text-[10px] text-slate-400 font-medium uppercase tracking-widest -mt-1">Premium Care</span>
                </div>
            </a>

            <!-- Nav Links Desktop -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#layanan" class="hover:text-blue-600 transition">Pilihan Layanan</a>
                <a href="#keunggulan" class="hover:text-blue-600 transition">Keunggulan</a>
                <a href="{{ route('orders.track') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                    🔍 <span>Lacak Resi</span>
                </a>
                <a href="#faq" class="hover:text-blue-600 transition">FAQ</a>
            </nav>

            <!-- User Auth Action -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow transition">
                        <span>Dashboard Saya</span> &rarr;
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-blue-600 px-3 py-2 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-blue-500/20 transition">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- 3. HERO SECTION -->
    <section class="relative overflow-hidden pt-12 pb-20 bg-gradient-to-b from-blue-50/60 via-slate-50 to-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100/80 border border-blue-200 text-blue-800 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                        Buka Setiap Hari: 07.00 - 21.00 WIB
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.15]">
                        Pakaian Bersih, Rapi & Wangi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Tanpa Perlu Repot.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl font-normal leading-relaxed">
                        Layanan laundry kiloan & satuan profesional. Dicuci higienis <strong>1 mesin 1 pelanggan</strong> (anti dicampur), disetrika uap presisi, dan parfum mewah tahan lama.
                    </p>

                    <!-- QUICK TRACKING SEARCH IN HERO -->
                    <div class="pt-2 max-w-lg mx-auto lg:mx-0">
                        <form action="{{ route('orders.track') }}" method="GET" class="bg-white p-2 rounded-2xl shadow-lg border border-slate-200 flex items-center gap-2">
                            <span class="pl-3 text-slate-400 text-base">🔍</span>
                            <input type="text" name="code" placeholder="Cek resi? Masukkan No. Resi Anda..."
                                   class="w-full text-xs sm:text-sm font-mono outline-none text-slate-800 bg-transparent uppercase font-medium">
                            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shrink-0">
                                Lacak
                            </button>
                        </form>
                    </div>

                    <!-- KEUNGGULAN UTAMA (4 BADGES) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-left">
                        <div class="bg-white/70 backdrop-blur p-3 rounded-2xl border border-slate-200/80 shadow-sm">
                            <div class="text-xl mb-1">🧼</div>
                            <div class="font-bold text-xs text-slate-800">1 Mesin 1 Pelanggan</div>
                            <div class="text-[10px] text-slate-500">Tidak pernah dicampur</div>
                        </div>
                        <div class="bg-white/70 backdrop-blur p-3 rounded-2xl border border-slate-200/80 shadow-sm">
                            <div class="text-xl mb-1">⚡</div>
                            <div class="font-bold text-xs text-slate-800">Express 4 Jam</div>
                            <div class="text-[10px] text-slate-500">Cepat & tepat waktu</div>
                        </div>
                        <div class="bg-white/70 backdrop-blur p-3 rounded-2xl border border-slate-200/80 shadow-sm">
                            <div class="text-xl mb-1">🌸</div>
                            <div class="font-bold text-xs text-slate-800">Parfum Premium</div>
                            <div class="text-[10px] text-slate-500">Wangi tahan 7 hari</div>
                        </div>
                        <div class="bg-white/70 backdrop-blur p-3 rounded-2xl border border-slate-200/80 shadow-sm">
                            <div class="text-xl mb-1">🛵</div>
                            <div class="font-bold text-xs text-slate-800">Antar Jemput</div>
                            <div class="text-[10px] text-slate-500">Ambil & antar ke rumah</div>
                        </div>
                    </div>
                </div>

                <!-- HERO CARD / STATS -->
                <div class="lg:col-span-5 relative">
                    <div class="relative bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-2xl">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Antrean Hari Ini</span>
                                <div class="text-xl font-black text-slate-900 mt-0.5">Operasional Lancar 🟢</div>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold">
                                ⏱️
                            </div>
                        </div>

                        <!-- Card Step Preview -->
                        <div class="py-6 space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 font-bold text-xs flex items-center justify-center shrink-0">✓</div>
                                <div class="text-xs">
                                    <span class="font-bold text-slate-800 block">Penyortiran & Penimbangan Higienis</span>
                                    <span class="text-slate-400">Pakaian diperiksa saku, warna, dan jenis bahan</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center shrink-0">2</div>
                                <div class="text-xs">
                                    <span class="font-bold text-slate-800 block">Pencucian Ekstra Bersih & Kering 100%</span>
                                    <span class="text-slate-400">Mesin cuci modern dengan air tersaring & desinfektan</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 font-bold text-xs flex items-center justify-center shrink-0">3</div>
                                <div class="text-xs">
                                    <span class="font-bold text-slate-800 block">Setrika Uap & Packing Rapi</span>
                                    <span class="text-slate-400">Licin tanpa merusak sablon atau serat pakaian</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 rounded-2xl flex items-center justify-between">
                            <div>
                                <div class="text-[11px] text-blue-100 font-medium">Mau cuci hari ini?</div>
                                <div class="text-sm font-bold">Pilih layanan di bawah ini &darr;</div>
                            </div>
                            <a href="#formPemesanan" class="bg-white text-blue-600 hover:bg-blue-50 text-xs font-extrabold px-4 py-2 rounded-xl transition shadow">
                                Buat Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NOTIFIKASI FLASH & VALIDASI -->
    <div class="max-w-5xl mx-auto px-4 mt-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-5 py-4 rounded-2xl shadow-sm mb-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎉</span>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 font-bold">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-5 py-4 rounded-2xl shadow-sm mb-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">⚠️</span>
                    <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 font-bold">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-800 px-5 py-4 rounded-2xl mb-6">
                <div class="font-bold text-sm mb-1 flex items-center gap-2">
                    <span>⚠️</span> Ada beberapa kesalahan pada isian Anda:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- 4. FORM PEMESANAN & KATALOG LAYANAN -->
    <section id="formPemesanan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="bg-blue-100 text-blue-700 font-bold text-xs px-3.5 py-1 rounded-full uppercase tracking-wider">
                Langkah Mudah
            </span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">Form Pemesanan Laundry Online</h2>
            <p class="text-sm text-slate-500 mt-1">
                Lengkapi identitas pemesan, pilih paket cucian yang diinginkan, dan konfirmasi pesanan Anda dalam hitungan detik.
            </p>
        </div>

        <form id="orderForm" action="{{ route('customer.checkout') }}" method="POST">
            @csrf

            <!-- STEP 1: INFORMASI PEMESAN -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 mb-8">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 text-white font-extrabold text-sm flex items-center justify-center">
                        1
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Informasi Pelanggan & Pengantaran</h3>
                        <p class="text-xs text-slate-400">Pastikan nomor WhatsApp aktif untuk pembaruan status resi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Pemesan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap Pelanggan *</label>
                        <input type="text" id="customer_name" name="customer_name"
                            value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}"
                            required placeholder="Contoh: Budi Santoso"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>

                    <!-- No WhatsApp -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp / HP *</label>
                        <input type="text" id="customer_phone" name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>

                    <!-- Metode Pengambilan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilihan Pengambilan *</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer hover:border-blue-500 transition text-xs font-bold text-slate-700 bg-slate-50">
                                <input type="radio" name="pickup_type" value="Antar Sendiri" checked class="text-blue-600 focus:ring-blue-500">
                                <span>🏬 Antar Sendiri ke Toko</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer hover:border-blue-500 transition text-xs font-bold text-slate-700 bg-slate-50">
                                <input type="radio" name="pickup_type" value="Jemput Antar" {{ old('pickup_type') === 'Jemput Antar' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                <span>🛵 Jemput & Antar ke Rumah</span>
                            </label>
                        </div>
                    </div>

                    <!-- Alamat Lengkap (Jika Jemput Antar) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat / Titik Jemput (Opsional)</label>
                        <input type="text" id="customer_address" name="customer_address"
                            value="{{ old('customer_address') }}"
                            placeholder="Contoh: Jl. Anggrek No. 12, RT 01/RW 03, Kebayoran Baru"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>

                    <!-- Catatan Khusus -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Pakaian / Instruksi Khusus (Opsional)</label>
                        <textarea id="notes" name="notes" rows="2"
                            placeholder="Contoh: Baju putih tolong dipisah, kemeja kerja digantung pakai hanger, gunakan pewangi floral..."
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm text-slate-800 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- STEP 2: PILIH LAYANAN LAUNDRY -->
            <div id="layanan" class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white font-extrabold text-sm flex items-center justify-center">
                            2
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base">Pilih Paket Layanan Laundry</h3>
                            <p class="text-xs text-slate-400">Isi perkiraan berat (Kg) atau jumlah pcs pakaian Anda</p>
                        </div>
                    </div>
                </div>

                <!-- DAFTAR KARTU LAYANAN -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($services as $service)
                        <div class="service-card bg-white rounded-3xl border border-slate-200/90 hover:border-blue-400 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                            <div class="p-6">
                                <!-- Icon & Harga -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-2xl flex items-center justify-center group-hover:scale-110 transition duration-300">
                                        {{ $service->icon ?: '🧺' }}
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-extrabold text-blue-600">
                                            Rp {{ number_format($service->price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 font-semibold uppercase">
                                            per {{ $service->unit ?: 'Kg' }}
                                        </div>
                                    </div>
                                </div>

                                <h4 class="font-bold text-slate-900 text-lg mb-1">{{ $service->name }}</h4>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-2">
                                    {{ $service->description }}
                                </p>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        ⏱️ Estimasi: <strong class="text-slate-700">{{ $service->estimation ?: '1-2 Hari' }}</strong>
                                    </span>
                                    <span>
                                        📦 Kuota:
                                        @if($service->stock > 0)
                                            <span class="font-bold text-green-600">{{ $service->stock }} {{ $service->unit ?: 'Kg' }}</span>
                                        @else
                                            <span class="font-bold text-red-500">Penuh</span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Input Kuantiti / Stepper -->
                            <div class="p-4 bg-slate-50 border-t border-slate-100">
                                @if($service->stock > 0)
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-xs font-bold text-slate-500 uppercase">Jumlah ({{ $service->unit ?: 'Kg' }}):</span>
                                        <div class="flex items-center bg-white border border-slate-300 rounded-xl overflow-hidden shadow-sm">
                                            <button type="button" onclick="adjustQty({{ $service->id }}, -1)"
                                                    class="w-9 h-9 flex items-center justify-center font-bold text-slate-600 hover:bg-slate-100 transition active:scale-95">
                                                -
                                            </button>
                                            <input type="number"
                                                   id="qty_{{ $service->id }}"
                                                   name="items[{{ $service->id }}]"
                                                   min="0"
                                                   max="{{ $service->stock }}"
                                                   value="{{ old('items.'.$service->id, 0) }}"
                                                   data-name="{{ $service->name }}"
                                                   data-price="{{ $service->price }}"
                                                   data-unit="{{ $service->unit ?: 'Kg' }}"
                                                   oninput="recalcCart()"
                                                   class="item-qty w-14 text-center font-bold text-sm text-slate-800 outline-none border-x border-slate-200 py-1">
                                            <button type="button" onclick="adjustQty({{ $service->id }}, 1)"
                                                    class="w-9 h-9 flex items-center justify-center font-bold text-slate-600 hover:bg-slate-100 transition active:scale-95">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center text-xs font-bold text-red-500 py-2 bg-red-50 rounded-xl border border-red-100">
                                        Kuota Hari Ini Penuh
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 bg-white p-12 rounded-3xl border border-slate-200 text-center">
                            <span class="text-4xl mb-2 block">🧺</span>
                            <h4 class="font-bold text-slate-800">Belum ada layanan aktif saat ini</h4>
                            <p class="text-xs text-slate-400 mt-1">Silakan cek kembali beberapa saat lagi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- FLOATING / STICKY SUMMARY BOTTOM BAR -->
            <div class="sticky bottom-6 z-30 max-w-4xl mx-auto">
                <div class="bg-slate-900/95 backdrop-blur-md text-white p-4 sm:p-5 rounded-3xl shadow-2xl border border-slate-700/60 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-center sm:text-left">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl shrink-0">
                            🧾
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 font-medium">
                                Total <span id="cartCount" class="font-bold text-blue-400">0</span> Layanan Dipilih
                            </div>
                            <div id="cartGrandTotal" class="text-xl sm:text-2xl font-black tracking-tight text-white">
                                Rp 0
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-auto">
                        <button type="button" onclick="openConfirmationModal()"
                                class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold text-sm px-8 py-3.5 rounded-2xl shadow-lg shadow-blue-500/25 transition active:scale-95 flex items-center justify-center gap-2">
                            <span>Lanjut Konfirmasi Pesanan</span> &rarr;
                        </button>
                    </div>
                </div>
            </div>

            <!-- MODAL KONFIRMASI PESANAN -->
            <div id="confirmModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
                <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 transform transition-all animate-fade-in max-h-[90vh] overflow-y-auto">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="text-2xl">🧺</span>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900">Konfirmasi Order Cucian</h3>
                                <p class="text-xs text-slate-400">Periksa rincian pesanan Anda sebelum dikirim</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeConfirmationModal()" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">
                            &times;
                        </button>
                    </div>

                    <!-- Modal Customer Info Preview -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60 text-xs space-y-1.5 mb-4">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Nama Pelanggan:</span>
                            <span id="modalCustomerName" class="font-bold text-slate-800"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">No. WhatsApp:</span>
                            <span id="modalCustomerPhone" class="font-mono text-slate-700"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Metode:</span>
                            <span id="modalPickupType" class="font-semibold text-blue-600"></span>
                        </div>
                    </div>

                    <!-- Itemized List -->
                    <div class="mb-4">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Rincian Layanan yang Dipesan:</div>
                        <ul id="modalItemList" class="divide-y divide-slate-100 max-h-48 overflow-y-auto"></ul>
                    </div>

                    <!-- Total Price in Modal -->
                    <div class="bg-blue-50/80 p-4 rounded-2xl border border-blue-100 flex items-center justify-between mb-6">
                        <span class="font-bold text-slate-700 text-sm">Total Estimasi Biaya:</span>
                        <span id="modalTotalPrice" class="text-2xl font-black text-blue-600">Rp 0</span>
                    </div>

                    <!-- Action Buttons -->
                    @guest
                        <div class="bg-amber-50 border border-amber-200 p-4 rounded-2xl text-xs text-amber-800 mb-4 flex items-center gap-3">
                            <span class="text-2xl">🔒</span>
                            <div>
                                <div class="font-bold">Masuk atau Buat Akun</div>
                                <div>Untuk melacak dan mencatat riwayat pesanan dengan aman, silakan login terlebih dahulu.</div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" onclick="closeConfirmationModal()"
                                    class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-2xl transition text-xs">
                                Batal
                            </button>
                            <a href="{{ route('login') }}"
                               class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-2xl transition text-xs text-center flex items-center justify-center shadow-md shadow-blue-500/20">
                                Login Sekarang &rarr;
                            </a>
                        </div>
                    @else
                        <div class="flex gap-3">
                            <button type="button" onclick="closeConfirmationModal()"
                                    class="w-1/3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 rounded-2xl transition text-xs">
                                Perbaiki
                            </button>
                            <button type="submit"
                                    class="w-2/3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-extrabold py-3.5 rounded-2xl shadow-lg shadow-green-600/25 transition text-xs flex items-center justify-center gap-1.5">
                                <span>Kirim Pesanan Laundry</span> &rarr;
                            </button>
                        </div>
                    @endguest
                </div>
            </div>
        </form>
    </section>

    <!-- 5. FAQ SECTION -->
    <section id="faq" class="max-w-4xl mx-auto px-4 py-16">
        <div class="text-center mb-10">
            <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pertanyaan yang Sering Diajukan (FAQ)</h3>
            <p class="text-xs text-slate-500 mt-1">Informasi penting mengenai layanan Andri Laundry</p>
        </div>

        <div class="space-y-4 text-sm">
            <details class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm cursor-pointer group">
                <summary class="font-bold text-slate-800 list-none flex justify-between items-center">
                    <span>Apakah pakaian saya akan dicampur dengan pakaian pelanggan lain?</span>
                    <span class="text-blue-600 font-bold group-open:rotate-180 transition-transform">&darr;</span>
                </summary>
                <p class="mt-3 text-xs text-slate-500 leading-relaxed border-t pt-3">
                    <strong>Sama sekali tidak!</strong> Kami menerapkan standar operasional ketat 1 mesin cuci hanya untuk 1 pelanggan saja untuk menjaga kebersihan maksimal dan menghindari pakaian tertukar atau kelunturan.
                </p>
            </details>

            <details class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm cursor-pointer group">
                <summary class="font-bold text-slate-800 list-none flex justify-between items-center">
                    <span>Bagaimana cara memantau pakaian saya sudah selesai atau belum?</span>
                    <span class="text-blue-600 font-bold group-open:rotate-180 transition-transform">&darr;</span>
                </summary>
                <p class="mt-3 text-xs text-slate-500 leading-relaxed border-t pt-3">
                    Setelah pesanan berhasil dibuat, Anda akan mendapatkan <strong>Nomor Resi Resmi</strong> (contoh: LDR-20261124-XXXX). Cukup buka menu <strong><a href="{{ route('orders.track') }}" class="text-blue-600 underline">Lacak Resi</a></strong> di website ini kapan saja untuk melihat status pengerjaan secara realtime.
                </p>
            </details>

            <details class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm cursor-pointer group">
                <summary class="font-bold text-slate-800 list-none flex justify-between items-center">
                    <span>Apakah tersedia layanan antar-jemput ke lokasi saya?</span>
                    <span class="text-blue-600 font-bold group-open:rotate-180 transition-transform">&darr;</span>
                </summary>
                <p class="mt-3 text-xs text-slate-500 leading-relaxed border-t pt-3">
                    Ya, kami menyediakan opsi <strong>Jemput & Antar</strong>. Cukup pilih opsi tersebut pada form pemesanan dan isi alamat lengkap Anda. Kurir kami akan segera menjemput cucian Anda.
                </p>
            </details>
        </div>
    </section>

    <!-- 6. FOOTER -->
    <footer class="bg-slate-900 text-white pt-12 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-slate-800">
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-2.5 font-bold text-xl">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg">
                            🧺
                        </div>
                        <span>Andri<span class="text-blue-400">Laundry</span></span>
                    </div>
                    <p class="text-xs text-slate-400 max-w-sm leading-relaxed">
                        Pilihan utama laundry berkualitas tinggi, bersih, wangi eksklusif, dan higienis untuk pakaian kerja, pakaian kasual, bed cover, tas, dan sepatu Anda.
                    </p>
                </div>

                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-3">Tautan Cepat</h5>
                    <ul class="text-xs text-slate-400 space-y-2">
                        <li><a href="#layanan" class="hover:text-white transition">Pilihan Paket Layanan</a></li>
                        <li><a href="{{ route('orders.track') }}" class="hover:text-white transition">Cek Resi Online</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Masuk Akun</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar Pelanggan Baru</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-3">Hubungi Kami</h5>
                    <div class="text-xs text-slate-400 space-y-2">
                        <p>📍 Jl. KH. Ahmad Dahlan No. 45</p>
                        <p>📞 WhatsApp: 0812-3456-7890</p>
                        <p>⏰ Buka: Setiap Hari (07:00 - 21:00 WIB)</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} Andri Laundry. Hak Cipta Dilindungi Undang-Undang.
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT LOGIC UNTUK KALKULATOR PESANAN REALTIME -->
    <script>
        function adjustQty(serviceId, delta) {
            const input = document.getElementById('qty_' + serviceId);
            if (!input) return;
            let current = parseInt(input.value) || 0;
            let max = parseInt(input.getAttribute('max')) || 999;
            let updated = current + delta;
            if (updated < 0) updated = 0;
            if (updated > max) updated = max;
            input.value = updated;
            recalcCart();
        }

        function recalcCart() {
            const inputs = document.querySelectorAll('.item-qty');
            let totalItems = 0;
            let grandTotal = 0;

            inputs.forEach(input => {
                const qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    totalItems += 1;
                    const price = parseFloat(input.getAttribute('data-price')) || 0;
                    grandTotal += (qty * price);
                }
            });

            document.getElementById('cartCount').textContent = totalItems;
            document.getElementById('cartGrandTotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        function openConfirmationModal() {
            const name = document.getElementById('customer_name').value.trim();
            if (!name) {
                alert('Silakan masukkan Nama Lengkap Pelanggan terlebih dahulu pada Langkah 1!');
                document.getElementById('customer_name').focus();
                return;
            }

            const inputs = document.querySelectorAll('.item-qty');
            let itemListHtml = '';
            let grandTotal = 0;
            let hasSelected = false;

            inputs.forEach(input => {
                const qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    hasSelected = true;
                    const name = input.getAttribute('data-name');
                    const price = parseFloat(input.getAttribute('data-price')) || 0;
                    const unit = input.getAttribute('data-unit') || 'Kg';
                    const subtotal = qty * price;
                    grandTotal += subtotal;

                    itemListHtml += `
                        <li class="py-2.5 flex items-center justify-between text-xs">
                            <div>
                                <strong class="text-slate-800 block">${name}</strong>
                                <span class="text-slate-400">${qty} ${unit} @ Rp ${price.toLocaleString('id-ID')}</span>
                            </div>
                            <span class="font-bold text-slate-800">Rp ${subtotal.toLocaleString('id-ID')}</span>
                        </li>
                    `;
                }
            });

            if (!hasSelected) {
                alert('Pilih minimal 1 paket layanan laundry dengan berat/jumlah lebih dari 0!');
                return;
            }

            const phone = document.getElementById('customer_phone').value.trim() || '-';
            const pickupType = document.querySelector('input[name="pickup_type"]:checked')?.value || 'Antar Sendiri';

            document.getElementById('modalCustomerName').textContent = name;
            document.getElementById('modalCustomerPhone').textContent = phone;
            document.getElementById('modalPickupType').textContent = pickupType;
            document.getElementById('modalItemList').innerHTML = itemListHtml;
            document.getElementById('modalTotalPrice').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');

            const modal = document.getElementById('confirmModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeConfirmationModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Jalankan kalkulasi awal saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            recalcCart();
        });
    </script>
</body>
</html>

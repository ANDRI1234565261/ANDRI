<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    @if(Auth::user()->isAdmin())
                        {{ __('Panel Kontrol & Manajemen Pesanan') }}
                    @else
                        {{ __('Riwayat Cucian & Akun Saya') }}
                    @endif
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    @if(Auth::user()->isAdmin())
                        Pantau omset harian, antrean mesin cuci, status pembayaran, dan resi pelanggan
                    @else
                        Pantau status pencucian pakaian Anda dan cetak nota transaksi
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-3">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                        <span>⚙️</span> Kelola Master Layanan
                    </a>
                @endif
                <a href="{{ route('customer.index') }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20">
                    <span>+</span> Buat Pesanan Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- NOTIFIKASI PESAN -->
            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5 text-sm font-medium">
                        <span>✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5 text-sm font-medium">
                        <span>⚠️</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-700 font-bold">&times;</button>
                </div>
            @endif

            <!-- 1. KPI & METRIK STATISTIK -->
            @if(Auth::user()->isAdmin())
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Total Omset -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Omset</span>
                            <span class="text-xl sm:text-2xl font-black text-slate-900 mt-1 block">
                                Rp {{ number_format($metrics['totalRevenue'], 0, ',', '.') }}
                            </span>
                            <span class="text-[11px] text-green-600 font-semibold">
                                Lunas: Rp {{ number_format($metrics['paidRevenue'], 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                            💰
                        </div>
                    </div>

                    <!-- Sedang Dikerjakan -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Proses Antrean</span>
                            <span class="text-xl sm:text-2xl font-black text-blue-600 mt-1 block">
                                {{ $metrics['activeOrders'] }} Pesanan
                            </span>
                            <span class="text-[11px] text-slate-500">Antrean cuci & setrika</span>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                            🧼
                        </div>
                    </div>

                    <!-- Total Selesai -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Cucian Selesai</span>
                            <span class="text-xl sm:text-2xl font-black text-slate-900 mt-1 block">
                                {{ $metrics['completedOrders'] }} Selesai
                            </span>
                            <span class="text-[11px] text-slate-500">Total transaksi rampung</span>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                            ✅
                        </div>
                    </div>

                    <!-- Piutang Belum Lunas -->
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Belum Lunas</span>
                            <span class="text-xl sm:text-2xl font-black text-amber-600 mt-1 block">
                                Rp {{ number_format($metrics['unpaidRevenue'], 0, ',', '.') }}
                            </span>
                            <span class="text-[11px] text-slate-500">Tagihan belum dibayar</span>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                            💳
                        </div>
                    </div>
                </div>

                <!-- 2. FILTER & TOOLBAR PENCARIAN (ADMIN) -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                    <form action="{{ route('dashboard') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-center">
                        <!-- Input Cari Resi / Pelanggan -->
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-slate-400 text-sm">🔍</span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Resi / Nama / No HP..."
                                class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- Filter Status Cucian -->
                        <div>
                            <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="all">Semua Status Cucian</option>
                                <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending (Diterima)</option>
                                <option value="Proses Cuci" {{ request('status') === 'Proses Cuci' ? 'selected' : '' }}>Proses Cuci & Kering</option>
                                <option value="Setrika" {{ request('status') === 'Setrika' ? 'selected' : '' }}>Setrika & Finishing</option>
                                <option value="Siap Diambil" {{ request('status') === 'Siap Diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </div>

                        <!-- Filter Status Pembayaran -->
                        <div>
                            <select name="payment" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="all">Semua Status Bayar</option>
                                <option value="Lunas" {{ request('payment') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="Belum Lunas" {{ request('payment') === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            </select>
                        </div>

                        <!-- Tombol Submit & Reset -->
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-xl text-xs transition shadow-sm">
                                Terapkan Filter
                            </button>
                            @if(request()->hasAny(['search', 'status', 'payment']))
                                <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition flex items-center justify-center">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            @else
                <!-- STATISTIK KHUSUS PELANGGAN -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Cucian</span>
                        <span class="text-2xl font-black text-slate-900 mt-1 block">{{ $metrics['totalOrders'] }} Pesanan</span>
                    </div>
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Sedang Diproses</span>
                        <span class="text-2xl font-black text-blue-600 mt-1 block">{{ $metrics['activeOrders'] }} Pakaian</span>
                    </div>
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Cucian Selesai</span>
                        <span class="text-2xl font-black text-green-600 mt-1 block">{{ $metrics['completedOrders'] }} Selesai</span>
                    </div>
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pengeluaran</span>
                        <span class="text-xl font-black text-slate-900 mt-1 block">Rp {{ number_format($metrics['totalSpent'], 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif

            <!-- 3. TABEL DATA PESANAN -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-base text-slate-900">
                            {{ Auth::user()->isAdmin() ? 'Daftar Transaksi Pesanan Laundry' : 'Riwayat Pesanan Anda' }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Menampilkan data pesanan terbaru beserta status pengerjaan
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-4">No. Resi & Tanggal</th>
                                <th class="p-4">Pelanggan</th>
                                <th class="p-4">Rincian Layanan</th>
                                <th class="p-4">Total Biaya</th>
                                <th class="p-4">Pembayaran</th>
                                <th class="p-4">Status Cucian</th>
                                <th class="p-4 text-center">Aksi & Nota</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($orders as $order)
                                @php
                                    $st = $order->status;
                                    $pay = $order->payment_status;
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <!-- No. Resi -->
                                    <td class="p-4">
                                        <a href="{{ route('orders.receipt', $order->order_code) }}" target="_blank"
                                           class="font-mono font-bold text-blue-600 hover:text-blue-800 text-xs block hover:underline">
                                            {{ $order->order_code }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block mt-0.5">
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </td>

                                    <!-- Pelanggan -->
                                    <td class="p-4">
                                        <div class="font-bold text-slate-800">{{ $order->customer_name }}</div>
                                        @if($order->customer_phone)
                                            <div class="text-[11px] font-mono text-slate-400">{{ $order->customer_phone }}</div>
                                        @endif
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold mt-1 {{ $order->pickup_type === 'Jemput Antar' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600' }}">
                                            {{ $order->pickup_type }}
                                        </span>
                                    </td>

                                    <!-- Rincian Layanan -->
                                    <td class="p-4">
                                        <ul class="space-y-1">
                                            @foreach($order->orderDetails as $detail)
                                                <li class="text-slate-600">
                                                    <strong>{{ $detail->service->name ?? 'Layanan' }}</strong>
                                                    - {{ $detail->quantity }} {{ $detail->service?->unit ?: 'Kg' }}
                                                    <span class="text-slate-400">(Rp {{ number_format($detail->subtotal, 0, ',', '.') }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if($order->notes)
                                            <div class="text-[10px] text-amber-700 bg-amber-50 p-1.5 rounded mt-1.5 italic">
                                                Catatan: {{ $order->notes }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Total Biaya -->
                                    <td class="p-4 font-black text-slate-900 text-sm">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>

                                    <!-- Pembayaran -->
                                    <td class="p-4">
                                        @if(Auth::user()->isAdmin())
                                            <!-- Tombol Toggle Pembayaran untuk Admin -->
                                            <form action="{{ route('admin.orders.updatePayment', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="payment_status" value="{{ $pay === 'Lunas' ? 'Belum Lunas' : 'Lunas' }}">
                                                <button type="submit"
                                                        title="Klik untuk ubah status pembayaran"
                                                        class="px-2.5 py-1 rounded-full text-[11px] font-bold transition flex items-center gap-1 {{ $pay === 'Lunas' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}">
                                                    <span>{{ $pay === 'Lunas' ? '✓ Lunas' : '⏳ Belum Lunas' }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $pay === 'Lunas' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $pay }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Status Cucian -->
                                    <td class="p-4">
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()"
                                                        class="text-[11px] font-bold border border-slate-300 rounded-xl px-2 py-1.5 bg-white shadow-sm outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option value="Pending" {{ $st === 'Pending' ? 'selected' : '' }}>📥 Pending</option>
                                                    <option value="Proses Cuci" {{ $st === 'Proses Cuci' ? 'selected' : '' }}>🧼 Proses Cuci</option>
                                                    <option value="Setrika" {{ $st === 'Setrika' ? 'selected' : '' }}>👔 Setrika</option>
                                                    <option value="Siap Diambil" {{ $st === 'Siap Diambil' ? 'selected' : '' }}>✨ Siap Diambil</option>
                                                    <option value="Selesai" {{ $st === 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                                    <option value="Batal" {{ $st === 'Batal' ? 'selected' : '' }}>❌ Batal</option>
                                                </select>
                                            </form>
                                        @else
                                            @if($st === 'Pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-[11px] font-bold px-2.5 py-1 rounded-full">DITERIMA</span>
                                            @elseif($st === 'Proses Cuci')
                                                <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-2.5 py-1 rounded-full">PROSES CUCI</span>
                                            @elseif($st === 'Setrika')
                                                <span class="bg-purple-100 text-purple-800 text-[11px] font-bold px-2.5 py-1 rounded-full">SETRIKA UAP</span>
                                            @elseif($st === 'Siap Diambil')
                                                <span class="bg-teal-100 text-teal-800 text-[11px] font-bold px-2.5 py-1 rounded-full">SIAP DIAMBIL</span>
                                            @elseif($st === 'Selesai')
                                                <span class="bg-green-100 text-green-800 text-[11px] font-bold px-2.5 py-1 rounded-full">SELESAI</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-[11px] font-bold px-2.5 py-1 rounded-full">BATAL</span>
                                            @endif
                                        @endif
                                    </td>

                                    <!-- Aksi / Tombol Nota & WA -->
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Cetak Nota -->
                                            <a href="{{ route('orders.receipt', $order->order_code) }}" target="_blank"
                                               class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition" title="Cetak Struk">
                                                🖨️
                                            </a>

                                            <!-- Lacak Resi -->
                                            <a href="{{ route('orders.track', ['code' => $order->order_code]) }}" target="_blank"
                                               class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition" title="Lacak Realtime">
                                                🔍
                                            </a>

                                            @if(Auth::user()->isAdmin())
                                                <!-- WhatsApp Notif Pelanggan -->
                                                @if($order->getWhatsappNotificationUrl())
                                                    <a href="{{ $order->getWhatsappNotificationUrl() }}" target="_blank"
                                                       class="p-1.5 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition" title="Kirim WA">
                                                        💬
                                                    </a>
                                                @endif

                                                <!-- Hapus Pesanan -->
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan {{ $order->order_code }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" title="Hapus">
                                                        🗑️
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-10 text-center text-slate-400">
                                        <div class="text-3xl mb-2">🧺</div>
                                        <div class="font-bold text-slate-600">Belum ada data pesanan yang sesuai kriteria.</div>
                                        <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Buat Pesanan Baru" untuk menambahkan transaksi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINASI -->
                @if($orders->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

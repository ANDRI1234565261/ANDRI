<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    Master Data Layanan Laundry
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Atur tarif harga, kuota kapasitas harian, estimasi pengerjaan, dan satuan produk cucian
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-2">
                    &larr; Kembali ke Dashboard
                </a>
                <a href="{{ route('services.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20">
                    <span>+</span> Tambah Layanan Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5 text-sm font-medium">
                        <span>✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
                </div>
            @endif

            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-4">Ikon & Layanan</th>
                                <th class="p-4">Tarif</th>
                                <th class="p-4">Satuan</th>
                                <th class="p-4">Kapasitas Harian</th>
                                <th class="p-4">Estimasi</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($services as $service)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-xl flex items-center justify-center shrink-0">
                                                {{ $service->icon ?: '🧺' }}
                                            </div>
                                            <div>
                                                <strong class="text-slate-900 block font-bold text-sm">{{ $service->name }}</strong>
                                                <span class="text-[11px] text-slate-400 max-w-xs block truncate">{{ $service->description }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 font-black text-slate-900 text-sm">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 font-semibold text-slate-700">
                                        Per {{ $service->unit ?: 'Kg' }}
                                    </td>
                                    <td class="p-4 font-bold text-slate-800">
                                        {{ $service->stock }} {{ $service->unit ?: 'Kg' }}
                                    </td>
                                    <td class="p-4 text-slate-600 font-medium">
                                        ⏱️ {{ $service->estimation ?: '1-2 Hari' }}
                                    </td>
                                    <td class="p-4">
                                        @if($service->is_active ?? true)
                                            <span class="bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-full text-[10px]">
                                                AKTIF
                                            </span>
                                        @else
                                            <span class="bg-slate-100 text-slate-500 font-bold px-2.5 py-1 rounded-full text-[10px]">
                                                NONAKTIF
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('services.edit', $service->id) }}"
                                               class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold rounded-lg transition text-xs">
                                                Edit
                                            </a>
                                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan {{ $service->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-lg transition text-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-10 text-center text-slate-400">
                                        Belum ada data layanan laundry. Silakan klik tombol "Tambah Layanan Baru".
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($services->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

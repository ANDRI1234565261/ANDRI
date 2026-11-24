<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    Edit Layanan Laundry
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Perbarui data tarif, kuota, atau deskripsi layanan {{ $service->name }}
                </p>
            </div>
            <a href="{{ route('services.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 px-3 py-2">
                &larr; Batal & Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-800 p-4 rounded-2xl mb-6 text-xs">
                    <div class="font-bold mb-1">Periksa isian berikut:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('services.update', $service->id) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/90 shadow-sm space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Layanan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Paket Layanan *</label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" required
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Tarif Harga -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tarif Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $service->price) }}" min="0" required
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>

                    <!-- Satuan Unit -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Satuan Unit *</label>
                        <select name="unit" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                            <option value="Kg" {{ old('unit', $service->unit) === 'Kg' ? 'selected' : '' }}>Kg (Kiloan)</option>
                            <option value="Pcs" {{ old('unit', $service->unit) === 'Pcs' ? 'selected' : '' }}>Pcs (Satuan)</option>
                            <option value="Pasang" {{ old('unit', $service->unit) === 'Pasang' ? 'selected' : '' }}>Pasang (Sepatu/Kaos Kaki)</option>
                            <option value="Meter" {{ old('unit', $service->unit) === 'Meter' ? 'selected' : '' }}>Meter (Karpet / Gorden)</option>
                        </select>
                    </div>

                    <!-- Emoji/Icon -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ikon Emoji</label>
                        <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" maxlength="10"
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition text-center">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Kuota Kapasitas Harian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kuota Kapasitas Harian *</label>
                        <input type="number" name="stock" value="{{ old('stock', $service->stock) }}" min="0" required
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>

                    <!-- Estimasi Waktu -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Estimasi Pengerjaan</label>
                        <input type="text" name="estimation" value="{{ old('estimation', $service->estimation) }}"
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <!-- Deskripsi Layanan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi & Keunggulan Layanan *</label>
                    <textarea name="description" rows="3" required
                              class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">{{ old('description', $service->description) }}</textarea>
                </div>

                <!-- Status Aktif Checkbox -->
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 border-slate-300">
                    <label for="is_active" class="text-xs font-bold text-slate-700">Tampilkan Layanan Ini di Katalog Pelanggan (Status Aktif)</label>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('services.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-md shadow-blue-500/20 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

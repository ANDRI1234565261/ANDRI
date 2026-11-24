<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // 1. Tampilkan tabel daftar master layanan laundry
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    // 2. Tampilkan form tambah layanan baru
    public function create()
    {
        return view('admin.services.create');
    }

    // 3. Simpan layanan baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'required|string|max:20',
            'icon'        => 'nullable|string|max:20',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            'estimation'  => 'nullable|string|max:100',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['icon'] = $validated['icon'] ?: '🧺';
        $validated['is_active'] = $request->has('is_active');

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Paket layanan laundry baru berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit layanan
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // 5. Simpan perubahan layanan yang diedit
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'required|string|max:20',
            'icon'        => 'nullable|string|max:20',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            'estimation'  => 'nullable|string|max:100',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['icon'] = $validated['icon'] ?: '🧺';
        $validated['is_active'] = $request->has('is_active');

        $service->update($validated);

        return redirect()->route('services.index')->with('success', "Layanan '{$service->name}' berhasil diperbarui!");
    }

    // 6. Hapus layanan dari database
    public function destroy(Service $service)
    {
        $name = $service->name;
        $service->delete();

        return redirect()->route('services.index')->with('success', "Layanan '{$name}' berhasil dihapus!");
    }
}

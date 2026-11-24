<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // 1. Tampilkan katalog layanan laundry & landing page modern
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        $recentOrder = null;

        if (Auth::check()) {
            $recentOrder = Order::where('user_id', Auth::id())->latest()->first();
        }

        return view('customer.index', compact('services', 'recentOrder'));
    }

    // 2. Pelacakan Resi Publik / Cek Resi Laundry Realtime
    public function track(Request $request)
    {
        $code = trim($request->query('code', ''));
        $order = null;

        if (!empty($code)) {
            $order = Order::with('orderDetails.service', 'user')
                ->where('order_code', strtoupper($code))
                ->first();
        }

        return view('customer.track', compact('order', 'code'));
    }

    // 3. Proses Checkout & Simpan Pesanan Laundry
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'nullable|string|max:30',
            'customer_address' => 'nullable|string|max:500',
            'pickup_type'      => 'nullable|string|in:Antar Sendiri,Jemput Antar',
            'notes'            => 'nullable|string|max:500',
            'items'            => 'required|array',
            'items.*'          => 'nullable|integer|min:0',
        ]);

        // Ambil hanya layanan laundry yang kuantiti/beratnya > 0
        $orderedItems = array_filter($request->items, fn ($qty) => $qty > 0);

        if (empty($orderedItems)) {
            return back()->with('error', 'Silakan tentukan minimal 1 paket layanan dengan berat / jumlah lebih dari 0!')->withInput();
        }

        DB::beginTransaction();
        try {
            // Format kode unik resi: LDR-YYYYMMDD-XXXX
            $orderCode = 'LDR-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            $order = Order::create([
                'user_id'          => Auth::id(),
                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'pickup_type'      => $request->pickup_type ?? 'Antar Sendiri',
                'order_code'       => $orderCode,
                'total_price'      => 0,
                'status'           => 'Pending',
                'payment_status'   => 'Belum Lunas',
                'notes'            => $request->notes,
            ]);

            $totalPrice = 0;

            // Simpan detail dan kunci baris untuk konsistensi kuota
            foreach ($orderedItems as $serviceId => $quantity) {
                $service = Service::lockForUpdate()->findOrFail($serviceId);

                if ($service->stock < $quantity) {
                    throw new \Exception("Kuota harian untuk layanan '{$service->name}' tersisa {$service->stock} {$service->unit}. Mohon sesuaikan jumlah pesanan.");
                }

                $service->decrement('stock', $quantity);

                $subtotal = $service->price * $quantity;
                $totalPrice += $subtotal;

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'service_id' => $service->id,
                    'quantity'   => $quantity,
                    'price'      => $service->price,
                    'subtotal'   => $subtotal,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);

            DB::commit();

            return redirect()->route('orders.receipt', $order->order_code)
                ->with('success', 'Pesanan laundry Anda berhasil dibuat! Simpan atau cetak nomor resi Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }

    // 4. Tampilkan Nota / Struk Digital & Cetak Invoice (Thermal / A4)
    public function receipt($order_code)
    {
        $order = Order::with('orderDetails.service', 'user')
            ->where('order_code', strtoupper($order_code))
            ->firstOrFail();

        return view('orders.receipt', compact('order'));
    }

    // 5. Dashboard Utama (Admin: Analytics & Management | Pelanggan: Riwayat Akun)
    public function adminDashboard(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Hitung KPI & Metrik Bisnis untuk Admin
            $metrics = [
                'totalRevenue'    => Order::where('status', '!=', 'Batal')->sum('total_price'),
                'paidRevenue'     => Order::where('payment_status', 'Lunas')->sum('total_price'),
                'unpaidRevenue'   => Order::where('payment_status', 'Belum Lunas')->where('status', '!=', 'Batal')->sum('total_price'),
                'totalOrders'     => Order::count(),
                'activeOrders'    => Order::whereIn('status', ['Pending', 'Proses Cuci', 'Setrika', 'Siap Diambil'])->count(),
                'completedOrders' => Order::where('status', 'Selesai')->count(),
                'totalCustomers'  => User::where('role', 'pengguna')->count(),
                'todayOrders'     => Order::whereDate('created_at', today())->count(),
            ];

            // Filter & Pencarian Pesanan
            $query = Order::with('orderDetails.service')->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('order_code', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            if ($request->filled('payment') && $request->payment !== 'all') {
                $query->where('payment_status', $request->payment);
            }

            $orders = $query->paginate(15)->withQueryString();

            return view('dashboard', compact('orders', 'metrics'));
        } else {
            // Tampilan untuk Pelanggan Biasa
            $metrics = [
                'totalOrders'     => Order::where('user_id', $user->id)->count(),
                'activeOrders'    => Order::where('user_id', $user->id)->whereIn('status', ['Pending', 'Proses Cuci', 'Setrika', 'Siap Diambil'])->count(),
                'completedOrders' => Order::where('user_id', $user->id)->where('status', 'Selesai')->count(),
                'totalSpent'      => Order::where('user_id', $user->id)->where('status', '!=', 'Batal')->sum('total_price'),
            ];

            $orders = Order::with('orderDetails.service')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);

            return view('dashboard', compact('orders', 'metrics'));
        }
    }

    // 6. Update Status Cucian (Pending -> Proses Cuci -> Setrika -> Siap Diambil -> Selesai / Batal)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Proses Cuci,Setrika,Siap Diambil,Selesai,Batal',
        ]);

        $order = Order::with('orderDetails.service')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Jika dibatalkan, pulihkan kuota layanan
        if (strtolower($newStatus) === 'batal' && strtolower($oldStatus) !== 'batal') {
            foreach ($order->orderDetails as $detail) {
                if ($detail->service) {
                    $detail->service->increment('stock', $detail->quantity);
                }
            }
        } elseif (strtolower($oldStatus) === 'batal' && strtolower($newStatus) !== 'batal') {
            foreach ($order->orderDetails as $detail) {
                if ($detail->service) {
                    $detail->service->decrement('stock', $detail->quantity);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', "Status pesanan {$order->order_code} diperbarui ke: {$newStatus}");
    }

    // 7. Update Status Pembayaran (Belum Lunas <-> Lunas)
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|string|in:Belum Lunas,Lunas',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', "Status pembayaran {$order->order_code} diubah menjadi: {$order->payment_status}");
    }

    // 8. Hapus Pesanan
    public function destroy($id)
    {
        $order = Order::with('orderDetails.service')->findOrFail($id);

        // Jika pesanan belum berstatus Selesai / Batal, kembalikan kuotanya
        if (!in_array($order->status, ['Selesai', 'Batal'])) {
            foreach ($order->orderDetails as $detail) {
                if ($detail->service) {
                    $detail->service->increment('stock', $detail->quantity);
                }
            }
        }

        $code = $order->order_code;
        $order->delete();

        return back()->with('success', "Data pesanan {$code} berhasil dihapus.");
    }
}

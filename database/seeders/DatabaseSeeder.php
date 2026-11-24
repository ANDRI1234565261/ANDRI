<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Laundry
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.test'],
            [
                'name'     => 'Laundry Admin (Demo)',
                'password' => Hash::make(Str::random(40)),
                'role'     => 'admin',
            ]
        );

        // 2. Buat Akun Pelanggan Contoh
        $budi = User::firstOrCreate(
            ['email' => 'customer-one@example.test'],
            [
                'name'     => 'Customer One',
                'password' => Hash::make(Str::random(40)),
                'role'     => 'pengguna',
            ]
        );

        $siti = User::firstOrCreate(
            ['email' => 'customer-two@example.test'],
            [
                'name'     => 'Customer Two',
                'password' => Hash::make(Str::random(40)),
                'role'     => 'pengguna',
            ]
        );

        // 3. Masukkan Data Master Layanan Laundry
        $servicesData = [
            [
                'name'        => 'Cuci Komplit (Cuci + Kering + Setrika)',
                'price'       => 8000,
                'unit'        => 'Kg',
                'icon'        => '🧺',
                'stock'       => 150,
                'description' => 'Pakaian dicuci higienis, dikeringkan mesin, disetrika uap rapi & wangi lavender tahan lama.',
                'estimation'  => '2 Hari',
                'is_active'   => true,
            ],
            [
                'name'        => 'Cuci Kering Lipat',
                'price'       => 6000,
                'unit'        => 'Kg',
                'icon'        => '👕',
                'stock'       => 200,
                'description' => 'Pakaian dicuci bersih anti bakteri, dikeringkan maksimal, dan dilipat rapi siap pakai.',
                'estimation'  => '1 Hari',
                'is_active'   => true,
            ],
            [
                'name'        => 'Express Kilat Super (4 Jam Selesai)',
                'price'       => 15000,
                'unit'        => 'Kg',
                'icon'        => '⚡',
                'stock'       => 40,
                'description' => 'Prioritas antrean pertama! Selesai dalam 4 jam, cuci kering setrika uap ekstra wangi.',
                'estimation'  => '4 Jam',
                'is_active'   => true,
            ],
            [
                'name'        => 'Setrika Uap Presisi & Wangi',
                'price'       => 5000,
                'unit'        => 'Kg',
                'icon'        => '👔',
                'stock'       => 100,
                'description' => 'Hanya setrika uap untuk pakaian bersih Anda, licin rapi tanpa bekas terbakar / mengkilap.',
                'estimation'  => '1 Hari',
                'is_active'   => true,
            ],
            [
                'name'        => 'Cuci Bed Cover & Selimut Jumbo',
                'price'       => 25000,
                'unit'        => 'Pcs',
                'icon'        => '🛏️',
                'stock'       => 30,
                'description' => 'Pencucian khusus bed cover & sprei tebal menggunakan sabun anti-tungau & pewangi segar.',
                'estimation'  => '2-3 Hari',
                'is_active'   => true,
            ],
            [
                'name'        => 'Deep Clean Sepatu & Tas Premium',
                'price'       => 35000,
                'unit'        => 'Pasang',
                'icon'        => '👟',
                'stock'       => 25,
                'description' => 'Treatment pembersihan detail sol luar, dalam, unyellowing, dan perlindungan bahan suede/kulit.',
                'estimation'  => '2 Hari',
                'is_active'   => true,
            ],
        ];

        $createdServices = [];
        foreach ($servicesData as $s) {
            $createdServices[] = Service::updateOrCreate(['name' => $s['name']], $s);
        }

        // 4. Buat Pesanan Contoh dengan berbagai Status untuk mendemonstrasikan Dashboard
        if (Order::count() === 0) {
            $sampleOrders = [
                [
                    'user_id'          => $budi->id,
                    'customer_name'    => 'Customer One',
                    'customer_phone'   => '00000000000',
                    'customer_address' => '123 Example Street, Example City',
                    'pickup_type'      => 'Jemput Antar',
                    'order_code'       => 'LDR-20261124-0001',
                    'total_price'      => 40000,
                    'status'           => 'Proses Cuci',
                    'payment_status'   => 'Lunas',
                    'notes'            => 'Baju warna putih tolong dipisah, parfum sakura.',
                    'items'            => [
                        ['service_id' => $createdServices[0]->id, 'qty' => 5], // Cuci Komplit 5 Kg
                    ],
                ],
                [
                    'user_id'          => $siti->id,
                    'customer_name'    => 'Customer Two',
                    'customer_phone'   => '00000000000',
                    'customer_address' => '456 Example Avenue, Example City',
                    'pickup_type'      => 'Antar Sendiri',
                    'order_code'       => 'LDR-20261124-0002',
                    'total_price'      => 75000,
                    'status'           => 'Setrika',
                    'payment_status'   => 'Lunas',
                    'notes'            => 'Bed cover king size motif bunga.',
                    'items'            => [
                        ['service_id' => $createdServices[4]->id, 'qty' => 2], // 2 Bed Cover
                        ['service_id' => $createdServices[4]->id, 'qty' => 1], // 1 Selimut
                    ],
                ],
                [
                    'user_id'          => $budi->id,
                    'customer_name'    => 'Customer One',
                    'customer_phone'   => '00000000000',
                    'customer_address' => '123 Example Street, Example City',
                    'pickup_type'      => 'Antar Sendiri',
                    'order_code'       => 'LDR-20261124-0003',
                    'total_price'      => 45000,
                    'status'           => 'Siap Diambil',
                    'payment_status'   => 'Belum Lunas',
                    'notes'            => 'Kemeja kerja tolong digantung pakai hanger.',
                    'items'            => [
                        ['service_id' => $createdServices[2]->id, 'qty' => 3], // Express 3 Kg
                    ],
                ],
                [
                    'user_id'          => null,
                    'customer_name'    => 'Example Guest',
                    'customer_phone'   => '00000000000',
                    'customer_address' => 'Example Guest Address',
                    'pickup_type'      => 'Antar Sendiri',
                    'order_code'       => 'LDR-20261124-0004',
                    'total_price'      => 24000,
                    'status'           => 'Pending',
                    'payment_status'   => 'Belum Lunas',
                    'notes'            => 'Pakaian sehari-hari.',
                    'items'            => [
                        ['service_id' => $createdServices[1]->id, 'qty' => 4], // Kering Lipat 4 Kg
                    ],
                ],
                [
                    'user_id'          => $siti->id,
                    'customer_name'    => 'Customer Two',
                    'customer_phone'   => '00000000000',
                    'customer_address' => '456 Example Avenue, Example City',
                    'pickup_type'      => 'Jemput Antar',
                    'order_code'       => 'LDR-20261123-0005',
                    'total_price'      => 70000,
                    'status'           => 'Selesai',
                    'payment_status'   => 'Lunas',
                    'notes'            => 'Sepatu sneakers putih & tas ransel.',
                    'items'            => [
                        ['service_id' => $createdServices[5]->id, 'qty' => 2], // 2 Pasang Sepatu
                    ],
                ],
            ];

            foreach ($sampleOrders as $sample) {
                $order = Order::create([
                    'user_id'          => $sample['user_id'],
                    'customer_name'    => $sample['customer_name'],
                    'customer_phone'   => $sample['customer_phone'],
                    'customer_address' => $sample['customer_address'],
                    'pickup_type'      => $sample['pickup_type'],
                    'order_code'       => $sample['order_code'],
                    'total_price'      => $sample['total_price'],
                    'status'           => $sample['status'],
                    'payment_status'   => $sample['payment_status'],
                    'notes'            => $sample['notes'],
                ]);

                foreach ($sample['items'] as $item) {
                    $srv = Service::find($item['service_id']);
                    OrderDetail::create([
                        'order_id'   => $order->id,
                        'service_id' => $srv->id,
                        'quantity'   => $item['qty'],
                        'price'      => $srv->price,
                        'subtotal'   => $srv->price * $item['qty'],
                    ]);
                }
            }
        }
    }
}

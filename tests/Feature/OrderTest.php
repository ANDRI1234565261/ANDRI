<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $customer;
    private Service $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
        ]);

        $this->customer = User::factory()->create([
            'role' => 'pengguna',
            'name' => 'Customer Test',
            'email' => 'customer@test.com',
        ]);

        $this->service = Service::create([
            'name' => 'Cuci Kilat',
            'price' => 10000,
            'unit' => 'Kg',
            'icon' => '⚡',
            'stock' => 50,
            'description' => 'Cuci kilat beres cepat',
            'estimation' => '1 Hari',
            'is_active' => true,
        ]);
    }

    public function test_customer_can_view_services_catalog(): void
    {
        $response = $this->get(route('customer.index'));

        $response->assertStatus(200);
        $response->assertSee('Cuci Kilat');
        $response->assertSee('Rp 10.000');
    }

    public function test_guest_cannot_checkout(): void
    {
        $response = $this->post(route('customer.checkout'), [
            'customer_name' => 'Tamu',
            'items' => [
                $this->service->id => 5,
            ],
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_customer_can_checkout_successfully_and_redirects_to_receipt(): void
    {
        $response = $this->actingAs($this->customer)->post(route('customer.checkout'), [
            'customer_name' => 'Customer Test',
            'customer_phone' => '081234567890',
            'customer_address' => 'Jl. Test No. 1',
            'pickup_type' => 'Jemput Antar',
            'notes' => 'Tolong pisahkan pakaian putih',
            'items' => [
                $this->service->id => 5,
            ],
        ]);

        $order = Order::first();
        $this->assertNotNull($order);

        $response->assertRedirect(route('orders.receipt', $order->order_code));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->customer->id,
            'customer_name' => 'Customer Test',
            'customer_phone' => '081234567890',
            'pickup_type' => 'Jemput Antar',
            'total_price' => 50000,
            'status' => 'Pending',
            'payment_status' => 'Belum Lunas',
        ]);

        $this->assertDatabaseHas('order_details', [
            'service_id' => $this->service->id,
            'quantity' => 5,
            'subtotal' => 50000,
        ]);

        // Stock must be decremented from 50 to 45
        $this->assertEquals(45, $this->service->fresh()->stock);
    }

    public function test_customer_can_track_order_by_receipt_code(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'customer_name' => 'Budi Tracker',
            'order_code' => 'LDR-TRACK-001',
            'total_price' => 30000,
            'status' => 'Proses Cuci',
            'payment_status' => 'Lunas',
        ]);

        $response = $this->get(route('orders.track', ['code' => 'LDR-TRACK-001']));

        $response->assertStatus(200);
        $response->assertSee('LDR-TRACK-001');
        $response->assertSee('Budi Tracker');
        $response->assertSee('Cuci &amp; Kering', false);
    }

    public function test_order_receipt_view_displays_correctly(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'customer_name' => 'Budi Receipt',
            'order_code' => 'LDR-NOTA-001',
            'total_price' => 20000,
            'status' => 'Pending',
            'payment_status' => 'Belum Lunas',
        ]);

        OrderDetail::create([
            'order_id' => $order->id,
            'service_id' => $this->service->id,
            'quantity' => 2,
            'price' => 10000,
            'subtotal' => 20000,
        ]);

        $response = $this->get(route('orders.receipt', 'LDR-NOTA-001'));

        $response->assertStatus(200);
        $response->assertSee('LDR-NOTA-001');
        $response->assertSee('ANDRI LAUNDRY');
        $response->assertSee('Budi Receipt');
    }

    public function test_admin_can_update_payment_status(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'customer_name' => 'Customer Test',
            'order_code' => 'LDR-PAY-001',
            'total_price' => 20000,
            'status' => 'Pending',
            'payment_status' => 'Belum Lunas',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.orders.updatePayment', $order->id), [
            'payment_status' => 'Lunas',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('Lunas', $order->fresh()->payment_status);
    }

    public function test_admin_can_delete_order(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'customer_name' => 'Order Hapus',
            'order_code' => 'LDR-DEL-001',
            'total_price' => 20000,
            'status' => 'Pending',
            'payment_status' => 'Belum Lunas',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.orders.destroy', $order->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}

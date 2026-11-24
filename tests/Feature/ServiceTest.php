<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->customer = User::factory()->create([
            'role' => 'pengguna',
        ]);
    }

    public function test_customer_cannot_access_admin_services(): void
    {
        $response = $this->actingAs($this->customer)->get(route('services.index'));
        $response->assertStatus(403);

        $response = $this->actingAs($this->customer)->get(route('services.create'));
        $response->assertStatus(403);
    }

    public function test_admin_can_view_services_list(): void
    {
        Service::create([
            'name' => 'Cuci Kering',
            'price' => 7000,
            'unit' => 'Kg',
            'icon' => '👕',
            'stock' => 100,
            'description' => 'Cuci kering wangi',
            'estimation' => '2 Hari',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('services.index'));

        $response->assertStatus(200);
        $response->assertSee('Cuci Kering');
    }

    public function test_admin_can_create_service(): void
    {
        $response = $this->actingAs($this->admin)->post(route('services.store'), [
            'name' => 'Setrika Uap Premium',
            'price' => 6000,
            'unit' => 'Kg',
            'icon' => '👔',
            'stock' => 80,
            'description' => 'Setrika uap rapi dan licin',
            'estimation' => '1 Hari',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('services.index'));
        $this->assertDatabaseHas('services', [
            'name' => 'Setrika Uap Premium',
            'price' => 6000,
            'unit' => 'Kg',
            'stock' => 80,
        ]);
    }

    public function test_admin_can_update_service(): void
    {
        $service = Service::create([
            'name' => 'Layanan Lama',
            'price' => 5000,
            'unit' => 'Kg',
            'icon' => '🧺',
            'stock' => 20,
            'description' => 'Deskripsi lama',
            'estimation' => '3 Hari',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put(route('services.update', $service->id), [
            'name' => 'Layanan Baru',
            'price' => 7500,
            'unit' => 'Kg',
            'icon' => '⚡',
            'stock' => 30,
            'description' => 'Deskripsi baru',
            'estimation' => '1 Hari',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('services.index'));
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Layanan Baru',
            'price' => 7500,
        ]);
    }

    public function test_admin_can_delete_service(): void
    {
        $service = Service::create([
            'name' => 'Layanan Hapus',
            'price' => 5000,
            'unit' => 'Kg',
            'icon' => '🧺',
            'stock' => 20,
            'description' => 'Akan dihapus',
            'estimation' => '1 Hari',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('services.destroy', $service->id));

        $response->assertRedirect(route('services.index'));
        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_view_services()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/services');

        $response->assertStatus(200);
    }

    public function test_an_admin_can_create_a_service()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $serviceData = [
            'name' => 'New Service',
            'description' => 'This is a new service.',
            'price' => 100.00,
        ];

        $response = $this->postJson('/api/services', $serviceData);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'New Service']);
    }

    public function test_a_user_cannot_create_a_service()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user);

        $serviceData = [
            'name' => 'New Service',
            'description' => 'This is a new service.',
            'price' => 100.00,
        ];

        $response = $this->postJson('/api/services', $serviceData);

        $response->assertStatus(403);
    }

    public function test_an_admin_can_update_a_service()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $service = Service::factory()->create();

        $updatedData = [
            'name' => 'Updated Service Name',
        ];

        $response = $this->putJson("/api/services/{$service->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Service Name']);
    }

    public function test_a_user_cannot_update_a_service()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $updatedData = [
            'name' => 'Updated Service Name',
        ];

        $response = $this->putJson("/api/services/{$service->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function test_an_admin_can_delete_a_service()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $service = Service::factory()->create();

        $response = $this->deleteJson("/api/services/{$service->id}");

        $response->assertStatus(204);
    }

    public function test_a_user_cannot_delete_a_service()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $response = $this->deleteJson("/api/services/{$service->id}");

        $response->assertStatus(403);
    }
}

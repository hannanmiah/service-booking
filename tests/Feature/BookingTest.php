<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\Booking;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_view_their_bookings()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/bookings');

        $response->assertStatus(200);
    }

    public function test_a_user_can_create_a_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $bookingData = [
            'service_id' => $service->id,
            'booking_date' => now()->addDays(5)->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/bookings', $bookingData);

        $response->assertStatus(201)
            ->assertJsonFragment(['service_id' => $service->id]);
    }

    public function test_a_user_cannot_create_a_booking_in_the_past()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $bookingData = [
            'service_id' => $service->id,
            'booking_date' => now()->subDays(1)->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/bookings', $bookingData);

        $response->assertStatus(422);
    }

    public function test_an_admin_can_view_all_bookings()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->get('/api/admin/bookings');

        $response->assertStatus(200);
    }

    public function test_a_user_cannot_view_all_bookings()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user);

        $response = $this->get('/api/admin/bookings');

        $response->assertStatus(403);
    }
}

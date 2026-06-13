<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Car $car;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'user']);
        $this->car = Car::factory()->create([
            'status' => 'available',
            'price_per_day' => 500000,
        ]);
    }

    public function test_booking_valid_3days(): void
    {
        $response = $this->actingAs($this->user)->post('/dat-xe', $this->validBookingData());

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'car_id' => $this->car->id,
            'phone' => '0912345678',
            'status' => 'pending',
            'total_price' => 1500000,
        ]); // TC-RQ07-01
    }

    public function test_booking_checkin_in_past(): void
    {
        $response = $this->actingAs($this->user)->post('/dat-xe', $this->validBookingData([
            'start_date' => Carbon::yesterday()->toDateString(),
            'end_date' => Carbon::tomorrow()->toDateString(),
        ]));

        $response->assertSessionHasErrors('start_date');
        $this->assertDatabaseCount('bookings', 0); // TC-RQ07-02
    }

    public function test_booking_checkout_equals_checkin_BVA(): void
    {
        $response = $this->actingAs($this->user)->post('/dat-xe', $this->validBookingData([
            'end_date' => Carbon::today()->toDateString(),
        ]));

        $response->assertSessionHasErrors('end_date'); // TC-RQ07-03
    }

    public function test_booking_phone_below_minimum_BVA(): void
    {
        $response = $this->actingAs($this->user)->post('/dat-xe', $this->validBookingData([
            'phone' => '09123456',
        ]));

        $response->assertSessionHasErrors('phone'); // TC-RQ07-05
    }

    public function test_booking_unavailable_car_is_rejected(): void
    {
        $this->car->update(['status' => 'maintenance']);

        $response = $this->actingAs($this->user)->post('/dat-xe', $this->validBookingData());

        $response->assertSessionHasErrors('car_id');
        $this->assertDatabaseCount('bookings', 0);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validBookingData(array $overrides = []): array
    {
        return array_merge([
            'car_id' => $this->car->id,
            'driver_name' => 'Nguyen Van A',
            'phone' => '0912345678',
            'start_date' => Carbon::today()->toDateString(),
            'end_date' => Carbon::today()->addDays(3)->toDateString(),
        ], $overrides);
    }
}

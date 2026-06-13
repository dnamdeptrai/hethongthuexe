<?php

namespace Tests\Unit;

use App\Services\BookingService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class BookingServiceTest extends TestCase
{
    private BookingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new BookingService;
    }

    public function test_calculateTotalPrice_valid_3days(): void
    {
        $result = $this->service->calculateTotalPrice(
            Carbon::today(),
            Carbon::today()->addDays(3),
            500000
        );

        $this->assertSame(1500000, $result); // TC-WB-P1
    }

    public function test_calculateTotalPrice_invalid_dates(): void
    {
        $result = $this->service->calculateTotalPrice(
            Carbon::today()->addDays(3),
            Carbon::today()->addDay(),
            500000
        );

        $this->assertFalse($result); // TC-WB-P2
    }

    public function test_calculateTotalPrice_BVA_same_date(): void
    {
        $result = $this->service->calculateTotalPrice(
            Carbon::today(),
            Carbon::today(),
            500000
        );

        $this->assertFalse($result); // TC-WB-P3
    }

    public function test_calculateTotalPrice_BVA_zero_price(): void
    {
        $result = $this->service->calculateTotalPrice(
            Carbon::today(),
            Carbon::today()->addDays(3),
            0
        );

        $this->assertFalse($result); // TC-WB-P4
    }

    public function test_validatePhone_8digits_invalid(): void
    {
        $this->assertFalse($this->service->validatePhone('09123456')); // TC-BB-RQ07-05
    }

    public function test_validatePhone_9digits_valid(): void
    {
        $this->assertTrue($this->service->validatePhone('091234567'));
    }

    public function test_validatePhone_11digits_valid(): void
    {
        $this->assertTrue($this->service->validatePhone('09123456789'));
    }

    public function test_validatePhone_12digits_invalid(): void
    {
        $this->assertFalse($this->service->validatePhone('091234567890')); // TC-BB-RQ07-06
    }
}

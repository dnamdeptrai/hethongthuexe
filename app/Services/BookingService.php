<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class BookingService
{
    public function calculateTotalPrice(
        CarbonInterface|string $checkIn,
        CarbonInterface|string $checkOut,
        int|float $pricePerDay
    ): int|false {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);

        if ($checkOutDate->lessThanOrEqualTo($checkInDate) || $pricePerDay <= 0) {
            return false;
        }

        return (int) ($checkInDate->diffInDays($checkOutDate) * $pricePerDay);
    }

    public function validatePhone(string $phone): bool
    {
        return preg_match('/^[0-9]{9,11}$/', $phone) === 1;
    }
}

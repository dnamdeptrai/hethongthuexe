package vn.hethongthuexe;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertThrows;

import java.time.LocalDate;
import org.junit.jupiter.api.Test;

class RentalPriceCalculatorTest {
    @Test
    void sameDayRentalIsChargedAsOneDay() {
        long total = RentalPriceCalculator.calculate(
                LocalDate.of(2026, 6, 7),
                LocalDate.of(2026, 6, 7),
                600_000,
                false);

        assertEquals(600_000, total);
    }

    @Test
    void multiDayRentalUsesTheDateDifference() {
        long total = RentalPriceCalculator.calculate(
                LocalDate.of(2026, 6, 7),
                LocalDate.of(2026, 6, 10),
                600_000,
                false);

        assertEquals(1_800_000, total);
    }

    @Test
    void rentalAcrossMonthBoundaryIsCalculatedCorrectly() {
        long total = RentalPriceCalculator.calculate(
                LocalDate.of(2026, 6, 30),
                LocalDate.of(2026, 7, 2),
                500_000,
                false);

        assertEquals(1_000_000, total);
    }

    @Test
    void rentalAcrossLeapDayIsCalculatedCorrectly() {
        long total = RentalPriceCalculator.calculate(
                LocalDate.of(2028, 2, 28),
                LocalDate.of(2028, 3, 1),
                750_000,
                false);

        assertEquals(1_500_000, total);
    }

    @Test
    void deliveryFeeIsAddedOnce() {
        long total = RentalPriceCalculator.calculate(
                LocalDate.of(2026, 6, 7),
                LocalDate.of(2026, 6, 10),
                600_000,
                true);

        assertEquals(2_000_000, total);
    }

    @Test
    void endDateBeforeStartDateIsRejected() {
        assertThrows(
                IllegalArgumentException.class,
                () -> RentalPriceCalculator.calculate(
                        LocalDate.of(2026, 6, 10),
                        LocalDate.of(2026, 6, 7),
                        600_000,
                        false));
    }

    @Test
    void negativeDailyPriceIsRejected() {
        assertThrows(
                IllegalArgumentException.class,
                () -> RentalPriceCalculator.calculate(
                        LocalDate.of(2026, 6, 7),
                        LocalDate.of(2026, 6, 8),
                        -1,
                        false));
    }
}

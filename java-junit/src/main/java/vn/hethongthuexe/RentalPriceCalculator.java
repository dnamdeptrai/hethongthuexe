package vn.hethongthuexe;

import java.time.LocalDate;
import java.time.temporal.ChronoUnit;
import java.util.Objects;

public final class RentalPriceCalculator {
    public static final long DELIVERY_FEE = 200_000L;

    private RentalPriceCalculator() {
    }

    public static long calculate(
            LocalDate startDate,
            LocalDate endDate,
            long pricePerDay,
            boolean deliveryRequested) {
        Objects.requireNonNull(startDate, "startDate must not be null");
        Objects.requireNonNull(endDate, "endDate must not be null");

        if (endDate.isBefore(startDate)) {
            throw new IllegalArgumentException("endDate must be on or after startDate");
        }
        if (pricePerDay < 0) {
            throw new IllegalArgumentException("pricePerDay must not be negative");
        }

        long rentalDays = Math.max(1, ChronoUnit.DAYS.between(startDate, endDate));
        long basePrice = Math.multiplyExact(rentalDays, pricePerDay);

        return deliveryRequested
                ? Math.addExact(basePrice, DELIVERY_FEE)
                : basePrice;
    }
}

from datetime import date, timedelta

from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait

from conftest import BASE_URL


class TestBookingFlow:
    USER_EMAIL = "testuser@gmail.com"
    USER_PASSWORD = "Test@1234"

    def _login(self, driver):
        driver.get(f"{BASE_URL}/login")
        driver.find_element(By.NAME, "email").send_keys(self.USER_EMAIL)
        driver.find_element(By.NAME, "password").send_keys(self.USER_PASSWORD)
        driver.find_element(By.CSS_SELECTOR, "button[type=submit]").click()
        WebDriverWait(driver, 10).until(EC.url_contains("/dashboard"))

    def _open_first_car(self, driver):
        self._login(driver)
        first_car = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, 'a[href*="/xe/"]'))
        )
        first_car.click()

    def _fill_booking_form(self, driver, start_date, end_date):
        driver.find_element(By.NAME, "driver_name").clear()
        driver.find_element(By.NAME, "driver_name").send_keys("Nguyen Van A")
        driver.find_element(By.NAME, "phone").send_keys("0912345678")
        for field_name, value in (
            ("start_date", start_date),
            ("end_date", end_date),
        ):
            field = driver.find_element(By.NAME, field_name)
            driver.execute_script(
                "arguments[0]._flatpickr.setDate(arguments[1], true);", field, value
            )

    def test_book_car_valid_3days(self, driver):
        self._open_first_car(driver)
        self._fill_booking_form(
            driver,
            date.today().isoformat(),
            (date.today() + timedelta(days=3)).isoformat(),
        )
        driver.find_element(By.CSS_SELECTOR, "form button[type=submit]").click()

        WebDriverWait(driver, 10).until(EC.url_contains("/thanh-toan/"))
        assert "/thanh-toan/" in driver.current_url  # TC-SEL-06

    def test_booking_past_date_shows_error(self, driver):
        self._open_first_car(driver)
        self._fill_booking_form(
            driver,
            (date.today() - timedelta(days=1)).isoformat(),
            (date.today() + timedelta(days=1)).isoformat(),
        )
        driver.find_element(By.CSS_SELECTOR, "form button[type=submit]").click()

        error = WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, ".bg-red-50"))
        )
        assert error.is_displayed()  # TC-SEL-07

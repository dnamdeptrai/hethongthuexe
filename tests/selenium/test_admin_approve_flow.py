from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select, WebDriverWait

from conftest import BASE_URL


class TestAdminApproveFlow:
    ADMIN_EMAIL = "admin@gmail.com"
    ADMIN_PASSWORD = "Admin@1234"

    def _login(self, driver, email, password, expected_path):
        driver.get(f"{BASE_URL}/login")
        driver.find_element(By.NAME, "email").send_keys(email)
        driver.find_element(By.NAME, "password").send_keys(password)
        driver.find_element(By.CSS_SELECTOR, "button[type=submit]").click()
        WebDriverWait(driver, 10).until(EC.url_contains(expected_path))

    def test_admin_can_approve_pending_booking(self, driver):
        self._login(
            driver,
            self.ADMIN_EMAIL,
            self.ADMIN_PASSWORD,
            "/admin/dashboard",
        )
        driver.get(f"{BASE_URL}/admin/bookings")
        status_select = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "select.status-select"))
        )
        Select(status_select).select_by_value("confirmed")

        confirmed_badge = WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, ".badge-confirmed"))
        )
        assert confirmed_badge.is_displayed()  # TC-SEL-08

    def test_user_cannot_access_admin_page(self, driver):
        self._login(
            driver,
            "testuser@gmail.com",
            "Test@1234",
            "/dashboard",
        )
        driver.get(f"{BASE_URL}/admin/dashboard")
        WebDriverWait(driver, 10).until_not(EC.url_contains("/admin/dashboard"))

        assert "/admin/dashboard" not in driver.current_url  # TC-SEL-09

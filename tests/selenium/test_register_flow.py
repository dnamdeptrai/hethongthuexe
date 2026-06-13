import uuid

from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait

from conftest import BASE_URL


class TestRegisterFlow:
    def test_register_valid_user(self, driver):
        driver.get(f"{BASE_URL}/register")
        driver.find_element(By.NAME, "name").send_keys("Selenium User")
        driver.find_element(By.NAME, "email").send_keys(
            f"selenium-{uuid.uuid4().hex}@example.com"
        )
        driver.find_element(By.NAME, "password").send_keys("Test@1234")
        driver.find_element(By.NAME, "password_confirmation").send_keys("Test@1234")
        driver.find_element(By.CSS_SELECTOR, "button[type=submit]").click()

        WebDriverWait(driver, 10).until(EC.url_contains("/dashboard"))
        assert "/dashboard" in driver.current_url  # TC-SEL-01

    def test_register_duplicate_email(self, driver):
        driver.get(f"{BASE_URL}/register")
        driver.find_element(By.NAME, "name").send_keys("Duplicate User")
        driver.find_element(By.NAME, "email").send_keys("admin@gmail.com")
        driver.find_element(By.NAME, "password").send_keys("Test@1234")
        driver.find_element(By.NAME, "password_confirmation").send_keys("Test@1234")
        driver.find_element(By.CSS_SELECTOR, "button[type=submit]").click()

        error = WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "ul.text-sm"))
        )
        assert "/register" in driver.current_url
        assert error.is_displayed()  # TC-SEL-02

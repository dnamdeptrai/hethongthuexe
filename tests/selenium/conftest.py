import os

import pytest
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

BASE_URL = os.getenv("SELENIUM_BASE_URL", "http://127.0.0.1:8000").rstrip("/")


@pytest.fixture(scope="function")
def driver():
    options = Options()
    options.add_argument("--headless=new")
    options.add_argument("--no-sandbox")
    options.add_argument("--disable-dev-shm-usage")
    options.add_argument("--window-size=1920,1080")

    browser = webdriver.Chrome(
        service=Service(ChromeDriverManager().install()),
        options=options,
    )
    browser.implicitly_wait(5)
    yield browser
    browser.quit()

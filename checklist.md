# Checklist sinh code — Chương 4, 5, 6 (Car Rental - Laravel)

> Mục đích: liệt kê các phần đã có pseudocode/code mẫu trong tài liệu, để Codex
> đối chiếu với repo thực tế và sinh code thật (service, test, selenium) tương ứng.
> Mỗi mục cần: kiểm tra method/route đã tồn tại trong repo chưa → tạo/sửa cho khớp
> → viết test theo đúng tên/test case ID đã liệt kê trong tài liệu.

---

## A. CHƯƠNG 4 — Logic nghiệp vụ cần đối chiếu (làm nền cho Chương 5)

> Chương 4 chỉ có pseudocode mô tả logic, chưa phải code thật. Codex cần tìm
> các hàm tương ứng trong repo (BookingService / AuthController / Car model...)
> và đảm bảo logic khớp với pseudocode dưới đây trước khi viết test ở mục B.

### A.1. `validateBooking($data)` — RQ07
Pseudocode (4.3.1):
```php
function validateBooking($data): array {
  $errors = [];
  $today  = Carbon::today();

  if ($data['check_in_date'] < $today) {
    $errors[] = 'Ngày nhận xe phải >= ngày hôm nay';
  }
  if ($data['check_out_date'] <= $data['check_in_date']) {
    $errors[] = 'Ngày trả xe phải sau ngày nhận';
  }
  $phone = $data['phone'];
  if (!preg_match('/^[0-9]{9,11}$/', $phone)) {
    $errors[] = 'Số điện thoại phải từ 9 đến 11 chữ số';
  }
  $car = Car::findOrFail($data['car_id']);
  if ($car->status !== 'available') {
    $errors[] = 'Xe đã được đặt hoặc đang bảo dưỡng';
  }
  return $errors;
}
```
- [ ] Tìm hàm validate tương đương trong `BookingController`/`StoreBookingRequest`/`BookingService`.
- [ ] Đảm bảo 4 điều kiện rẽ nhánh trên có mặt: check_in < today, check_out <= check_in, phone regex `^[0-9]{9,11}$`, car->status !== 'available'.
- [ ] Nếu thiếu, bổ sung validate rule/logic tương ứng (không phá vỡ hành vi hiện có).

### A.2. `authenticate($request)` — RQ02
Pseudocode (4.4.1):
```php
function authenticate($request): RedirectResponse {
  $email    = $request->input('email');
  $password = $request->input('password');

  $user = User::where('email', $email)->first();
  if (!$user) {
    return redirect()->back()->withErrors(['msg' => 'Tài khoản không tồn tại']);
  }
  if (!Hash::check($password, $user->password)) {
    return redirect()->back()->withErrors(['msg' => 'Mật khẩu không chính xác']);
  }

  Auth::login($user);
  if ($user->role === 'admin') {
    return redirect('/admin/dashboard');
  }
  return redirect('/dashboard');
}
```
- [ ] Đối chiếu `AuthController::login` (hoặc tương đương) trong repo với 4 nhánh trên.
- [ ] Đảm bảo redirect đúng theo role: `admin` → `/admin/dashboard`, `user` → `/dashboard`.

### A.3. `calculateTotalPrice($checkIn, $checkOut, $pricePerDay)` — RQ07
Pseudocode (4.5.1):
```php
function calculateTotalPrice($checkIn, $checkOut, $pricePerDay): int|false {
  $checkInDate  = Carbon::parse($checkIn);
  $checkOutDate = Carbon::parse($checkOut);

  if ($checkOutDate <= $checkInDate) {
    return false;
  }
  if ($pricePerDay <= 0) {
    return false;
  }
  $days = $checkInDate->diffInDays($checkOutDate);
  $total = $days * $pricePerDay;
  return $total;
}
```
- [ ] Tạo/kiểm tra hàm `calculateTotalPrice` trong `App\Services\BookingService` với đúng 2 guard clause trên (checkOut <= checkIn → false; pricePerDay <= 0 → false).
- [ ] Đảm bảo trả về `int` = số ngày × giá/ngày khi hợp lệ.

### A.4. `validatePhone($phone)` (suy ra từ test case Chương 5, mục 5.4.1)
- [ ] Đảm bảo `BookingService` có method `validatePhone(string $phone): bool` dùng regex `^[0-9]{9,11}$` (9–11 số), vì các test ở mục B.1 gọi trực tiếp `$this->service->validatePhone(...)`.

---

## B. CHƯƠNG 5 — PHPUnit Test Scripts (code thật, copy gần như nguyên bản)

### B.0. Cấu hình môi trường

- [ ] Đảm bảo `composer.json` có `phpunit/phpunit` trong `require-dev` (>= 10.x).
- [ ] Cài/Kiểm tra Xdebug mode `coverage` để chạy `--coverage`.
- [ ] Tạo/cập nhật `phpunit.xml` ở root project theo nội dung (5.2.3):
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
         stopOnFailure="false">
  <testsuites>
    <testsuite name="Unit">
      <directory suffix="Test.php">./tests/Unit</directory>
    </testsuite>
    <testsuite name="Feature">
      <directory suffix="Test.php">./tests/Feature</directory>
    </testsuite>
  </testsuites>
  <coverage>
    <include>
      <directory suffix=".php">./app</directory>
    </include>
    <report>
      <html outputDirectory="coverage-report"/>
      <clover outputFile="coverage.xml"/>
    </report>
  </coverage>
  <php>
    <env name="APP_ENV"     value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE"   value=":memory:"/>
    <env name="BCRYPT_ROUNDS" value="4"/>
    <env name="CACHE_DRIVER"  value="array"/>
    <env name="SESSION_DRIVER" value="array"/>
  </php>
</phpunit>
```
- [ ] Đảm bảo cấu trúc thư mục `tests/Unit` và `tests/Feature` tồn tại theo sơ đồ mục 5.3 (tạo file còn thiếu, có thể để rỗng/stub nếu chưa nằm trong phạm vi yêu cầu, nhưng các file ở B.1–B.3 dưới đây **phải** được tạo đầy đủ).

### B.1. `tests/Unit/BookingServiceTest.php` (5.4.1)

- [ ] Tạo class `Tests\Unit\BookingServiceTest extends TestCase`, property `private BookingService $service;`, `setUp()` khởi tạo `new BookingService()`.
- [ ] Test case `test_calculateTotalPrice_valid_3days` (TC-WB-P1): checkIn = today, checkOut = today+3, price=500000 → assertEquals(1500000, $result).
- [ ] Test case `test_calculateTotalPrice_invalid_dates` (TC-WB-P2): checkIn = today+3, checkOut = today+1, price=500000 → assertFalse($result).
- [ ] Test case `test_calculateTotalPrice_BVA_same_date` (TC-WB-P3): checkIn = checkOut = today, price=500000 → assertFalse($result).
- [ ] Test case `test_calculateTotalPrice_BVA_zero_price` (TC-WB-P4): checkIn=today, checkOut=today+3, price=0 → assertFalse($result).
- [ ] Test case `test_validatePhone_8digits_invalid` (TC-BB-RQ07-05): `validatePhone('09123456')` → assertFalse.
- [ ] Test case `test_validatePhone_9digits_valid`: `validatePhone('091234567')` → assertTrue.
- [ ] Test case `test_validatePhone_11digits_valid`: `validatePhone('09123456789')` → assertTrue.
- [ ] Test case `test_validatePhone_12digits_invalid` (TC-BB-RQ07-06): `validatePhone('091234567890')` → assertFalse.

Toàn bộ nội dung file tham khảo nguyên văn từ tài liệu (mục 5.4.1, dòng 88–166).

### B.2. `tests/Feature/RegisterTest.php` (5.4.2, RQ01)

- [ ] Tạo class `Tests\Feature\RegisterTest extends TestCase`, `use RefreshDatabase`.
- [ ] `test_register_with_valid_data` (TC-RQ01-01): POST `/register` với name/email/password hợp lệ → `assertRedirect('/dashboard')` + `assertDatabaseHas('users', ['email' => ...])`.
- [ ] `test_register_with_invalid_email_format` (TC-RQ01-02): email = `'tangmail.com'` → `assertSessionHasErrors('email')` + `assertDatabaseMissing('users', ...)`.
- [ ] `test_register_with_duplicate_email` (TC-RQ01-03): tạo user với email `existed@gmail.com` qua factory, sau đó POST `/register` cùng email → `assertSessionHasErrors('email')`.
- [ ] `test_register_password_below_minimum` (TC-RQ01-04): password = `'Ab1@23'` (6 ký tự) → `assertSessionHasErrors('password')`.
- [ ] `test_register_password_confirmation_mismatch` (TC-RQ01-05): password ≠ password_confirmation → `assertSessionHasErrors('password')`.

Đối chiếu route `/register` và field names (`name`, `email`, `password`, `password_confirmation`) với repo thực tế; sửa nếu khác.

### B.3. `tests/Feature/BookingTest.php` (5.4.3, RQ07)

- [ ] Tạo class `Tests\Feature\BookingTest extends TestCase`, `use RefreshDatabase`.
- [ ] `setUp()`: tạo `$this->user = User::factory()->create(['role' => 'user'])` và `$this->car = Car::factory()->create(['status' => 'available', 'price_per_day' => 500000])`.
- [ ] `test_booking_valid_3days` (TC-RQ07-01): POST `/bookings` (actingAs user) với car_id, driver_name, phone='0912345678', check_in=today, check_out=today+3 → `assertRedirect()` + `assertDatabaseHas('bookings', ['car_id'=>..., 'status'=>'pending', 'total_price'=>1500000])`.
- [ ] `test_booking_checkin_in_past` (TC-RQ07-02): check_in_date = yesterday, check_out_date = tomorrow → `assertSessionHasErrors('check_in_date')` + `assertDatabaseCount('bookings', 0)`.
- [ ] `test_booking_checkout_equals_checkin_BVA` (TC-RQ07-03): check_in_date = check_out_date = today → `assertSessionHasErrors('check_out_date')`.
- [ ] `test_booking_phone_below_minimum_BVA` (TC-RQ07-05): phone = `'09123456'` (8 số) → `assertSessionHasErrors('phone')`.

Đối chiếu route `/bookings`, tên các field (`car_id`, `driver_name`, `phone`, `check_in_date`, `check_out_date`), cấu trúc bảng `bookings` (`status`, `total_price`) với repo thực tế; sửa nếu khác.

### B.4. (Tham khảo — chưa có pseudocode đầy đủ, chỉ liệt kê trong cấu trúc thư mục 5.3)
Các file sau **không có code mẫu** trong tài liệu (chỉ được liệt kê tên), nên KHÔNG bắt buộc theo checklist này, nhưng nên kiểm tra nếu đã tồn tại trong repo: `AuthServiceTest.php`, `CarServiceTest.php`, `LoginTest.php`, `AdminDashboardTest.php`, `ContactTest.php`.

---

## C. CHƯƠNG 6 — Selenium WebDriver (Python) Test Scripts

### C.0. Cấu hình môi trường & conftest

- [ ] Tạo `requirements` / cài đặt: `pip install selenium webdriver-manager pytest`.
- [ ] Tạo `tests/selenium/conftest.py` theo nội dung (6.2.2):
```python
# tests/selenium/conftest.py
import pytest
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.chrome.service import Service

BASE_URL = 'https://carento.up.railway.app'

@pytest.fixture(scope='function')
def driver():
    options = Options()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    options.add_argument('--window-size=1920,1080')
    drv = webdriver.Chrome(
        service=Service(ChromeDriverManager().install()),
        options=options
    )
    drv.implicitly_wait(10)
    yield drv
    drv.quit()
```
- [ ] Xác nhận `BASE_URL` đúng với domain Railway hiện tại của repo (cập nhật nếu khác `carento.up.railway.app`).

### C.1. `tests/selenium/test_register_flow.py` (6.3, RQ01)

- [ ] Tạo class `TestRegisterFlow`.
- [ ] `test_register_valid_user` (TC-SEL-01):
  - GET `{BASE_URL}/register`
  - Điền `name`, `email` (random unique qua `uuid`), `password='Test@1234'`, `password_confirmation='Test@1234'`
  - Click `button[type=submit]`
  - `WebDriverWait` đến khi URL chứa `/dashboard`, assert `'/dashboard' in driver.current_url`
  - assert không có element `.alert-error, .text-red-500`
- [ ] `test_register_duplicate_email` (TC-SEL-02 / TC-RQ01-03):
  - GET `/register`, điền email = `'admin@gmail.com'` (đã tồn tại)
  - Submit, `time.sleep(1)`, assert vẫn ở `/register`
  - `WebDriverWait` cho element `.text-red-500, [role=alert]` xuất hiện và `is_displayed()`

Đối chiếu selector CSS (`button[type=submit]`, `.alert-error`, `.text-red-500`, `[role=alert]`) và field `name="email"`, `name="password"`, `name="password_confirmation"` với HTML thực tế của trang `/register` trong repo.

### C.2. `tests/selenium/test_booking_flow.py` (6.4, RQ07)

- [ ] Tạo class `TestBookingFlow` với hằng `USER_EMAIL = 'testuser@gmail.com'`, `USER_PASSWORD = 'Test@1234'`.
- [ ] Helper `_login(self, driver)`: GET `/login`, điền email/password, click submit, wait URL chứa `/dashboard`.
- [ ] `test_book_car_valid_3days` (TC-SEL-06):
  - Login trước
  - GET `/cars`, click element đầu tiên matching `.car-card a, a[href*="/xe/"]`
  - Click nút `button.book-now, a[href*="booking"]`
  - Điền `driver_name='Nguyen Van A'`, `phone='0912345678'`
  - Set `check_in_date` = today, `check_out_date` = today+3 qua `execute_script`
  - Submit form
  - Wait & assert element `.alert-success, .toast-success` hiển thị
- [ ] `test_booking_past_date_shows_error` (TC-SEL-07 / TC-RQ07-02):
  - Login, GET `/cars/1/book`
  - Điền `driver_name='Test User'`, `phone='0912345678'`
  - Set `check_in_date` = yesterday, `check_out_date` = tomorrow qua `execute_script`
  - Submit
  - Wait & assert element `.text-red-500, .error-msg` hiển thị

Đối chiếu các route (`/cars`, `/cars/1/book`, `/bookings`), selector (`.car-card a`, `a[href*="/xe/"]`, `button.book-now`, `a[href*="booking"]`, `.alert-success`, `.toast-success`, `.text-red-500`, `.error-msg`) và tên field input (`driver_name`, `phone`, `check_in_date`, `check_out_date`) với repo thực tế.

### C.3. `tests/selenium/test_admin_approve_flow.py` (6.5, RQ13)

- [ ] Tạo class `TestAdminApproveFlow` với hằng `ADMIN_EMAIL = 'admin@gmail.com'`, `ADMIN_PASSWORD = 'Admin@1234'`.
- [ ] Helper `_admin_login(self, driver)`: GET `/login`, điền admin email/password, submit, wait URL chứa `/admin/dashboard`.
- [ ] `test_admin_can_approve_pending_booking` (TC-SEL-08 / TC-RQ13-01):
  - Admin login
  - GET `/admin/bookings`
  - Wait element clickable `.booking-pending .btn-approve, button[data-action="approve"]`
  - Lấy `booking_row` qua `find_element(By.XPATH, './ancestor::tr')` (nếu cần dùng để debug/log)
  - Click approve
  - Wait `.status-badge` chứa text `'approved'`
  - assert `'approved' in status_badge.text.lower()`
- [ ] `test_user_cannot_access_admin_page` (TC-SEL-09 / TC-RQ13-04):
  - Login bằng `user@gmail.com` / `Test@1234`, wait URL chứa `/dashboard`
  - GET `/admin/dashboard` (cố tình truy cập)
  - `time.sleep(2)`, assert `'/admin/dashboard' not in driver.current_url`

Đối chiếu route `/admin/bookings`, `/admin/dashboard`, selector `.booking-pending .btn-approve`, `button[data-action="approve"]`, `.status-badge`, và middleware chặn user thường khỏi `/admin/*` với repo thực tế (đảm bảo middleware redirect ra khỏi `/admin/dashboard`).

### C.4. (Tham khảo — chưa có code mẫu trong tài liệu)
Các file `test_login_flow.py` và `test_contact_flow.py` được nhắc đến trong bảng kết quả (6.6) với các TC-SEL-03 → 05 và TC-SEL-10/11 nhưng **không có pseudocode/code mẫu** trong tài liệu — không thuộc phạm vi checklist này (có thể tạo theo cùng pattern của C.1–C.3 nếu được yêu cầu thêm sau).

---

## D. Lệnh chạy test (đối chiếu CI/script trong repo)

- [ ] Đảm bảo các script/lệnh sau hoạt động (5.5.1):
```bash
php artisan test
php artisan test --verbose
php artisan test --coverage
XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html coverage-report/
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
php artisan test tests/Feature/BookingTest.php
```
- [ ] Selenium: đảm bảo `pytest tests/selenium/` chạy được với conftest ở mục C.0.

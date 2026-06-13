# Hướng dẫn chèn code thật vào ĐẠI-HỌC-PHENIKAA.docx

Tài liệu đối chiếu: `D:\University Stuff Season 15\DanhGiaKiemDinh\ĐẠI-HỌC-PHENIKAA.docx`

Project đối chiếu: thư mục `hethongthuexe`

Ngày đối chiếu: 13/06/2026

## 1. Cách sử dụng hướng dẫn

1. Mở file DOCX bằng Microsoft Word.
2. Nhấn `Ctrl + F` và tìm đúng **câu mốc** được ghi trong từng mục bên dưới.
3. Xóa đoạn pseudocode/code mẫu nằm ngay sau câu mốc.
4. Dán code từ đúng file project được chỉ định.
5. Nếu báo cáo yêu cầu code dưới dạng hình ảnh, chụp đoạn code thật trong IDE rồi chèn ảnh vào đúng vị trí đó.
6. Không dùng các số trang 71-99 đang lưu trong cấu trúc nội bộ cũ của DOCX. File hiện tại được Word dàn thành **80 trang**; số trang đúng khi mở Word được ghi trong hướng dẫn này.

## 2. Bản đồ vị trí cần thay

| Trang Word hiện tại | Mục trong DOCX | Câu mốc cần tìm | Code thật cần dùng |
|---:|---|---|---|
| 51 | 4.3.1 | `function validateBooking($data): array` | `app/Http/Controllers/BookingController.php`, method `store()` |
| 55 | 4.4.1 | `function authenticate($request): RedirectResponse` | `app/Http/Requests/Auth/LoginRequest.php` và `AuthenticatedSessionController.php` |
| 57 | 4.5.1 | `function calculateTotalPrice` | `app/Services/BookingService.php` |
| 61 | 5.2.3 | `Cấu hình file phpunit.xml` | `phpunit.xml` |
| 62 | 5.3 | `Cấu trúc thư mục và tổ chức Test Suite` | Cây thư mục thật trong `tests/` |
| 63 | 5.4.1 | `Unit Test - BookingServiceTest.php` | `tests/Unit/BookingServiceTest.php` |
| 65 | 5.4.2 | `Feature Test - RegisterTest.php` | `tests/Feature/RegisterTest.php` |
| 67 | 5.4.3 | `Feature Test - BookingTest.php` | `tests/Feature/BookingTest.php` |
| 69 | 5.5 | `Thực thi kiểm thử và kết quả chạy test` | Ảnh terminal chạy PHPUnit thật |
| 70 | 5.6 | `Kết quả đo độ bao phủ mã nguồn` | Báo cáo coverage thật |
| 72 | 6.2.2 | `Cấu hình base class cho test suite` | `tests/selenium/conftest.py` |
| 73 | 6.3 | `test_register_flow.py` | `tests/selenium/test_register_flow.py` |
| 74 | 6.4 | `test_booking_flow.py` | `tests/selenium/test_booking_flow.py` |
| 77 | 6.5 | `test_admin_approve_flow.py` | `tests/selenium/test_admin_approve_flow.py` |
| 78 | 6.6 | `Tổng hợp kết quả thực thi Selenium Test Suite` | Ảnh terminal chạy pytest thật |

---

## 3. Chương IV - Kiểm thử hộp trắng

### 3.1. Mục 4.3.1 - Logic kiểm tra booking

**Vị trí trong DOCX**

- Trang Word: 51-52.
- Tìm: `4.3.1. Mã nguồn giả định`.
- Block bắt đầu bằng: `function validateBooking($data): array`.
- Block kết thúc ngay trước dòng: `//ĐOẠN CODE TRÊN CẦN THAY BẰNG HÌNH ẢNH`.

**Thao tác**

Thay toàn bộ pseudocode trên bằng ảnh hoặc code thật của:

```text
app/Http/Controllers/BookingController.php
```

Chụp method `store()` từ dòng 18 đến dòng 66. Đây là code thật chứa đủ các nhánh:

- `start_date` phải từ ngày hiện tại trở đi.
- `end_date` phải sau `start_date`.
- `phone` phải có 9-11 chữ số.
- xe phải có `status = available`.
- gọi `BookingService::calculateTotalPrice()`.
- tạo booking có trạng thái `pending`.

**Nội dung mô tả cần sửa**

Trong DOCX hiện ghi có hàm riêng `validateBooking()`. Project thật **không có method mang tên này**. Validation được thực hiện trực tiếp trong:

```php
BookingController::store(Request $request)
```

Nên sửa câu:

> Hàm validateBooking() trong Controller BookingController...

thành:

> Logic kiểm tra booking được cài đặt trực tiếp trong method `BookingController::store()`, sử dụng Laravel Validation kết hợp truy vấn trạng thái xe trước khi tạo đơn.

**Lưu ý về CFG**

CFG hiện tại được vẽ theo pseudocode trả về một mảng lỗi. Code thật dùng Laravel Validation và trả redirect khi xe không khả dụng, nên số node/path của CFG cũ không còn khớp hoàn toàn. Nếu giữ CFG cũ, phải ghi rõ đây là **CFG mô hình hóa logic nghiệp vụ**, không phải CFG được trích nguyên dạng từ method thật.

### 3.2. Mục 4.4.1 - Logic đăng nhập

**Vị trí trong DOCX**

- Trang Word: 55.
- Tìm: `4.4.1. Mã nguồn giả định`.
- Block bắt đầu bằng: `function authenticate($request): RedirectResponse`.
- Block kết thúc trước dòng yêu cầu thay bằng hình ảnh.

**Code thật phải chèn thành hai ảnh hoặc hai block**

Block 1 - xác thực email/password:

```text
app/Http/Requests/Auth/LoginRequest.php
```

Chụp method `authenticate()` từ dòng 41 đến dòng 54. Project thật sử dụng:

```php
Auth::attempt(...)
```

và ném `ValidationException` khi thông tin đăng nhập sai.

Block 2 - điều hướng theo role:

```text
app/Http/Controllers/Auth/AuthenticatedSessionController.php
```

Chụp method `store()` từ dòng 19 đến dòng 29. Nhánh thật là:

- `admin` chuyển tới route `admin.dashboard`.
- user thường chuyển tới route `client.dashboard`.

**Nội dung mô tả cần sửa**

Không ghi `AuthController::login`, vì project không có controller này. Hãy đổi thành:

> Luồng đăng nhập được chia thành `LoginRequest::authenticate()` để kiểm tra thông tin xác thực và `AuthenticatedSessionController::store()` để tái tạo session, phân quyền và chuyển hướng.

Thông báo sai email và sai mật khẩu trong code thật đều đi qua lỗi chuẩn `auth.failed`; chúng không phải hai thông báo riêng như pseudocode hiện tại.

### 3.3. Mục 4.5.1 - Hàm tính tổng giá thuê

**Vị trí trong DOCX**

- Trang Word: 57.
- Tìm: `4.5.1. Mã nguồn giả định`.
- Xóa block pseudocode bắt đầu bằng `function calculateTotalPrice`.

**Code thật cần chèn**

```text
app/Services/BookingService.php
```

Chụp toàn bộ file, hoặc ít nhất dòng 8-29. Trong đó:

- dòng 10-23: `calculateTotalPrice()`;
- dòng 25-28: `validatePhone()`.

Code thật gộp hai guard clause trong cùng một biểu thức:

```php
if ($checkOutDate->lessThanOrEqualTo($checkInDate) || $pricePerDay <= 0)
```

Vì vậy CFG hiện tại đang mô tả hai `if` tách biệt. Nếu muốn số liệu Cyclomatic bám chính xác code thật, cần vẽ lại CFG theo biểu thức `OR`; nếu chỉ dùng CFG để diễn giải nghiệp vụ, thêm chú thích rằng hai điều kiện được biểu diễn tách ra để dễ phân tích.

---

## 4. Chương V - PHPUnit

### 4.1. Mục 5.2.1 - Sửa phiên bản môi trường

DOCX đang ghi PHP 8.1, Laravel 10 và PHPUnit 10. Project thật trong `composer.json` dùng:

```text
PHP: ^8.4
Laravel Framework: ^13.8
PHPUnit: ^12.5.12
```

Hãy thay các phiên bản tại trang 61 để báo cáo khớp project.

### 4.2. Mục 5.2.3 - Cấu hình PHPUnit

**Vị trí**

- Trang Word: 61-62.
- Tìm: `5.2.3. Cấu hình file phpunit.xml`.

Thay toàn bộ XML mẫu bằng nội dung thật của:

```text
phpunit.xml
```

Không dùng cấu trúc `<coverage>` theo mẫu PHPUnit 10. Project PHPUnit 12 đang dùng:

```xml
<source>
    <include>
        <directory>app</directory>
    </include>
</source>
```

### 4.3. Mục 5.3 - Cây thư mục test

**Vị trí**

- Trang Word: 62.
- Tìm: `5.3. Cấu trúc thư mục và tổ chức Test Suite`.

Thay cây thư mục mẫu bằng cây tối thiểu sau:

```text
tests/
├── Feature/
│   ├── Auth/
│   │   ├── AuthenticationTest.php
│   │   ├── EmailVerificationTest.php
│   │   ├── PasswordConfirmationTest.php
│   │   ├── PasswordResetTest.php
│   │   ├── PasswordUpdateTest.php
│   │   └── RegistrationTest.php
│   ├── BookingTest.php
│   ├── ProfileTest.php
│   └── RegisterTest.php
├── Unit/
│   └── BookingServiceTest.php
├── selenium/
│   ├── conftest.py
│   ├── requirements.txt
│   ├── test_admin_approve_flow.py
│   ├── test_booking_flow.py
│   └── test_register_flow.py
└── TestCase.php
```

Các file `AuthServiceTest.php`, `CarServiceTest.php`, `LoginTest.php`, `AdminDashboardTest.php` và `ContactTest.php` đang xuất hiện trong DOCX nhưng **không tồn tại trong project hiện tại**. Không trình bày chúng như code đã hoàn thành.

### 4.4. Mục 5.4.1 - BookingServiceTest

**Vị trí**

- Trang Word: 63-65.
- Tìm: `5.4.1. Unit Test - BookingServiceTest.php`.
- Thay toàn bộ class code mẫu.

**Nguồn code thật**

```text
tests/Unit/BookingServiceTest.php
```

Dán toàn bộ file dòng 1-83. File thật có đủ 8 test:

- `test_calculateTotalPrice_valid_3days`
- `test_calculateTotalPrice_invalid_dates`
- `test_calculateTotalPrice_BVA_same_date`
- `test_calculateTotalPrice_BVA_zero_price`
- `test_validatePhone_8digits_invalid`
- `test_validatePhone_9digits_valid`
- `test_validatePhone_11digits_valid`
- `test_validatePhone_12digits_invalid`

### 4.5. Mục 5.4.2 - RegisterTest

**Vị trí**

- Trang Word: 65-67.
- Tìm: `5.4.2. Feature Test - RegisterTest.php`.

**Nguồn code thật**

```text
tests/Feature/RegisterTest.php
```

Dán toàn bộ file dòng 1-76. Route thật vẫn là `/register`, nhưng email test hợp lệ trong code hiện tại là:

```text
nguyenvana@example.com
```

### 4.6. Mục 5.4.3 - BookingTest

**Vị trí**

- Trang Word: 67-69.
- Tìm: `5.4.3. Feature Test - BookingTest.php`.

**Nguồn code thật**

```text
tests/Feature/BookingTest.php
```

Dán toàn bộ file dòng 1-96.

Các khác biệt bắt buộc phải giữ theo project thật:

| Nội dung | Mẫu trong DOCX | Project thật |
|---|---|---|
| Route POST booking | `/bookings` | `/dat-xe` |
| Ngày nhận | `check_in_date` | `start_date` |
| Ngày trả | `check_out_date` | `end_date` |
| Người lái | `driver_name` | `driver_name` |
| Điện thoại | `phone` | `phone` |
| Xe không khả dụng | chưa có test đầy đủ | `test_booking_unavailable_car_is_rejected` |

Để chứng minh dữ liệu test được tạo đúng, có thể chèn thêm vào phụ lục:

```text
database/factories/CarFactory.php
database/factories/CategoryFactory.php
database/migrations/2026_06_13_000000_add_driver_details_to_bookings_table.php
```

### 4.7. Mục 5.5 - Kết quả PHPUnit

**Vị trí**

- Trang Word: 69-70.
- Tìm: `5.5. Thực thi kiểm thử và kết quả chạy test`.

DOCX hiện ghi:

```text
27 passed (54 assertions)
Duration: 2.14s
```

Đây không phải kết quả đã được xác minh từ project trong môi trường hiện tại. Máy đối chiếu chưa có PHP, Composer và thư mục `vendor`, nên không được giữ số liệu này như bằng chứng thật.

Sau khi cài môi trường, chạy:

```bash
composer install
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
php artisan test
```

Sau đó chụp terminal và thay toàn bộ block kết quả mẫu bằng ảnh kết quả thực tế.

### 4.8. Mục 5.6 - Code Coverage

**Vị trí**

- Trang Word: 70-71.
- Tìm: `5.6. Kết quả đo độ bao phủ mã nguồn`.

Các số `92.3%`, `87.1%`, `253/274` hiện chưa được chứng minh bằng báo cáo coverage thật. Chỉ giữ các số này nếu file coverage thực tế cho đúng kết quả.

Chạy:

```bash
XDEBUG_MODE=coverage php artisan test --coverage
```

Hoặc:

```bash
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html coverage-report
```

Chèn ảnh terminal và ảnh trang tổng quan trong `coverage-report/index.html`.

---

## 5. Chương VI - Selenium WebDriver

### 5.1. Mục 6.2.1 - Cài dependencies

**Vị trí**

- Trang Word: 72.
- Tìm: `6.2.1. Cài đặt môi trường`.

Project đã có file:

```text
tests/selenium/requirements.txt
```

Nên thay câu lệnh cài rời bằng:

```bash
pip install -r tests/selenium/requirements.txt
```

### 5.2. Mục 6.2.2 - conftest.py

**Vị trí**

- Trang Word: 72-73.
- Tìm: `# tests/selenium/conftest.py`.

Thay toàn bộ code mẫu bằng:

```text
tests/selenium/conftest.py
```

Dán dòng 1-26.

Điểm khác quan trọng:

- Không hard-code `https://carento.up.railway.app`.
- Code thật đọc biến môi trường `SELENIUM_BASE_URL`.
- Giá trị mặc định là `http://127.0.0.1:8000`.
- Chrome chạy với `--headless=new`.

Khi test bản deploy:

```powershell
$env:SELENIUM_BASE_URL='https://ten-mien-deploy-thuc-te'
pytest tests/selenium/
```

### 5.3. Mục 6.3 - Đăng ký

**Vị trí**

- Trang Word: 73-74.
- Tìm: `# tests/selenium/test_register_flow.py`.

Thay toàn bộ block bằng:

```text
tests/selenium/test_register_flow.py
```

Dán dòng 1-36. Selector lỗi thật là:

```css
ul.text-sm
```

không phải `.alert-error`, `.text-red-500` hoặc `[role=alert]` như code mẫu.

### 5.4. Mục 6.4 - Đặt xe

**Vị trí**

- Trang Word: 74-77.
- Tìm: `# tests/selenium/test_booking_flow.py`.

Thay toàn bộ block bằng:

```text
tests/selenium/test_booking_flow.py
```

Dán dòng 1-65.

Các điểm phải sửa trong phần mô tả DOCX:

- Không có route `/cars`; danh sách xe nằm tại `/dashboard`.
- Chi tiết xe dùng `/xe/{id}`.
- Không có route `/cars/1/book`.
- Form đặt xe nằm trực tiếp trong trang chi tiết xe.
- Field thật là `start_date` và `end_date`.
- Thành công chuyển tới `/thanh-toan/{id}`, không chờ `.toast-success`.
- Ngày được đặt qua instance Flatpickr của input.

### 5.5. Mục 6.5 - Admin duyệt đơn

**Vị trí**

- Trang Word: 77-78.
- Tìm: `# tests/selenium/test_admin_approve_flow.py`.

Thay toàn bộ block bằng:

```text
tests/selenium/test_admin_approve_flow.py
```

Dán dòng 1-47.

Project thật không có nút `.btn-approve`. Admin thay trạng thái bằng:

```css
select.status-select
```

Giá trị duyệt đơn là:

```text
confirmed
```

Badge kết quả là:

```css
.badge-confirmed
```

không phải trạng thái `approved` và `.status-badge` như DOCX đang ghi.

### 5.6. Mục 6.6 - Kết quả Selenium

**Vị trí**

- Trang Word: 78-80.
- Tìm: `6.6. Tổng hợp kết quả thực thi Selenium Test Suite`.

DOCX hiện kết luận có 11 Selenium test đều PASS trong 36,2 giây. Project hiện chỉ có 6 method Selenium:

```text
test_register_valid_user
test_register_duplicate_email
test_book_car_valid_3days
test_booking_past_date_shows_error
test_admin_can_approve_pending_booking
test_user_cannot_access_admin_page
```

Không ghi 11 test PASS khi chưa có `test_login_flow.py` và `test_contact_flow.py`.

Chạy thật:

```bash
pytest tests/selenium/ -v
```

Sau đó:

- thay bảng kết quả bằng đúng số test đã chạy;
- thay thời gian bằng thời gian terminal thực tế;
- chèn ảnh terminal pytest;
- ghi rõ URL localhost hoặc URL deploy đã dùng.

---

## 6. Những chỗ không nên tuyên bố là kết quả thật

Các nội dung sau trong DOCX hiện là số liệu mẫu hoặc chưa được xác minh:

1. `27 passed (54 assertions)`.
2. Coverage tổng `92.3%` và Branch Coverage `87.1%`.
3. `App\Services\BookingService 34/34 lines`.
4. 11 Selenium test đều PASS.
5. Tổng thời gian Selenium `36.2 giây`.
6. Domain Railway `carento.up.railway.app` vẫn còn hoạt động.

Chỉ giữ các nội dung này sau khi có ảnh terminal, báo cáo coverage hoặc kết quả truy cập domain thật.

## 7. Thứ tự ảnh code nên chèn

Để báo cáo dễ kiểm tra, đặt caption ảnh theo thứ tự:

1. `BookingController::store()` - validation và tạo booking.
2. `LoginRequest::authenticate()` - xác thực tài khoản.
3. `AuthenticatedSessionController::store()` - phân quyền redirect.
4. `BookingService::calculateTotalPrice()` và `validatePhone()`.
5. `phpunit.xml`.
6. `BookingServiceTest.php`.
7. `RegisterTest.php`.
8. `BookingTest.php`.
9. Kết quả PHPUnit thật.
10. Báo cáo coverage thật.
11. `conftest.py`.
12. `test_register_flow.py`.
13. `test_booking_flow.py`.
14. `test_admin_approve_flow.py`.
15. Kết quả pytest thật.

Mỗi ảnh nên hiển thị tên file trong tab IDE và không cắt mất tên class/method.

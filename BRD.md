Dưới đây là bản BRD đã **thay “Nhân viên (Staff)” → “Khách hàng (Customer)”** và chỉnh toàn bộ nghiệp vụ cho phù hợp: **Khách hàng có tài khoản để quản lý lịch hẹn & hồ sơ của chính họ**, còn nội bộ phòng khám chỉ còn **Admin/Bác sĩ**.

---

# BRD – PHẦN MỀM QUẢN LÝ PHÒNG KHÁM NHA KHOA (Admin/Bác sĩ/Khách hàng)

## 1. Vai trò & phân quyền

### 1.1 Vai trò

* **Admin**
* **Bác sĩ (Doctor)**
* **Khách hàng (Customer)**

### 1.2 Quyền chính

* **Admin**

  * Quản lý tài khoản (admin/doctor/customer), khóa/mở tài khoản
  * CRUD bài viết (tin tức/tư vấn)
  * CRUD dịch vụ nha khoa (**chỉ admin được thêm/sửa/xóa**)
  * Quản lý hồ sơ bệnh nhân (tạo/cập nhật)
  * Quản lý tất cả lịch hẹn (xác nhận/đổi lịch/hủy/phân công bác sĩ)
  * Quản lý lịch làm việc bác sĩ
  * Dashboard thống kê
* **Bác sĩ**

  * Xem lịch làm việc của mình
  * Xem lịch hẹn được phân công
  * Ghi chú khám
  * Tạo lịch tái khám nhanh + đổi lịch tái khám (trong quyền)
* **Khách hàng**

  * Đăng ký/đăng nhập
  * Tạo lịch hẹn (từ trang công khai hoặc sau khi đăng nhập, có chọn bác sĩ)
  * Xem danh sách lịch hẹn của mình
  * Gửi yêu cầu đổi lịch / hủy lịch (không tự duyệt, bác sĩ xác nhận)
  * Xem hồ sơ cá nhân (thông tin cơ bản) + lịch sử lịch hẹn của chính mình
  * Xem bài viết, dịch vụ

---

## 2. Yêu cầu chức năng

## 2.1 Đăng ký / Đăng nhập / Phân quyền

* Đăng ký tài khoản khách hàng: email/phone + mật khẩu (lưu `password_hash()`).
* Đăng nhập: `password_verify()`.
* Phân quyền theo `role`.

---

## 2.2 Quản lý bài viết Tin tức & Tư vấn

* **Admin**: tạo/sửa/xóa/đăng bài.
* **Bác sĩ (tuỳ chọn)**: có thể tạo bài tư vấn (nếu cho phép).
* **Khách hàng**: chỉ xem bài đã đăng.

---

## 2.3 Quản lý dịch vụ nha khoa (Admin-only)

* Admin CRUD dịch vụ (tên, mô tả, giá, trạng thái hiển thị).
* Khách hàng xem danh sách dịch vụ công khai.

---

## 2.4 Đặt lịch hẹn (Công khai + Khách hàng đăng nhập)

### A) Form đặt lịch công khai

* Họ tên, SĐT, email (tuỳ chọn)
* Ngày giờ mong muốn
* Dịch vụ quan tâm (tuỳ chọn)
* Ghi chú triệu chứng (tuỳ chọn)
* Kết quả: tạo lịch hẹn **Chờ xác nhận**.

> Nếu người đặt đã có tài khoản (trùng email/phone) thì hệ thống có thể tự liên kết về tài khoản (tuỳ thiết kế).

### B) Đặt lịch sau khi khách hàng đăng nhập

* Tương tự form công khai, nhưng tự điền thông tin khách.
* Lịch hẹn gắn trực tiếp với tài khoản khách hàng.

### C) Quản lý lịch hẹn (phía khách hàng)

* Xem danh sách lịch hẹn của mình: trạng thái, bác sĩ (nếu đã phân công), ngày giờ, dịch vụ.
* **Yêu cầu đổi lịch**: khách chọn ngày giờ mới + lý do → tạo yêu cầu, admin duyệt.
* **Yêu cầu hủy lịch**: khách gửi yêu cầu hủy → admin duyệt (hoặc auto-hủy nếu bạn muốn đơn giản).

### D) Quản lý lịch hẹn (Admin/Bác sĩ)

* Admin xem toàn bộ lịch hẹn:

  * Xác nhận lịch
  * Phân công bác sĩ
  * Đổi lịch (reschedule)
  * Hủy lịch
  * Đánh dấu đã đến / đã khám / không đến
  * Ghi chú nội bộ
* Bác sĩ xem lịch hẹn được phân công, cập nhật ghi chú khám.

---

## 2.5 Quản lý khách hàng / Hồ sơ bệnh nhân

* **Khách hàng**:

  * Xem/sửa thông tin cá nhân cơ bản (tên, ngày sinh, giới tính, địa chỉ…).
  * Xem lịch sử lịch hẹn của mình.
* **Admin**:

  * Quản lý đầy đủ hồ sơ bệnh nhân (thêm/sửa).
  * Ghi nhận thông tin y tế (tiền sử, dị ứng).

> Bác sĩ có thể xem hồ sơ bệnh nhân khi có lịch hẹn được phân công.

---

## 2.6 Quản lý lịch làm việc bác sĩ

* Admin tạo lịch làm việc theo ngày/khung giờ.
* Bác sĩ xem lịch làm việc của mình.
* Khi khách đặt lịch:

  * Có thể cho đặt tự do (admin xác nhận sau), hoặc
  * Gợi ý giờ trống theo lịch làm việc (nâng cao).

---

## 2.7 Dashboard thống kê (Admin)

* Tổng số **khách hàng/bệnh nhân**
* Tổng số **lịch hẹn** (hôm nay/tuần/tháng)
* Tổng số **dịch vụ**
* Tổng số **bài viết**
* (Tuỳ chọn) Biểu đồ:

  * Lịch hẹn theo ngày (7–30 ngày)
  * Lịch hẹn theo trạng thái
  * Top dịch vụ được đặt nhiều nhất

---

## 2.8 Tái khám nhanh sau khi khám (Bác sĩ)

* Sau khi khám xong, bác sĩ tạo lịch tái khám nhanh:

  * Chọn nhanh tái khám sau X ngày (3/7/14/30…)
  * Chọn giờ
  * Tạo lịch hẹn loại `revisit`, liên kết lần khám trước
* Bác sĩ/Admin có thể đổi lịch tái khám.
* Khách hàng nhìn thấy lịch tái khám trên tài khoản của mình.

---

# 3. Thiết kế CSDL (MySQL)

## 3.1 `users` – tài khoản (admin/doctor/customer)

| field         | type                              | note                               |
| ------------- | --------------------------------- | ---------------------------------- |
| id            | INT PK AI                         |                                    |
| full_name     | VARCHAR(150)                      |                                    |
| email         | VARCHAR(150) UNIQUE               | login                              |
| phone         | VARCHAR(20) UNIQUE NULL           | nên unique nếu dùng login bằng SĐT |
| password_hash | VARCHAR(255)                      | `password_hash()`                  |
| role          | ENUM('admin','doctor','customer') |                                    |
| is_active     | TINYINT                           | 1/0                                |
| created_at    | DATETIME                          |                                    |
| updated_at    | DATETIME                          |                                    |

---

## 3.2 `patients` – hồ sơ bệnh nhân (gắn với user khách hàng)

| field           | type                               | note                 |
| --------------- | ---------------------------------- | -------------------- |
| id              | INT PK AI                          |                      |
| user_id         | INT FK -> users.id UNIQUE          | 1 customer = 1 hồ sơ |
| dob             | DATE NULL                          |                      |
| gender          | ENUM('male','female','other') NULL |                      |
| address         | VARCHAR(255) NULL                  |                      |
| medical_history | TEXT NULL                          |                      |
| allergies       | TEXT NULL                          |                      |
| created_at      | DATETIME                           |                      |
| updated_at      | DATETIME                           |                      |

---

## 3.3 `services`

| id | INT PK AI |
| name | VARCHAR(255) |
| description | TEXT NULL |
| price | DECIMAL(12,2) NULL |
| is_active | TINYINT |
| created_at | DATETIME |
| updated_at | DATETIME |

---

## 3.4 `posts`

| id | INT PK AI |
| author_id | INT FK -> users.id |
| type | ENUM('news','advice') |
| title | VARCHAR(255) |
| slug | VARCHAR(255) UNIQUE |
| thumbnail | VARCHAR(255) NULL |
| content | LONGTEXT |
| status | ENUM('draft','published') |
| published_at | DATETIME NULL |
| created_at | DATETIME |
| updated_at | DATETIME |

---

## 3.5 `doctor_schedules`

| id | INT PK AI |
| doctor_id | INT FK -> users.id |
| work_date | DATE |
| start_time | TIME |
| end_time | TIME |
| status | ENUM('working','off') |
| note | VARCHAR(255) NULL |
| created_at | DATETIME |

---

## 3.6 `appointments` – lịch hẹn

| field                 | type                                                                                     | note                   |
| --------------------- | ---------------------------------------------------------------------------------------- | ---------------------- |
| id                    | INT PK AI                                                                                |                        |
| user_id               | INT FK -> users.id NULL                                                                  | null nếu đặt công khai |
| patient_id            | INT FK -> patients.id NULL                                                               | set khi có hồ sơ       |
| patient_name          | VARCHAR(150)                                                                             | snapshot               |
| patient_phone         | VARCHAR(20)                                                                              | snapshot               |
| patient_email         | VARCHAR(150) NULL                                                                        | snapshot               |
| service_id            | INT FK -> services.id NULL                                                               |                        |
| doctor_id             | INT FK -> users.id NULL                                                                  |                        |
| appointment_datetime  | DATETIME                                                                                 |                        |
| type                  | ENUM('new','revisit')                                                                    |                        |
| status                | ENUM('pending','confirmed','rescheduled','cancelled','checked_in','completed','no_show') |                        |
| public_note           | VARCHAR(255) NULL                                                                        | ghi chú khách          |
| internal_note         | TEXT NULL                                                                                | ghi chú nội bộ/bác sĩ  |
| parent_appointment_id | INT FK -> appointments.id NULL                                                           | link tái khám          |
| created_at            | DATETIME                                                                                 |                        |
| updated_at            | DATETIME                                                                                 |                        |

---

## 3.7 `appointment_change_requests` – yêu cầu đổi lịch/hủy từ khách

| field              | type                                  | note                    |
| ------------------ | ------------------------------------- | ----------------------- |
| id                 | INT PK AI                             |                         |
| appointment_id     | INT FK -> appointments.id             |                         |
| user_id            | INT FK -> users.id                    | customer                |
| type               | ENUM('reschedule','cancel')           |                         |
| requested_datetime | DATETIME NULL                         | chỉ dùng cho reschedule |
| reason             | VARCHAR(255) NULL                     |                         |
| status             | ENUM('pending','approved','rejected') | admin xử lý             |
| admin_note         | VARCHAR(255) NULL                     |                         |
| created_at         | DATETIME                              |                         |
| updated_at         | DATETIME                              |                         |

> Bảng này giúp “khách hàng yêu cầu” còn “admin duyệt” đúng thực tế phòng khám.

---

# 4. Logic nghiệp vụ quan trọng

* **Đặt lịch công khai**:

  * tạo `appointments.status = pending`, `user_id = NULL`
* **Khách đặt lịch sau login**:

  * tạo `appointments.user_id = customer_id`, liên kết `patient_id`
* **Khách yêu cầu đổi lịch/hủy**:

  * tạo record trong `appointment_change_requests` (`pending`)
  * bác sĩ duyệt:

    * nếu reschedule approved → update `appointments.appointment_datetime`, `status = rescheduled/confirmed`
    * nếu cancel approved → `appointments.status = cancelled`
* **Tái khám nhanh**:

  * bác sĩ tạo appointment mới `type=revisit`, `parent_appointment_id = lần khám trước`, gán `user_id/patient_id` theo bệnh nhân.

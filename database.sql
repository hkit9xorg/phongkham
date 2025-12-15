CREATE DATABASE IF NOT EXISTS phongkham CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE phongkham;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','doctor','customer') NOT NULL DEFAULT 'customer',
    is_active TINYINT NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    dob DATE NULL,
    gender ENUM('male','female','other') NULL,
    address VARCHAR(255) NULL,
    medical_history TEXT NULL,
    allergies TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    thumbnail VARCHAR(255) NULL,
    price DECIMAL(12,2) NULL,
    is_active TINYINT NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    thumbnail VARCHAR(255) NULL,
    category VARCHAR(100) DEFAULT 'news',
    status ENUM('draft','published') DEFAULT 'draft',
    author_id INT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    academic_title VARCHAR(150) NULL,
    specialty VARCHAR(255) NULL,
    avatar_url VARCHAR(500) NULL,
    philosophy TEXT NULL,
    joined_at DATE NULL,
    is_active TINYINT NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NULL,
    doctor_id INT NULL,
    service_id INT NULL,
    full_name VARCHAR(150) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    email VARCHAR(150) NULL,
    appointment_date DATETIME NOT NULL,
    status ENUM('pending','confirmed','rescheduled','cancelled','completed','no_show','revisit') DEFAULT 'pending',
    type ENUM('standard','revisit') DEFAULT 'standard',
    notes TEXT NULL,
    reschedule_request TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

CREATE TABLE doctor_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT NOT NULL,
    work_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    note VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES users(id)
);

INSERT INTO users (full_name, email, phone, password_hash, role, is_active)
VALUES
('Quản trị viên', 'admin@example.com', '0901000100', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'admin', 1),
('Bác sĩ Lisa', 'doctor@example.com', '0902000200', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'doctor', 1),
('Khách hàng Minh', 'user@example.com', '0903000300', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1);

INSERT INTO patients (user_id, dob, gender, address, medical_history, allergies)
VALUES
(3, '1995-08-12', 'male', 'Quận 1, TP.HCM', 'Trám răng 2022', 'Không');

INSERT INTO services (name, description, price, is_active)
VALUES
('Khám tổng quát', 'Kiểm tra sức khỏe răng miệng, tư vấn lộ trình điều trị.', 200000, 1),
('Tẩy trắng răng', 'Công nghệ Plasma không ê buốt, thực hiện trong 60 phút.', 1200000, 1),
('Niềng răng Invisalign', 'Phác đồ trong suốt, thẩm mỹ cao, tái khám định kỳ.', 15000000, 1);

INSERT INTO articles (title, content, category, status, author_id, thumbnail)
VALUES
('5 bước chăm sóc răng miệng tại nhà', 'Đánh răng 2 lần/ngày, dùng chỉ nha khoa và nước súc miệng.', 'tuvan', 'published', 2, NULL),
('Khi nào cần tẩy trắng răng?', 'Tẩy trắng giúp răng sáng hơn 2-3 tone, nên thực hiện tại phòng khám uy tín.', 'tintuc', 'published', 2, NULL);

INSERT INTO doctors (full_name, academic_title, specialty, avatar_url, philosophy, joined_at)
VALUES
('BS. Nguyễn Minh Châu', 'Thạc sĩ RHM', 'Phục hình - Cấy ghép Implant', 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80', 'Tập trung vào điều trị ít xâm lấn, giữ vững cấu trúc răng tự nhiên.', DATE_SUB(CURDATE(), INTERVAL 540 DAY)),
('BS. Trần Gia Hưng', 'Bác sĩ CKI', 'Chỉnh nha & Invisalign', 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=600&q=80', 'Lắng nghe, đồng hành và cá nhân hóa kế hoạch cho từng khách hàng.', DATE_SUB(CURDATE(), INTERVAL 320 DAY)),
('BS. Phạm Bảo Ngọc', 'Bác sĩ', 'Điều trị tổng quát', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80', 'Ưu tiên trải nghiệm nhẹ nhàng, giúp khách hàng bớt lo lắng khi đến nha khoa.', DATE_SUB(CURDATE(), INTERVAL 180 DAY));

INSERT INTO appointments (customer_id, doctor_id, service_id, full_name, phone, email, appointment_date, status, type, notes)
VALUES
(3, 2, 1, 'Khách hàng Minh', '0903000300', 'user@example.com', DATE_ADD(NOW(), INTERVAL 1 DAY), 'pending', 'standard', 'Đau nhức răng hàm trên'),
(NULL, 2, 2, 'Khách vãng lai', '0909999999', 'guest@example.com', DATE_ADD(NOW(), INTERVAL 2 DAY), 'confirmed', 'standard', 'Muốn tẩy trắng răng');

INSERT INTO doctor_schedules (doctor_id, work_date, start_time, end_time, note)
VALUES
(2, DATE(NOW()), '08:30:00', '16:30:00', 'Khám tổng quát'),
(2, DATE_ADD(DATE(NOW()), INTERVAL 1 DAY), '08:30:00', '16:30:00', 'Ca tẩy trắng');

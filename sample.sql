INSERT INTO users (id, full_name, email, phone, password_hash, role, is_active)
VALUES
(7,  'Lê Thu Trang',        'tranglt@example.com',   '0903000302', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1),
(8,  'Đặng Quốc Bảo',       'baodq@example.com',     '0903000303', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1),
(9,  'Võ Thị Hồng',         'hongvt@example.com',    '0903000304', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1),
(10, 'Phan Đức Long',       'longpd@example.com',    '0903000305', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1),
(11, 'Nguyễn Thảo Vy',      'vynt@example.com',      '0903000306', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1),
(12, 'Bùi Minh Tâm',        'tambm@example.com',     '0903000307', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1),
(13, 'Trần Nhật Hào',       'haotn@example.com',     '0903000308', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1),
(14, 'Phạm Ngọc Ánh',       'anhpn@example.com',     '0903000309', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1),
(15, 'BS. Lê Quang Huy',    'huylq@example.com',     '0902000203', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'doctor',   1),
(16, 'BS. Nguyễn Yến Nhi',  'nhiny@example.com',     '0902000204', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'doctor',   1),
(17, 'BS. Trương Hải Nam',  'namth@example.com',     '0902000205', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'doctor',   1),
(18, 'Khách hàng Vãng Lai', 'guest2@example.com',    '0909999998', '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa', 'customer', 1)
ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP;



INSERT INTO patients (user_id, dob, gender, address, medical_history, allergies)
VALUES
(6,  '1999-03-21', 'male',   'TP. Thủ Đức, TP.HCM', 'Cạo vôi răng 2023', 'Không'),
(7,  '1998-11-02', 'female', 'Quận 7, TP.HCM',      'Viêm lợi nhẹ',      'Hải sản'),
(8,  '1990-05-17', 'male',   'Quận 3, TP.HCM',      'Trám răng 2021',    'Không'),
(9,  '2001-07-08', 'female', 'Bình Thạnh, TP.HCM',  'Nhạy cảm răng',     'Penicillin'),
(10, '1996-02-13', 'male',   'Tân Bình, TP.HCM',    'Lấy tủy 2019',      'Không'),
(11, '1997-09-30', 'female', 'Gò Vấp, TP.HCM',      'Niềng răng 2020',   'Không'),
(12, '1988-12-24', 'male',   'Quận 10, TP.HCM',     'Hôi miệng',         'Không'),
(13, '1993-06-11', 'other',  'Quận 1, TP.HCM',      'Viêm nha chu',      'Không'),
(14, '2000-01-05', 'female', 'Bình Tân, TP.HCM',    'Cạo vôi 2022',      'Không'),
(18, '1994-04-19', 'male',   'Phú Nhuận, TP.HCM',   'Đau răng khôn',     'Không');



INSERT INTO services (name, description, price, is_active)
VALUES
('Cạo vôi - Đánh bóng', 'Loại bỏ mảng bám và đánh bóng bề mặt răng.', 300000, 1),
('Trám răng thẩm mỹ', 'Phục hồi răng sâu bằng composite màu răng.', 350000, 1),
('Nhổ răng khôn', 'Tiểu phẫu răng khôn có gây tê, theo dõi sau nhổ.', 1500000, 1),
('Cấy ghép Implant', 'Phục hồi răng mất bằng trụ Implant và mão sứ.', 18000000, 1),
('Bọc răng sứ', 'Thẩm mỹ nụ cười với mão sứ, tư vấn theo tình trạng.', 2500000, 1),
('Điều trị tủy', 'Loại bỏ tủy viêm, trám bít ống tủy, giảm đau.', 1200000, 1),
('Chụp X-Quang', 'Chụp phim kiểm tra toàn cảnh hoặc cục bộ.', 150000, 1);



INSERT INTO doctors (user_id, full_name, academic_title, specialty, avatar_url, philosophy, joined_at, is_active)
VALUES
(15, 'BS. Lê Quang Huy',   'Bác sĩ CKI', 'Răng khôn - Tiểu phẫu', 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=600&q=80',
 'Chuẩn an toàn, nhanh gọn, ưu tiên hồi phục nhẹ nhàng.', DATE_SUB(CURDATE(), INTERVAL 260 DAY), 1),
(16, 'BS. Nguyễn Yến Nhi', 'ThS. RHM',   'Nha khoa thẩm mỹ',      'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80',
 'Tối ưu thẩm mỹ nhưng vẫn bảo tồn mô răng thật.',        DATE_SUB(CURDATE(), INTERVAL 210 DAY), 1),
(17, 'BS. Trương Hải Nam', 'Bác sĩ',     'Nội nha - Điều trị tủy','https://images.unsplash.com/photo-1607746882042-944635dfe10e?auto=format&fit=crop&w=600&q=80',
 'Giảm đau, điều trị triệt để và theo dõi lâu dài.',     DATE_SUB(CURDATE(), INTERVAL 150 DAY), 1);



INSERT INTO articles (title, content, category, status, author_id, thumbnail)
VALUES
('Cạo vôi răng bao lâu một lần?', 'Khuyến nghị 3-6 tháng/lần tùy cơ địa và thói quen vệ sinh.', 'tuvan', 'published', 4, NULL),
('Dấu hiệu sâu răng sớm', 'Ê buốt khi ăn ngọt/lạnh, có đốm nâu, kẹt thức ăn là dấu hiệu thường gặp.', 'tuvan', 'published', 5, NULL),
('Implant có đau không?', 'Cấy ghép Implant có gây tê, đau nhẹ sau thủ thuật và kiểm soát bằng thuốc.', 'tintuc', 'published', 2, NULL),
('Niềng Invisalign phù hợp ai?', 'Phù hợp sai lệch nhẹ-vừa, ưu điểm thẩm mỹ cao và dễ vệ sinh.', 'tuvan', 'published', 4, NULL),
('Răng khôn mọc lệch nên làm gì?', 'Nên chụp X-quang và khám sớm để tránh biến chứng viêm nhiễm.', 'tintuc', 'published', 5, NULL),
('Chăm sóc sau nhổ răng', 'Cắn gạc đúng cách, tránh súc miệng mạnh, ăn mềm 1-2 ngày đầu.', 'tuvan', 'published', 4, NULL),
('Hôi miệng: nguyên nhân phổ biến', 'Mảng bám, viêm lợi, khô miệng… cần xử lý nguyên nhân gốc.', 'tuvan', 'published', 5, NULL),
('Bọc răng sứ có hại không?', 'Nếu chỉ định đúng và làm chuẩn, bọc sứ giúp cải thiện thẩm mỹ.', 'tintuc', 'draft', 2, NULL),
('Điều trị tủy mất bao lâu?', 'Tùy mức độ viêm và số ống tủy, thường 1-3 lần hẹn.', 'tuvan', 'published', 6, NULL),
('Tẩy trắng răng có giữ được lâu?', 'Phụ thuộc chế độ ăn uống và vệ sinh; thường duy trì 1-2 năm.', 'tintuc', 'published', 2, NULL);



INSERT INTO appointments (customer_id, doctor_id, service_id, full_name, phone, email, appointment_date, status, type, notes)
VALUES
(7,  4, 4,  'Lê Thu Trang',   '0903000302', 'tranglt@example.com',  DATE_ADD(NOW(), INTERVAL 3 DAY),  'confirmed',  'standard', 'Cạo vôi định kỳ'),
(8,  6, 9,  'Đặng Quốc Bảo',  '0903000303', 'baodq@example.com',    DATE_ADD(NOW(), INTERVAL 4 DAY),  'pending',    'standard', 'Ê buốt khi uống lạnh'),
(9,  5, 5,  'Võ Thị Hồng',    '0903000304', 'hongvt@example.com',   DATE_ADD(NOW(), INTERVAL 5 DAY),  'pending',    'standard', 'Trám răng cửa'),
(10, 1, 1,  'Phan Đức Long',  '0903000305', 'longpd@example.com',   DATE_ADD(NOW(), INTERVAL 6 DAY),  'confirmed',  'standard', 'Khám tổng quát'),
(11, 2, 3,  'Nguyễn Thảo Vy', '0903000306', 'vynt@example.com',     DATE_ADD(NOW(), INTERVAL 7 DAY),  'confirmed',  'standard', 'Tư vấn Invisalign'),
(12, 6, 9,  'Bùi Minh Tâm',   '0903000307', 'tambm@example.com',    DATE_ADD(NOW(), INTERVAL 8 DAY),  'rescheduled','standard', 'Đau răng hàm'),
(13, 3, 2,  'Trần Nhật Hào',  '0903000308', 'haotn@example.com',    DATE_ADD(NOW(), INTERVAL 9 DAY),  'pending',    'standard', 'Muốn tẩy trắng'),
(14, 5, 8,  'Phạm Ngọc Ánh',  '0903000309', 'anhpn@example.com',    DATE_ADD(NOW(), INTERVAL 10 DAY), 'pending',    'standard', 'Bọc sứ 2 răng cửa'),
(18, 4, 6,  'Khách hàng VL',  '0909999998', 'guest2@example.com',   DATE_ADD(NOW(), INTERVAL 11 DAY), 'confirmed',  'standard', 'Nhổ răng khôn mọc lệch'),
(3,  6, 10, 'Khách hàng Minh','0903000300', 'minhkh@example.com',   DATE_ADD(NOW(), INTERVAL 12 DAY), 'completed',  'standard', 'Chụp X-quang kiểm tra'),
(6,  5, 7,  'Nguyễn Hoàng Kha','0903000301','khanh@example.com',    DATE_SUB(NOW(), INTERVAL 2 DAY),  'completed',  'standard', 'Cấy ghép tư vấn implant'),
(8,  4, 4,  'Đặng Quốc Bảo',  '0903000303', 'baodq@example.com',    DATE_SUB(NOW(), INTERVAL 5 DAY),  'no_show',    'standard', 'Bỏ lỡ lịch');



INSERT INTO appointment_changes (appointment_id, old_date, new_date, changed_by, changed_by_role)
VALUES
(2,  DATE_ADD(NOW(), INTERVAL 2 DAY),  DATE_ADD(NOW(), INTERVAL 3 DAY),  6,  'customer'),
(3,  DATE_ADD(NOW(), INTERVAL 3 DAY),  DATE_ADD(NOW(), INTERVAL 4 DAY),  1,  'admin'),
(4,  DATE_ADD(NOW(), INTERVAL 4 DAY),  DATE_ADD(NOW(), INTERVAL 6 DAY),  8,  'customer'),
(5,  DATE_ADD(NOW(), INTERVAL 5 DAY),  DATE_ADD(NOW(), INTERVAL 7 DAY),  2,  'doctor'),
(6,  DATE_ADD(NOW(), INTERVAL 6 DAY),  DATE_ADD(NOW(), INTERVAL 8 DAY),  1,  'admin'),
(7,  DATE_ADD(NOW(), INTERVAL 7 DAY),  DATE_ADD(NOW(), INTERVAL 9 DAY),  11, 'customer'),
(8,  DATE_ADD(NOW(), INTERVAL 8 DAY),  DATE_ADD(NOW(), INTERVAL 10 DAY), 4,  'doctor'),
(9,  DATE_ADD(NOW(), INTERVAL 9 DAY),  DATE_ADD(NOW(), INTERVAL 11 DAY), 1,  'admin');



INSERT INTO appointment_change_views (change_id, user_id, is_read, read_at)
VALUES
(1, 1, 1, NOW()),
(1, 3, 0, NULL),

(2, 1, 0, NULL),
(2, 6, 1, NOW()),

(3, 1, 1, NOW()),
(3, 8, 0, NULL),

(4, 1, 0, NULL),
(4, 8, 0, NULL),

(5, 1, 1, NOW()),
(5, 2, 1, NOW()),

(6, 1, 0, NULL),
(6, 11, 0, NULL),

(7, 1, 1, NOW()),
(7, 4, 0, NULL),

(8, 1, 0, NULL),
(8, 12, 0, NULL);



INSERT INTO doctor_schedules (doctor_id, work_date, start_time, end_time, note)
VALUES
(2, DATE_ADD(CURDATE(), INTERVAL 0 DAY), '09:00:00', '17:00:00', 'Chỉnh nha'),
(3, DATE_ADD(CURDATE(), INTERVAL 0 DAY), '08:00:00', '16:00:00', 'Khám tổng quát'),

(4, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '08:30:00', '16:30:00', 'Tiểu phẫu'),
(5, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '09:00:00', '17:30:00', 'Thẩm mỹ'),
(6, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '08:00:00', '16:00:00', 'Điều trị tủy'),

(4, DATE_ADD(CURDATE(), INTERVAL 3 DAY), '08:30:00', '12:00:00', 'Răng khôn'),
(5, DATE_ADD(CURDATE(), INTERVAL 3 DAY), '13:30:00', '18:00:00', 'Bọc sứ'),
(6, DATE_ADD(CURDATE(), INTERVAL 3 DAY), '08:00:00', '12:00:00', 'Nội nha'),

(2, DATE_ADD(CURDATE(), INTERVAL 5 DAY), '09:00:00', '17:00:00', 'Invisalign tái khám'),
(3, DATE_ADD(CURDATE(), INTERVAL 6 DAY), '08:00:00', '16:00:00', 'Điều trị tổng quát'),

(1, DATE_ADD(CURDATE(), INTERVAL 7 DAY), '08:30:00', '16:30:00', 'Khám tổng quát'),
(2, DATE_ADD(CURDATE(), INTERVAL 8 DAY), '09:00:00', '17:00:00', 'Chỉnh nha'),
(4, DATE_ADD(CURDATE(), INTERVAL 9 DAY), '08:30:00', '16:30:00', 'Tiểu phẫu');
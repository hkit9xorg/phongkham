## Tiến độ
- Thiết lập kiến trúc MVC PHP thuần theo spec, bổ sung helper Env/Csrf/Auth/Response.
- Xây dựng landing page (dịch vụ, bài viết, form đặt lịch) và dashboard đa vai trò (admin/bác sĩ/khách hàng).
- Hoàn thiện API JSON cho dịch vụ, bài viết, lịch hẹn; thêm JavaScript Fetch + DaisyUI modal.
- Cập nhật database.sql với đầy đủ schema BRD (users, patients, services, articles, appointments, doctor_schedules) và seed dữ liệu.

## Hạn chế / TODO
- Chưa có trang đổi mật khẩu và quản lý quyền nâng cao.
- Chưa có logic tự động gợi ý khung giờ trống theo lịch làm việc.

## Kế hoạch tiếp theo
- Bổ sung trang quản trị chi tiết cho từng module (phân trang, tìm kiếm, chỉnh sửa).
- Thêm API cập nhật trạng thái/ghi chú lịch hẹn cho bác sĩ và admin.
- Xây dựng chức năng đổi mật khẩu và cập nhật hồ sơ bệnh nhân đầy đủ.

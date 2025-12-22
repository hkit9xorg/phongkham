# Quy trình test thủ công hệ thống phòng khám

Tài liệu này mô tả quy trình test thủ công cho ứng dụng web phòng khám nhằm đảm bảo các chức năng chính hoạt động ổn định trước khi release.

## 1. Chuẩn bị môi trường
- Trình duyệt: Chrome/Edge/Firefox bản mới nhất, bật DevTools để xem console và network.
- Dữ liệu mẫu: sử dụng database seed trong `database.sql` và tài khoản mặc định `admin@example.com` / `123456`.
- Kiểm tra file `.env` đã cấu hình đúng kết nối DB và `APP_BASE_URL`.
- Xóa cache trình duyệt hoặc mở cửa sổ ẩn danh trước mỗi vòng test.

## 2. Kiểm tra tổng quan giao diện
1. Truy cập trang chủ, xác nhận giao diện tải đúng CSS/JS (DaisyUI, RemixIcon, DataTables).
2. Đảm bảo hiển thị tốt trên desktop và thu nhỏ cửa sổ xuống <768px để kiểm tra responsive.
3. Kiểm tra các link điều hướng chính hoạt động và không xuất hiện lỗi 404/500.

## 3. Đăng nhập và bảo mật phiên
1. Mở trang đăng nhập, nhập tài khoản hợp lệ `admin@example.com` / `123456` → kỳ vọng chuyển đến dashboard.
2. Nhập sai mật khẩu 2 lần → kỳ vọng báo lỗi và không tạo session.
3. Sau khi đăng nhập, làm mới trang → session vẫn giữ nguyên.
4. Nhấn đăng xuất → kỳ vọng quay lại trang đăng nhập và session bị hủy.
5. Kiểm tra CSRF: mở DevTools, chỉnh sửa token trong form nhạy cảm (nếu có) rồi submit → kỳ vọng báo lỗi.

## 4. Quản lý bệnh nhân (CRUD)
1. Mở màn hình danh sách bệnh nhân, xác nhận bảng DataTables tải dữ liệu từ API (qua tab Network).
2. Thêm mới: nhấn nút "Thêm" → mở modal, nhập dữ liệu hợp lệ → kỳ vọng hiện thông báo thành công và bản ghi xuất hiện trong bảng.
3. Validate client: để trống trường bắt buộc hoặc nhập email sai định dạng → kỳ vọng cảnh báo phía client không cho submit.
4. Sửa: chọn bản ghi, mở modal chỉnh sửa, thay đổi thông tin → kỳ vọng cập nhật trong bảng và DB.
5. Xóa: chọn xóa bản ghi, modal xác nhận xuất hiện → chọn Đồng ý → bản ghi bị xóa, thông báo thành công.

## 5. Lịch hẹn và khám bệnh
1. Tạo lịch hẹn mới qua modal, kiểm tra thời gian không trùng và lưu thành công.
2. Đổi trạng thái lịch hẹn (đang chờ → đang khám → hoàn thành) qua các nút/selector → dữ liệu cập nhật đúng.
3. Kiểm tra tìm kiếm/lọc lịch hẹn theo ngày, bác sĩ, trạng thái.
4. Ghi nhận chẩn đoán/đơn thuốc nếu có: nhập nội dung, lưu và xem lại ở chi tiết bệnh nhân.

## 6. Thanh toán và hóa đơn
1. Tạo hóa đơn/phiếu thu cho một ca khám, nhập chi phí dịch vụ/thuốc → tổng cộng tính đúng.
2. Thử thay đổi số lượng/đơn giá để xác minh cập nhật tổng tiền realtime.
3. In/xuất hóa đơn (PDF/print) nếu có → file được tạo và dữ liệu đúng.

## 7. Upload & quản lý tệp
1. Thử upload file (ảnh kết quả, đơn thuốc), định dạng hợp lệ (jpg/png/pdf) → upload thành công và lưu đường dẫn trong bảng.
2. Upload file vượt dung lượng cho phép → hệ thống từ chối với thông báo rõ ràng.
3. Tải xuống/xem lại file đã upload đảm bảo truy cập đúng quyền.

## 8. API và AJAX
1. Thực hiện các hành động CRUD từ UI và kiểm tra response JSON trả về có cấu trúc `{status, message, data}`.
2. Kiểm tra lỗi server (ví dụ gửi thiếu trường bắt buộc) → API trả `status: error` và thông báo phù hợp.
3. Đảm bảo các request nhạy cảm đều dùng phương thức POST/PUT/DELETE và có CSRF token khi cần.

## 9. Phân quyền người dùng
1. Đăng nhập với tài khoản người dùng thường (nếu có) → đảm bảo chỉ thấy menu chức năng được phép.
2. Thử truy cập URL admin trực tiếp → bị chặn hoặc redirect.
3. Kiểm tra các hành động bị hạn chế (xóa, cập nhật) không thể thực hiện bằng user quyền thấp.

## 10. Khả năng phục hồi lỗi
1. Ngắt kết nối mạng trong khi thao tác (tạm tắt mạng) → UI hiển thị lỗi, không treo.
2. Backend trả lỗi 500 giả lập (có thể tạm chỉnh API) → modal báo lỗi hiển thị.
3. Làm mới trang khi modal đang mở → không làm hỏng bố cục, dữ liệu được tải lại.

## 11. Nhật ký kiểm thử
- Ghi lại kết quả từng ca test (Pass/Fail), thời gian, người thực hiện và log lỗi (console/network) nếu có.
- Lưu ảnh chụp màn hình khi phát hiện lỗi UI hoặc message bất thường.

## 12. Tiêu chí hoàn tất
- 100% ca test quan trọng (đăng nhập, CRUD chính, thanh toán) Pass.
- Không còn lỗi blocker/critical, các lỗi minor đã được ghi nhận và có kế hoạch xử lý.
- Kiểm tra lại nhanh (smoke) sau mỗi lần fix để đảm bảo không phát sinh lỗi mới.

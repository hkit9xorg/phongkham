# Diễn giải các sơ đồ

## Sơ đồ Use Case Khách hàng
Sơ đồ mô tả các tương tác chính giữa khách hàng và hệ thống, từ đăng ký đến xem nội dung. Khách hàng là tác nhân duy nhất kết nối tới các ca sử dụng như đặt lịch, xem lịch và gửi yêu cầu đổi/hủy. Mục đích là thể hiện rõ phạm vi tự phục vụ mà người dùng cuối có thể thao tác. Ý nghĩa của sơ đồ giúp nhóm phát triển kiểm tra đầy đủ các điểm chạm của khách hàng. Vai trò của từng ca sử dụng là mở đầu cho các quy trình nghiệp vụ phía quản trị viên hoặc bác sĩ.

## Sơ đồ Use Case Bác sĩ
Sơ đồ này tập trung vào tác nhân bác sĩ và các ca sử dụng liên quan đến công việc chuyên môn. Các chức năng gồm xem lịch làm việc, xem lịch hẹn được phân công, ghi chú khám, tạo và đổi lịch tái khám. Mục đích là làm rõ quyền và hành động của bác sĩ trong chuỗi chăm sóc bệnh nhân. Ý nghĩa của sơ đồ là đảm bảo bác sĩ chỉ thấy và thao tác trên các đối tượng được giao, không chồng chéo với quản trị viên. Vai trò của từng ca sử dụng hỗ trợ duy trì chất lượng khám và tính liên tục của điều trị.

## Sơ đồ Use Case Quản trị viên
Sơ đồ thể hiện các ca sử dụng mà quản trị viên thực hiện để vận hành hệ thống. Các chức năng bao gồm quản lý tài khoản, bài viết, dịch vụ, hồ sơ bệnh nhân, lịch hẹn, lịch làm việc, dashboard và duyệt yêu cầu đổi/hủy. Mục đích là mô tả rõ quyền lực trung tâm của quản trị viên trong điều phối nguồn lực và nội dung. Ý nghĩa nằm ở việc bảo đảm mọi thay đổi quan trọng đều có bước duyệt và kiểm soát. Vai trò của từng ca sử dụng giúp duy trì bảo mật, tính chính xác dữ liệu và trải nghiệm khách hàng ổn định.

## Sơ đồ phân rã chức năng
Sơ đồ phân rã trình bày cấu trúc chức năng của hệ thống dưới dạng cây để nhìn nhanh các khối lớn và nhánh con. Mục đích là giúp đội ngũ định hình phạm vi và ưu tiên phát triển theo từng cụm chức năng. Ý nghĩa của sơ đồ là tạo bản đồ tổng quan, tránh bỏ sót các mảnh chức năng khi phân công nhiệm vụ. Vai trò của từng nhánh cho phép xác định rõ dữ liệu và API cần thiết cho mỗi mảng. Cách tổ chức này hỗ trợ kiểm soát phạm vi và lập kế hoạch sprint hiệu quả.

## Sơ đồ tuần tự
Sơ đồ tuần tự mô tả luồng yêu cầu đổi lịch từ khách hàng qua frontend, API, cơ sở dữ liệu tới quản trị viên/bác sĩ và ngược lại. Mục đích là làm rõ thứ tự thông điệp và các điểm lưu trạng thái trong quá trình duyệt. Ý nghĩa của sơ đồ giúp phát hiện điểm cần xác thực, ghi log và phản hồi người dùng. Vai trò của từng bước đảm bảo rằng thay đổi lịch chỉ hoàn tất sau khi được duyệt và cập nhật dữ liệu. Sơ đồ cũng nhấn mạnh phản hồi JSON và cập nhật giao diện để khách hàng nhận thông tin kịp thời.

## Sơ đồ lớp
Sơ đồ lớp mô hình hóa các thực thể chính như User, PatientProfile, Service, Appointment, Article và DoctorSchedule. Mục đích là thể hiện thuộc tính và quan hệ giữa các lớp phục vụ cho thiết kế code và CSDL. Ý nghĩa là tạo khung kiến trúc hướng đối tượng, hỗ trợ tái sử dụng và kiểm soát ràng buộc. Vai trò của từng lớp phản ánh nghiệp vụ: User cho danh tính và phân quyền, Appointment cho lịch hẹn, Service cho danh mục, v.v. Sơ đồ giúp lập trình viên triển khai mô hình dữ liệu nhất quán giữa backend và database.

## Sơ đồ ERD
Sơ đồ ERD chi tiết hóa các bảng, khóa chính, khóa ngoại và quan hệ trong cơ sở dữ liệu MySQL. Mục đích là đảm bảo mô hình dữ liệu đáp ứng đầy đủ yêu cầu nghiệp vụ và ràng buộc toàn vẹn. Ý nghĩa của sơ đồ là cung cấp tài liệu tham chiếu cho việc viết migration hoặc cập nhật `database.sql`. Vai trò của từng bảng được mô tả rõ: `users` cho tài khoản, `patients` cho hồ sơ, `appointments` cho lịch hẹn, `services` cho dịch vụ, `articles` cho nội dung, `doctor_schedules` cho lịch bác sĩ. Sơ đồ hỗ trợ kiểm tra chéo với mã nguồn PHP dùng PDO để tránh lỗi quan hệ và dữ liệu mồ côi.

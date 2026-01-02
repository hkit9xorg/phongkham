# Chức năng phần mềm theo từng loại người dùng

## Khách hàng
1. **Đăng ký tài khoản**  
   *Mục đích*: Cho phép khách hàng tạo tài khoản cá nhân để quản lý lịch hẹn và hồ sơ.  
   *Ý nghĩa*: Giúp gắn kết thông tin lịch hẹn với người dùng cụ thể, giảm sai lệch dữ liệu.  
   *Vai trò*: Tiền đề để truy cập các chức năng tự phục vụ như xem lịch hẹn hoặc cập nhật thông tin.
2. **Đăng nhập & phân quyền**  
   *Mục đích*: Xác thực và áp dụng quyền hạn phù hợp.  
   *Ý nghĩa*: Ngăn truy cập trái phép vào dữ liệu nhạy cảm, chỉ hiển thị các thao tác dành cho khách hàng.  
   *Vai trò*: Bảo vệ tài khoản và dữ liệu cá nhân, đảm bảo quy trình sử dụng thống nhất.
3. **Đặt lịch hẹn (công khai hoặc sau đăng nhập)**  
   *Mục đích*: Gửi yêu cầu khám với thông tin liên hệ, dịch vụ quan tâm, thời gian mong muốn.  
   *Ý nghĩa*: Chuẩn hóa quy trình tiếp nhận yêu cầu khám, giúp hệ thống hoặc nhân viên xác nhận và phân công bác sĩ.  
   *Vai trò*: Điểm bắt đầu của hành trình khám bệnh, tạo dữ liệu đầu vào cho quản trị viên xử lý.
4. **Xem danh sách lịch hẹn của mình**  
   *Mục đích*: Theo dõi trạng thái, bác sĩ phụ trách, thời gian, dịch vụ của từng lịch hẹn.  
   *Ý nghĩa*: Cung cấp minh bạch thông tin và giảm nhu cầu liên hệ thủ công.  
   *Vai trò*: Giúp khách chủ động sắp xếp thời gian và chuẩn bị.
5. **Gửi yêu cầu đổi lịch**  
   *Mục đích*: Đề nghị thay đổi thời gian khám kèm lý do.  
   *Ý nghĩa*: Cho phép điều chỉnh linh hoạt, hạn chế bỏ lỡ lịch.  
   *Vai trò*: Kích hoạt quy trình duyệt của quản trị viên/bác sĩ để cập nhật lịch.
6. **Gửi yêu cầu hủy lịch**  
   *Mục đích*: Thông báo hủy hẹn có kiểm soát thay vì tự ý bỏ lịch.  
   *Ý nghĩa*: Giảm trống slot bất ngờ và hỗ trợ sắp xếp bệnh nhân khác.  
   *Vai trò*: Khởi tạo yêu cầu để quản trị viên xác nhận và cập nhật trạng thái.
7. **Xem hồ sơ cá nhân và lịch sử lịch hẹn**  
   *Mục đích*: Theo dõi thông tin cơ bản, lịch sử khám, các ghi chú tái khám.  
   *Ý nghĩa*: Tăng tính minh bạch và khả năng tự quản lý sức khỏe.  
   *Vai trò*: Giúp khách hàng nắm được quá trình điều trị và lịch tái khám.
8. **Xem bài viết và danh mục dịch vụ**  
   *Mục đích*: Cập nhật kiến thức nha khoa và tham khảo các gói dịch vụ.  
   *Ý nghĩa*: Hỗ trợ khách chọn dịch vụ phù hợp, tăng niềm tin vào phòng khám.  
   *Vai trò*: Cung cấp thông tin trước khi đặt lịch hoặc ra quyết định điều trị.

## Bác sĩ
1. **Đăng nhập & xem lịch làm việc**  
   *Mục đích*: Truy cập hệ thống và xem các khung giờ đã được phân công.  
   *Ý nghĩa*: Đảm bảo bác sĩ luôn cập nhật lịch làm việc chính thức, tránh trùng lặp.  
   *Vai trò*: Cơ sở để chuẩn bị khám và phối hợp với quản trị viên.
2. **Xem lịch hẹn được phân công**  
   *Mục đích*: Nắm danh sách bệnh nhân, thời gian, dịch vụ liên quan.  
   *Ý nghĩa*: Giúp bác sĩ chuẩn bị chuyên môn trước khi tiếp đón.  
   *Vai trò*: Điểm đầu cho quy trình khám và cập nhật hồ sơ.
3. **Cập nhật ghi chú khám**  
   *Mục đích*: Ghi nhận chẩn đoán, điều trị, lưu ý cho từng lịch hẹn.  
   *Ý nghĩa*: Bảo đảm lịch sử điều trị được lưu trữ đầy đủ, hỗ trợ lần khám sau.  
   *Vai trò*: Tạo dữ liệu y tế cho bệnh án và báo cáo.
4. **Tạo lịch tái khám nhanh**  
   *Mục đích*: Lên lịch tái khám sau khi kết thúc buổi khám hiện tại.  
   *Ý nghĩa*: Tăng trải nghiệm bệnh nhân, đảm bảo quá trình điều trị liên tục.  
   *Vai trò*: Khởi tạo lịch hẹn loại “tái khám”, liên kết với lần khám trước.
5. **Đổi lịch tái khám trong phạm vi được phân công**  
   *Mục đích*: Điều chỉnh lịch tái khám khi có thay đổi chuyên môn hoặc lịch cá nhân.  
   *Ý nghĩa*: Giữ lịch trình khám phù hợp với khả năng bác sĩ và nhu cầu bệnh nhân.  
   *Vai trò*: Đảm bảo điều trị không bị gián đoạn và đúng người phụ trách.
6. **Tham khảo hồ sơ bệnh nhân liên quan**  
   *Mục đích*: Xem thông tin y tế (tiền sử, dị ứng) của bệnh nhân trong các lịch hẹn được giao.  
   *Ý nghĩa*: Giảm rủi ro chuyên môn và tăng chất lượng tư vấn.  
   *Vai trò*: Đưa ra quyết định điều trị an toàn, cá nhân hóa.

## Quản trị viên
1. **Quản lý tài khoản (admin/doctor/customer)**  
   *Mục đích*: Tạo, khóa/mở khóa, phân quyền tài khoản.  
   *Ý nghĩa*: Kiểm soát truy cập hệ thống và đảm bảo chỉ người có thẩm quyền được dùng.  
   *Vai trò*: Nền tảng bảo mật và quản trị người dùng.
2. **Quản lý bài viết (tin tức/tư vấn)**  
   *Mục đích*: Đăng, chỉnh sửa, xoá nội dung truyền thông và tư vấn.  
   *Ý nghĩa*: Duy trì kênh thông tin chính thức, thu hút khách hàng.  
   *Vai trò*: Cung cấp nội dung cập nhật cho website công khai và khu vực khách hàng.
3. **Quản lý dịch vụ nha khoa**  
   *Mục đích*: CRUD danh mục dịch vụ, giá, mô tả, trạng thái hiển thị.  
   *Ý nghĩa*: Đảm bảo danh sách dịch vụ luôn chuẩn và đồng bộ với thực tế.  
   *Vai trò*: Nguồn dữ liệu để khách đặt lịch và bác sĩ tư vấn.
4. **Quản lý hồ sơ bệnh nhân**  
   *Mục đích*: Tạo/cập nhật thông tin y tế, tiền sử, dị ứng.  
   *Ý nghĩa*: Lưu trữ đầy đủ hồ sơ phục vụ khám và tái khám.  
   *Vai trò*: Đảm bảo dữ liệu y tế thống nhất, hỗ trợ bác sĩ.
5. **Quản lý lịch hẹn**  
   *Mục đích*: Xác nhận, phân công bác sĩ, đổi lịch, hủy lịch, đánh dấu trạng thái, thêm ghi chú.  
   *Ý nghĩa*: Điều phối nguồn lực, giảm trống lịch và tăng trải nghiệm khách hàng.  
   *Vai trò*: Trung tâm vận hành của hệ thống khám chữa.
6. **Quản lý lịch làm việc bác sĩ**  
   *Mục đích*: Tạo và điều chỉnh lịch làm việc theo ngày/khung giờ.  
   *Ý nghĩa*: Bảo đảm phân bổ nhân sự hợp lý và hỗ trợ đặt lịch chính xác.  
   *Vai trò*: Đầu vào để kiểm tra slot trống khi khách đặt lịch.
7. **Dashboard thống kê**  
   *Mục đích*: Theo dõi tổng quan khách hàng, lịch hẹn, dịch vụ, bài viết và các chỉ số theo thời gian.  
   *Ý nghĩa*: Cung cấp dữ liệu điều hành và quyết định quản trị.  
   *Vai trò*: Công cụ giám sát hiệu quả hoạt động của phòng khám.
8. **Duyệt yêu cầu đổi/hủy lịch**  
   *Mục đích*: Xem, phê duyệt hoặc từ chối yêu cầu từ khách hàng.  
   *Ý nghĩa*: Đảm bảo thay đổi lịch có kiểm soát, tránh bỏ sót hoặc chồng chéo.  
   *Vai trò*: Hoàn thiện vòng đời lịch hẹn và giữ ổn định vận hành.

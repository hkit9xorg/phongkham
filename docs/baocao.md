# TỔNG QUAN VỀ ĐỀ TÀI

## Lý do chọn đề tài
Việc chuyển đổi số trong lĩnh vực chăm sóc sức khỏe đang diễn ra nhanh chóng, nhưng nhiều phòng khám nhỏ vẫn quản lý lịch hẹn, hồ sơ bệnh nhân và nội dung truyền thông bằng phương pháp thủ công. Điều này dẫn đến sai sót, trùng lịch, khó kiểm soát dữ liệu và thiếu trải nghiệm người dùng hiện đại. Nhóm quyết định xây dựng hệ thống quản lý phòng khám nha khoa trực tuyến nhằm giải quyết bài toán trên. Đề tài giúp rèn luyện kỹ năng phân tích nghiệp vụ, thiết kế cơ sở dữ liệu và triển khai ứng dụng web full-stack. Hệ thống tập trung vào luồng đặt lịch, phân công bác sĩ, theo dõi hồ sơ, đồng thời hỗ trợ quản trị nội dung. Đây là nhu cầu thực tế của nhiều phòng khám vừa và nhỏ, giúp tối ưu nguồn lực và nâng cao chất lượng phục vụ. Khi áp dụng, khách hàng có thể đặt hẹn và theo dõi thông tin mọi lúc, bác sĩ chủ động chuẩn bị chuyên môn, còn quản trị viên dễ dàng điều phối. Đề tài cũng là cơ hội thực hành bảo mật, phân quyền và tối ưu hiệu năng trên hạ tầng phổ biến. Cuối cùng, sản phẩm đóng vai trò bài tập tổng hợp, kết nối các môn học về cơ sở dữ liệu, lập trình web, kiểm thử và vận hành. Ngoài ra, việc triển khai một hệ thống phục vụ thực tế còn tạo điều kiện cho nhóm trao đổi với người dùng cuối, ghi nhận phản hồi và học cách cải tiến sản phẩm. Từ góc nhìn nghề nghiệp, kinh nghiệm này giúp sinh viên hiểu chu kỳ phát triển phần mềm, từ thu thập yêu cầu, thiết kế, lập trình đến nghiệm thu và bảo trì.

## Mục đích nghiên cứu
Mục đích của nghiên cứu là xây dựng một hệ thống web hỗ trợ phòng khám nha khoa quản lý toàn bộ vòng đời lịch hẹn và hồ sơ bệnh nhân theo cách an toàn, minh bạch. Hệ thống phải cho phép khách hàng tự đăng ký, đặt hẹn, theo dõi trạng thái, gửi yêu cầu đổi hoặc hủy. Bác sĩ cần xem lịch được phân công, cập nhật ghi chú khám và tạo lịch tái khám. Quản trị viên quản lý tài khoản, dịch vụ, bài viết, lịch hẹn, lịch làm việc và duyệt yêu cầu. Sản phẩm nhắm đến tính tiện lợi, giảm thời gian xử lý thủ công và nâng cao trải nghiệm cho tất cả bên liên quan.

## Phương pháp nghiên cứu
Nhóm áp dụng phương pháp phân tích và thiết kế hướng đối tượng, kết hợp mô hình hóa quy trình bằng các sơ đồ UML. Các yêu cầu được thu thập và phân loại theo loại người dùng, sau đó chuyển hóa thành use case và sơ đồ phân rã chức năng. Thiết kế cơ sở dữ liệu dựa trên ERD và sơ đồ lớp để đảm bảo tính toàn vẹn và khả năng mở rộng. Về triển khai, nhóm sử dụng ngăn xếp PHP, MySQL, kết hợp HTML/CSS/JavaScript cho giao diện và AJAX cho tương tác bất đồng bộ. Kiểm thử chức năng được thực hiện thông qua quy trình thử nghiệm mô tả trong `quytrinhtest.md`, bao gồm kịch bản đăng nhập, đặt lịch, xử lý lịch hẹn. Phương pháp so sánh trước-sau giữa quy trình thủ công và hệ thống đề xuất được dùng để đánh giá hiệu quả.
Nhóm cũng tham khảo tài liệu từ các hệ thống đặt lịch y tế hiện có để đối chiếu quy trình, từ đó điều chỉnh trải nghiệm người dùng cho phù hợp với bối cảnh phòng khám nha khoa. Các giả lập dữ liệu được tạo ra để đo đạc thời gian phản hồi của các API chính như đặt lịch, đổi lịch và tải dashboard. Phần bảo mật được rà soát dựa trên danh sách kiểm tra OWASP Top 10, tập trung vào xác thực, phân quyền, SQL injection và lộ lọt thông tin nhạy cảm. Ngoài ra, nhóm áp dụng phương pháp phỏng vấn nhanh với người dùng giả định (sinh viên, nhân viên văn phòng) để thu thập kỳ vọng về giao diện và thông báo trạng thái.

## Phạm vi nghiên cứu
Phạm vi tập trung vào nghiệp vụ chính của phòng khám nha khoa quy mô nhỏ đến vừa, với ba nhóm người dùng: khách hàng, bác sĩ và quản trị viên. Hệ thống quản lý lịch hẹn, hồ sơ bệnh nhân, danh mục dịch vụ, bài viết truyền thông và lịch làm việc của bác sĩ. Không đi sâu vào thanh toán trực tuyến, không tích hợp bảo hiểm y tế, không xử lý đơn thuốc điện tử. Môi trường triển khai giả định trên máy chủ web phổ biến với PHP và MySQL, chưa bao gồm hạ tầng container hóa hay CI/CD phức tạp. Các tính năng nâng cao như chatbot, gợi ý dịch vụ bằng AI chỉ nằm trong hướng phát triển tương lai.
Ngoài phạm vi chính, nhóm cũng xác định một số ràng buộc để tránh lệch hướng: (1) Không xử lý lưu trữ ảnh y khoa dung lượng lớn; (2) Không hỗ trợ chữ ký số hay lưu trữ bệnh án điện tử theo chuẩn quốc gia; (3) Không tích hợp thanh toán cổng quốc tế trong giai đoạn đầu. Thay vào đó, hệ thống tập trung vào tính ổn định của luồng lịch hẹn, tính dễ dùng của giao diện và tính toàn vẹn dữ liệu. Phạm vi này phù hợp với thời gian thực hiện đồ án và nguồn lực sinh viên.

# CƠ SỞ LÝ THUYẾT

## Tổng quan về các công nghệ sử dụng
### PHP (ngôn ngữ backend)
PHP được chọn vì dễ triển khai trên các hosting phổ biến và có cộng đồng lớn. Cú pháp linh hoạt hỗ trợ thao tác nhanh với biểu mẫu, phiên làm việc và truy cập cơ sở dữ liệu. Thư viện chuẩn cùng PDO cho phép kết nối MySQL an toàn qua prepared statements. Đây cũng là ngôn ngữ quen thuộc với sinh viên, giúp giảm thời gian học công cụ mới. PHP phù hợp với mô hình MVC đơn giản được áp dụng trong thư mục `controllers`, `models` và `views`.
Khi triển khai thực tế, PHP có thể kết hợp với Composer để quản lý thư viện, hỗ trợ mở rộng tính năng như gửi email hoặc xác thực JWT nếu cần API cho mobile. Việc chạy trên máy chủ Apache hoặc Nginx với PHP-FPM cũng phổ biến, dễ cấu hình, giúp phòng khám không cần đầu tư hạ tầng phức tạp. Cộng đồng rộng lớn giúp tìm kiếm giải pháp cho các lỗi phổ biến nhanh chóng, giảm thời gian khắc phục sự cố.

### MySQL (hệ quản trị cơ sở dữ liệu)
MySQL là hệ quản trị quan hệ phổ biến, hiệu năng tốt cho khối lượng vừa phải và dễ cấu hình. Với InnoDB, MySQL hỗ trợ khóa ngoại, giao dịch và ràng buộc toàn vẹn cần thiết cho dữ liệu y tế. Cấu trúc bảng được mô tả trong `database.sql` và được ánh xạ với các lớp model như `Appointment` hay `Service`. MySQL cũng có hệ sinh thái phong phú về công cụ quản trị, sao lưu và giám sát, thuận tiện cho môi trường phòng khám.
Trong giai đoạn phát triển, MySQL hỗ trợ seed dữ liệu để kiểm thử, ví dụ tạo sẵn danh sách dịch vụ, bác sĩ và tài khoản mẫu. Chỉ mục (index) được khuyến nghị trên các cột tìm kiếm như email, số điện thoại, thời gian hẹn để tăng tốc truy vấn. Việc sử dụng view hoặc stored procedure có thể cân nhắc cho báo cáo, nhưng đề tài ưu tiên logic ở tầng PHP để dễ bảo trì. Sao lưu định kỳ thông qua `mysqldump` hoặc công cụ GUI đảm bảo dữ liệu an toàn khi thử nghiệm.

### HTML/CSS/JavaScript (frontend)
Giao diện người dùng xây dựng bằng HTML5, CSS3 và JavaScript thuần, dễ kiểm soát và tối ưu cho tốc độ tải. CSS đảm nhận bố cục responsive để khách hàng có thể đặt lịch trên thiết bị di động. JavaScript được dùng cho kiểm tra dữ liệu đầu vào, gọi AJAX tới API và cập nhật DOM theo thời gian thực. Việc tránh phụ thuộc framework lớn giúp ứng dụng nhẹ, phù hợp hạ tầng hạn chế của phòng khám.
Các trang giao diện được tách thành phần theo chức năng để dễ bảo trì, ví dụ header, footer, biểu mẫu đặt lịch, bảng lịch hẹn. CSS có thể sử dụng Flexbox và Grid để tối ưu bố cục, trong khi JavaScript dùng Fetch API hoặc XMLHttpRequest cho AJAX. Việc cache tài nguyên tĩnh (CSS, JS) trên trình duyệt giúp tăng tốc tải trang cho khách truy cập nhiều lần. Thực hành kiểm tra đầu vào phía client kết hợp kiểm tra phía server giúp giảm lỗi và nâng cao bảo mật.

### AJAX và JSON
AJAX cho phép gửi yêu cầu đổi lịch, hủy lịch hoặc lấy danh sách lịch hẹn mà không cần tải lại trang. Dữ liệu trao đổi định dạng JSON giúp đơn giản hóa parse và hiển thị. Cách tiếp cận này nâng cao trải nghiệm người dùng, giảm độ trễ và băng thông. Trong sơ đồ tuần tự, các bước phản hồi JSON được mô tả để cập nhật giao diện kịp thời.
AJAX còn giúp triển khai tính năng tìm kiếm thời gian thực, ví dụ gợi ý dịch vụ hoặc lọc lịch hẹn theo trạng thái. JSON được sử dụng nhất quán giữa backend và frontend, giúp việc debug và log trở nên minh bạch. Với những thao tác nhạy cảm, phản hồi JSON bao gồm mã trạng thái, thông báo và dữ liệu bổ sung để giao diện hiển thị thông tin lỗi chính xác cho người dùng.

### Bảo mật và phân quyền
Hệ thống áp dụng xác thực phiên làm việc và phân quyền dựa trên vai trò (admin/doctor/customer). Mỗi controller kiểm tra session và quyền trước khi thực thi chức năng nhạy cảm như quản lý tài khoản hoặc ghi chú khám. Mã hóa mật khẩu sử dụng thuật toán băm an toàn của PHP. Ngoài ra, việc dùng prepared statements với PDO giảm rủi ro SQL injection. Các yêu cầu đổi/hủy lịch phải được duyệt để tránh thao tác trái phép.
Nhóm cũng cân nhắc các biện pháp bổ sung như giới hạn số lần đăng nhập sai, log hành vi quản trị và kiểm soát truy cập theo IP cho khu vực quản trị. CSRF token được đề xuất cho các biểu mẫu quan trọng như thay đổi mật khẩu hoặc cập nhật hồ sơ bệnh nhân. Việc phân quyền chi tiết ở mức chức năng (ví dụ bác sĩ không thể xóa tài khoản khách) giúp hạn chế rủi ro nội bộ.

# HỆ THỐNG QUẢN LÝ PHÒNG KHÁM NHA KHOA TRỰC TUYẾN

## Phân tích hệ thống
### Các đối tượng sử dụng hệ thống
- **Khách hàng**: người đặt lịch khám, theo dõi trạng thái, gửi yêu cầu đổi hoặc hủy, xem hồ sơ và bài viết. Họ là tác nhân chính trong kênh tự phục vụ.
- **Bác sĩ**: người được phân công lịch hẹn, xem lịch làm việc, cập nhật ghi chú khám và tạo lịch tái khám cho bệnh nhân của mình.
- **Quản trị viên**: người điều phối toàn bộ hệ thống, quản lý tài khoản, dịch vụ, bài viết, hồ sơ bệnh nhân, lịch làm việc, lịch hẹn và phê duyệt yêu cầu đổi/hủy.

### Yêu cầu chức năng tổng quát
- Đăng ký, đăng nhập và phân quyền theo vai trò.
- Đặt lịch hẹn công khai hoặc sau đăng nhập, ghi nhận thông tin liên hệ và dịch vụ quan tâm.
- Quản trị viên xác nhận lịch hẹn, phân công bác sĩ, cập nhật trạng thái, ghi chú và điều chỉnh lịch khi cần.
- Khách hàng xem danh sách lịch hẹn của mình, theo dõi trạng thái, nhận thông báo về đổi/hủy.
- Bác sĩ xem lịch được giao, cập nhật ghi chú khám, tạo và đổi lịch tái khám.
- Quản lý danh mục dịch vụ, bài viết truyền thông, hồ sơ bệnh nhân và lịch làm việc bác sĩ.
- Dashboard thống kê tình hình lịch hẹn, khách hàng, dịch vụ và bài viết.
- Duyệt yêu cầu đổi/hủy lịch từ khách hàng theo quy trình kiểm soát.

### Yêu cầu phi chức năng
- **Bảo mật**: xác thực phiên, phân quyền rõ ràng, băm mật khẩu, kiểm soát truy cập API. Yêu cầu đổi/hủy phải qua bước duyệt để tránh phá hoại.
- **Hiệu năng**: phản hồi nhanh cho các thao tác lịch hẹn và dashboard, tối ưu truy vấn MySQL và giảm tải bằng phân trang.
- **Tính sẵn sàng**: dễ triển khai trên hosting phổ biến, có hướng dẫn backup dữ liệu.
- **Khả năng mở rộng**: kiến trúc MVC và mô hình dữ liệu chuẩn hóa giúp mở rộng tính năng như thanh toán, nhắc lịch tự động.
- **Trải nghiệm người dùng**: giao diện rõ ràng, hỗ trợ thiết bị di động, thông báo trạng thái kịp thời qua AJAX.
- **Khả năng bảo trì**: mã nguồn tách lớp controller/model/view, có sơ đồ và tài liệu để dễ tiếp nhận.
 - **Khả năng tích hợp**: API có thể mở rộng để đồng bộ với ứng dụng di động hoặc hệ thống CRM, đảm bảo dữ liệu nhất quán.
 - **Khả năng giám sát**: hệ thống cần log sự kiện quan trọng, hỗ trợ kiểm tra và khắc phục sự cố nhanh chóng.
Các yêu cầu phi chức năng này được xem là tiêu chí đánh giá khi nghiệm thu, giúp hệ thống không chỉ hoạt động đúng mà còn bền vững, dễ vận hành.

### Quy trình nghiệp vụ hệ thống
Quy trình bắt đầu khi khách hàng truy cập website, xem dịch vụ, bài viết và đặt lịch bằng biểu mẫu. Hệ thống ghi nhận yêu cầu, gửi thông báo cho quản trị viên kiểm tra slot trống và lịch làm việc bác sĩ. Quản trị viên xác nhận lịch hẹn, phân công bác sĩ, cập nhật trạng thái "đã xác nhận" hoặc "từ chối". Bác sĩ xem danh sách được giao, chuẩn bị khám và thêm ghi chú sau buổi khám. Nếu cần tái khám, bác sĩ tạo lịch tái khám, đồng bộ vào lịch làm việc. Khách hàng có thể gửi yêu cầu đổi hoặc hủy lịch, quản trị viên xem xét và phê duyệt; kết quả phản hồi về khách qua giao diện. Các dữ liệu phát sinh cập nhật vào cơ sở dữ liệu, hiển thị trong dashboard để theo dõi hiệu quả hoạt động.
Trong trường hợp khách hàng không đăng nhập, yêu cầu đặt lịch vẫn được ghi nhận với thông tin liên hệ tối thiểu, sau đó quản trị viên liên hệ xác nhận và gắn tài khoản nếu cần. Các yêu cầu đổi/hủy được kiểm tra điều kiện thời gian (ví dụ trước giờ khám 24h) trước khi cho phép gửi, nhằm hạn chế ảnh hưởng đến lịch của bác sĩ. Quy trình cũng đề xuất ghi log cho từng trạng thái thay đổi để phục vụ truy vết khi có khiếu nại.

## Thiết kế sơ đồ
### Sơ đồ Use Case Khách hàng
Sơ đồ mô tả tác nhân khách hàng và các ca sử dụng: đăng ký tài khoản, đăng nhập, đặt lịch, xem lịch, yêu cầu đổi/hủy, xem bài viết và dịch vụ. Mỗi ca sử dụng giúp khách thực hiện tự phục vụ mà không cần gọi điện. Mối liên hệ giữa tác nhân và ca sử dụng thể hiện phạm vi chức năng công khai và sau đăng nhập. Sơ đồ giúp đội phát triển đảm bảo UI và API phục vụ đầy đủ các bước của khách hàng.

### Sơ đồ Use Case Bác sĩ
Tác nhân bác sĩ gắn với ca sử dụng xem lịch làm việc, xem lịch hẹn được phân công, cập nhật ghi chú, tạo và đổi lịch tái khám. Sơ đồ nhấn mạnh rằng bác sĩ chỉ thao tác trên lịch được giao, tránh xung đột với quyền quản trị. Từng ca sử dụng hỗ trợ luồng công việc sau khi quản trị viên phân công, đảm bảo bác sĩ có thông tin bệnh nhân trước khi khám. Việc hiển thị rõ ràng giúp kiểm thử vai trò và xác thực đầu vào.

### Sơ đồ Use Case Quản trị viên
Sơ đồ cho thấy quản trị viên là trung tâm điều phối, thực hiện các ca sử dụng: quản lý tài khoản, bài viết, dịch vụ, hồ sơ bệnh nhân, lịch hẹn, lịch làm việc, dashboard và duyệt yêu cầu đổi/hủy. Các ca sử dụng liên kết với nhau để bảo đảm dữ liệu nhất quán, ví dụ quản lý lịch hẹn phụ thuộc danh sách dịch vụ và lịch làm việc bác sĩ. Sơ đồ hỗ trợ kiểm tra quyền hạn và luồng phê duyệt.

### Sơ đồ phân rã chức năng
Sơ đồ phân rã trình bày hệ thống dưới dạng cây chức năng, gốc là "Quản lý phòng khám" và các nhánh: Quản lý người dùng, Quản lý dịch vụ, Quản lý lịch hẹn, Quản lý lịch làm việc, Quản lý nội dung, Dashboard. Mỗi nhánh lại chia thành chức năng con như tạo tài khoản, phân quyền, xác nhận lịch, duyệt đổi/hủy. Cấu trúc cây giúp lập kế hoạch phát triển theo từng cụm, đánh giá độ ưu tiên và phân công nhân sự.

### Sơ đồ tuần tự
Sơ đồ tuần tự minh họa luồng đổi lịch: khách hàng gửi yêu cầu qua frontend, API nhận và lưu vào DB, thông báo đến quản trị viên. Quản trị viên mở giao diện phê duyệt, cập nhật trạng thái, hệ thống điều chỉnh lịch hẹn và trả phản hồi JSON. Trình duyệt khách cập nhật UI, hiển thị kết quả duyệt. Sơ đồ chỉ ra các điểm kiểm tra quyền, ghi log và xử lý lỗi, giúp giảm sai sót khi triển khai.

### Sơ đồ lớp
Sơ đồ lớp định nghĩa các lớp User, PatientProfile, Service, Appointment, Article, DoctorSchedule cùng thuộc tính và quan hệ. User liên kết với vai trò và thông tin đăng nhập; PatientProfile lưu dữ liệu y tế; Service mô tả dịch vụ nha khoa; Appointment nối User, Service và DoctorSchedule; Article lưu nội dung truyền thông; DoctorSchedule quản lý khung giờ làm việc. Quan hệ giữa các lớp tạo nền tảng cho thiết kế bảng và API, bảo đảm tái sử dụng và dễ bảo trì.

### Sơ đồ ERD
Sơ đồ ERD chuyển hóa lớp thành bảng: `users`, `roles`, `patients`, `services`, `appointments`, `articles`, `doctor_schedules`, cùng các khóa ngoại liên kết. Ràng buộc khóa ngoại bảo vệ toàn vẹn dữ liệu, ví dụ `appointments.user_id` tham chiếu `users.id`, `appointments.service_id` tham chiếu `services.id`. ERD cũng chỉ ra các thuộc tính thời gian, trạng thái và ghi chú cần thiết cho truy vấn dashboard. Đây là tài liệu tham chiếu khi viết migration và đối chiếu với `database.sql`.

## Thiết kế cơ sở dữ liệu
(Để trống)

## Thiết kế giao diện
### Đăng ký và đăng nhập
Giao diện đăng ký cung cấp biểu mẫu nhập họ tên, email, số điện thoại, mật khẩu, giúp khách tạo tài khoản để theo dõi lịch hẹn. Giao diện đăng nhập đơn giản với trường email và mật khẩu, kèm thông báo lỗi rõ ràng khi nhập sai. Sau khi đăng nhập, hệ thống áp dụng phân quyền để hiển thị menu phù hợp với khách hàng, bác sĩ hoặc quản trị viên. Thiết kế responsive cho phép thao tác trên di động.

### Đặt lịch hẹn công khai
Trang đặt lịch công khai cho phép khách nhập thông tin liên hệ, dịch vụ quan tâm, thời gian mong muốn và ghi chú. Hệ thống kiểm tra đầu vào, lưu yêu cầu và thông báo chờ xác nhận từ quản trị viên. Nếu khách đã đăng nhập, dữ liệu tự điền từ hồ sơ để giảm thao tác. Giao diện nhấn mạnh các bước đơn giản, giúp người mới dễ sử dụng.

### Quản lý lịch hẹn cho quản trị viên
Trang quản trị hiển thị danh sách lịch hẹn, bộ lọc theo trạng thái, dịch vụ, bác sĩ và thời gian. Mỗi dòng cho phép xem chi tiết, xác nhận, phân công bác sĩ, đổi lịch, hủy lịch hoặc thêm ghi chú. Hành động cập nhật thực hiện qua AJAX để giảm thời gian tải. Thông báo trạng thái gửi lại cho khách hàng qua giao diện đặt lịch. Mục tiêu là điều phối nhanh, hạn chế trùng lịch.

### Xem lịch hẹn cho khách hàng
Sau đăng nhập, khách vào trang "Lịch hẹn của tôi" để xem danh sách, trạng thái, bác sĩ phụ trách và thời gian. Mỗi lịch hẹn có nút gửi yêu cầu đổi hoặc hủy kèm lý do. Phản hồi duyệt hiển thị trực tiếp trong bảng, giúp khách chủ động theo dõi. Giao diện ưu tiên sự rõ ràng, màu sắc thể hiện trạng thái để giảm nhầm lẫn.

### Xem lịch làm việc và lịch phân công cho bác sĩ
Bác sĩ đăng nhập sẽ thấy lịch làm việc theo ngày/tuần, kèm danh sách lịch hẹn được giao. Mỗi mục cho phép mở chi tiết bệnh nhân, dịch vụ và ghi chú trước đó. Bác sĩ có nút cập nhật ghi chú khám sau buổi khám và tạo lịch tái khám. Thiết kế tập trung vào tính nhanh gọn, hỗ trợ chuẩn bị chuyên môn.

### Quản lý hồ sơ bệnh nhân
Quản trị viên truy cập trang hồ sơ để tạo mới, chỉnh sửa thông tin y tế, tiền sử bệnh, dị ứng. Hồ sơ liên kết với tài khoản khách, hiển thị lịch sử lịch hẹn và ghi chú khám. Giao diện cho phép tìm kiếm theo tên, số điện thoại, email. Mục tiêu là cung cấp đầy đủ thông tin cho bác sĩ và giảm trùng lặp dữ liệu.

### Quản lý dịch vụ nha khoa
Trang dịch vụ cho quản trị viên cung cấp bảng CRUD: thêm dịch vụ, giá, mô tả, trạng thái hiển thị. Dữ liệu dịch vụ được dùng trong biểu mẫu đặt lịch và tư vấn của bác sĩ. Giao diện hỗ trợ bật/tắt nhanh trạng thái hiển thị để kiểm soát dịch vụ tạm dừng. Các trường bắt buộc được kiểm tra để tránh thiếu thông tin.

### Quản lý bài viết (tin tức/tư vấn)
Quản trị viên có trang quản lý bài viết để đăng, chỉnh sửa, xóa nội dung tư vấn nha khoa. Biên tập viên nhập tiêu đề, tóm tắt, nội dung chi tiết, ảnh minh họa và trạng thái xuất bản. Bài viết hiển thị công khai để khách đọc và nâng cao nhận thức, từ đó thúc đẩy nhu cầu đặt lịch. Giao diện hỗ trợ tìm kiếm theo tiêu đề và lọc theo trạng thái để quản lý nhanh.

### Dashboard thống kê
Dashboard tổng hợp số lượng khách hàng, lịch hẹn theo trạng thái, dịch vụ phổ biến, số bài viết và lịch làm việc bác sĩ. Biểu đồ và bảng tóm tắt giúp quản trị viên đánh giá hiệu quả vận hành theo ngày/tuần/tháng. Dữ liệu lấy từ MySQL và cập nhật định kỳ hoặc theo yêu cầu. Mục tiêu là hỗ trợ ra quyết định, tối ưu nguồn lực và nhận diện vấn đề sớm.

## KẾT QUẢ THỰC NGHIỆM

## Kết quả đạt được
Nhóm đã xây dựng mô hình chức năng đầy đủ cho ba vai trò: khách hàng, bác sĩ, quản trị viên. Các use case, sơ đồ phân rã, tuần tự, lớp và ERD đã được tài liệu hóa, hỗ trợ triển khai thống nhất. Chức năng đặt lịch, phân công bác sĩ, cập nhật ghi chú và duyệt đổi/hủy được thiết kế rõ luồng. Hệ thống giao diện được mô tả cho từng nhóm người dùng, đảm bảo tính thân thiện và nhất quán. Tài liệu kiểm thử quy trình chính đã được lên kế hoạch, giúp giảm rủi ro khi phát triển.

## Đánh giá
Đề tài đáp ứng nhu cầu cốt lõi của phòng khám nha khoa với kiến trúc dễ triển khai trên hạ tầng phổ biến. Việc phân quyền rõ ràng giảm rủi ro truy cập trái phép. Tuy nhiên, hệ thống chưa tích hợp thanh toán trực tuyến và thông báo đa kênh, nên trải nghiệm chưa hoàn toàn tự động. Hiệu năng phụ thuộc tối ưu truy vấn MySQL và cấu hình server; cần kiểm thử tải cho môi trường thực tế. Nhìn chung, giải pháp khả thi cho quy mô vừa và nhỏ, có tiềm năng mở rộng.

# KẾT LUẬN VÀ HƯỚNG PHÁT TRIỂN

## Kết quả đạt được 
Tài liệu đã trình bày đầy đủ lý do chọn đề tài, mục đích, phương pháp và phạm vi nghiên cứu. Các sơ đồ phân tích và thiết kế giúp làm rõ luồng nghiệp vụ và cấu trúc dữ liệu. Các chức năng cho từng vai trò được mô tả cụ thể, tạo nền tảng triển khai. Hệ thống hướng đến nâng cao trải nghiệm người dùng, giảm thao tác thủ công và tăng tính minh bạch trong quản lý lịch hẹn.

## Kết quả chưa đạt được 
Chưa có phần thiết kế chi tiết cơ sở dữ liệu đi kèm bảng, trigger, chỉ mục. Chưa tích hợp các tính năng nâng cao như thanh toán, nhắc lịch qua SMS/Email, hoặc phân tích dữ liệu nâng cao. Phần đánh giá hiệu năng và bảo mật mới dừng ở mức lý thuyết, chưa có số liệu thử nghiệm tải. Giao diện thực tế chưa kèm hình ảnh minh họa, cần hoàn thiện trong giai đoạn phát triển.

## Đánh giá và Hướng phát triển 
Trong giai đoạn tới, nhóm sẽ bổ sung chi tiết thiết kế CSDL, tối ưu truy vấn và viết migration chuẩn. Tính năng thanh toán trực tuyến, thông báo tự động, và báo cáo chuyên sâu sẽ được cân nhắc. Hệ thống có thể mở rộng thêm quản lý kho vật tư, lịch sử thanh toán và tích hợp lịch hẹn với ứng dụng di động. Cần thiết lập quy trình CI/CD, kiểm thử tải và rà soát bảo mật định kỳ để sẵn sàng đưa vào vận hành thực tế.

# TÀI LIỆU THAM KHẢO
- Tài liệu UML và phương pháp phân tích hướng đối tượng trong môn Phân tích thiết kế hệ thống thông tin.
- Hướng dẫn sử dụng PHP và PDO từ tài liệu chính thức của php.net.
- Tài liệu MySQL Community Edition và InnoDB từ mysql.com.
- Các bài viết tham khảo về quản lý phòng khám và trải nghiệm người dùng trong ứng dụng y tế.

## Phụ lục đánh giá chi tiết
Để đảm bảo tính khả thi, nhóm xây dựng bộ tiêu chí đánh giá gồm tính đúng chức năng, hiệu năng, bảo mật và khả năng mở rộng. Với chức năng, từng yêu cầu trong phần phân rã được ánh xạ sang ca kiểm thử mô tả trong `quytrinhtest.md`, ví dụ kiểm tra đăng nhập sai mật khẩu, đặt lịch thiếu thông tin, hoặc bác sĩ cập nhật ghi chú không thuộc quyền. Về hiệu năng, nhóm đề xuất kiểm tra thời gian phản hồi cho thao tác lọc lịch hẹn, tải dashboard và gửi yêu cầu đổi lịch trong môi trường có dữ liệu giả lập. Phần bảo mật tập trung vào xác thực phiên, chống SQL injection bằng prepared statements, kiểm tra phân quyền ở controller, và bảo vệ dữ liệu nhạy cảm như hồ sơ bệnh nhân. Khả năng mở rộng xem xét cách tách lớp model, controller, view để sau này có thể bổ sung API mobile hoặc microservice mà không phải viết lại toàn bộ. Các tiêu chí này làm thước đo cho kế hoạch triển khai tiếp theo.

### Đề xuất quy trình vận hành
Trong môi trường thực tế, phòng khám có thể áp dụng quy trình vận hành gồm các bước: (1) Quản trị viên cấu hình danh mục dịch vụ và lịch làm việc bác sĩ; (2) Khách hàng đặt lịch, hệ thống gửi thông báo email xác nhận đã nhận yêu cầu; (3) Quản trị viên duyệt và phân công, hệ thống gửi kết quả qua email/SMS; (4) Bác sĩ chuẩn bị lịch làm việc, tiếp nhận bệnh nhân và ghi chú; (5) Sau buổi khám, bác sĩ tạo lịch tái khám nếu cần, khách nhận thông báo; (6) Định kỳ, quản trị viên xem dashboard để tối ưu lịch làm việc và nguồn lực. Quy trình có thể tích hợp thêm mã QR cho check-in tại quầy, giúp giảm thời gian chờ.

### Rủi ro và biện pháp giảm thiểu
Một số rủi ro được nhận diện: (1) Mất dữ liệu do lỗi phần cứng hoặc thao tác, cần sao lưu định kỳ và có kịch bản phục hồi; (2) Tấn công đăng nhập brute force, cần giới hạn số lần thử và dùng CAPTCHA; (3) Lỗi trùng lịch do thao tác song song, cần khóa logic hoặc kiểm tra slot trước khi xác nhận; (4) Thiếu nhân lực vận hành, nên đào tạo quản trị viên và bác sĩ sử dụng hệ thống qua tài liệu hướng dẫn. Việc áp dụng HTTPS và cấu hình firewall cũng là yêu cầu tối thiểu khi triển khai.

### Kiến nghị về kiểm thử và triển khai
Nhóm kiến nghị sử dụng bộ dữ liệu giả lập gồm danh sách dịch vụ, tài khoản thử (admin/doctor/customer) và một lượng lịch hẹn đủ lớn để kiểm tra giao diện và truy vấn. Kiểm thử chấp nhận người dùng (UAT) nên được thực hiện với nhân viên phòng khám để thu thập phản hồi thực tế. Sau khi ổn định, triển khai lên máy chủ thử nghiệm trước khi phát hành chính thức. Việc ghi log chi tiết cho các thao tác quản trị, đổi/hủy lịch sẽ hỗ trợ truy vết sự cố và tuân thủ yêu cầu kiểm toán nội bộ.

### Hướng nghiên cứu mở rộng
Ở giai đoạn tiếp theo, hệ thống có thể tích hợp nhắc lịch tự động qua SMS/Email, đồng bộ lịch với Google Calendar cho bác sĩ và khách hàng, hoặc bổ sung chatbot trả lời câu hỏi thường gặp. Tính năng phân tích dữ liệu có thể dùng để dự báo nhu cầu theo mùa, giúp phòng khám chủ động sắp xếp nhân sự. Ngoài ra, có thể nghiên cứu chuẩn HL7/FHIR để trao đổi dữ liệu y tế với hệ thống khác. Nếu quy mô lớn, chuyển dần sang kiến trúc microservices hoặc sử dụng Redis làm cache cho dashboard. Những hướng này giúp hệ thống tiến tới chuẩn mực của các nền tảng y tế hiện đại.

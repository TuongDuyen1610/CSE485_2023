<?php
// Kết nối đến cơ sở dữ liệu
// Kết nối đến cơ sở dữ liệu
$servername = "localhost"; // Thay bằng thông tin server của bạn
$username = "root";        // Thay bằng username cơ sở dữ liệu
$password = "";            // Thay bằng mật khẩu cơ sở dữ liệu
$dbname = "btth01_cse485_ex"; // Thay bằng tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Sử dụng prepared statement để ngăn ngừa SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass); // 'ss' là để chỉ 2 chuỗi
    $stmt->execute();
    $result = $stmt->get_result();
    $row_check = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        // Nếu username và password hợp lệ
        // Bắt đầu session để lưu thông tin đăng nhập nếu cần
        session_start();
        $_SESSION['username'] = $user;

        if ($row_check['role'] == 'admin'){
            //Chuyển đến trang a
            header("Location: admin/index.php");
            exit(); // Luôn dùng exit sau header để đảm bảo không tiếp tục thực thi mã
        } else{
            header("Location: index.php");
            exit();
        }
    } else {
        // Nếu không hợp lệ, hiển thị thông báo
        echo "<div class='alert alert-danger'>Tên đăng nhập hoặc mật khẩu không đúng!</div>";
    }

    $stmt->close();
}

$conn->close();
?>

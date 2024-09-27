<?php
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

require_once APP_ROOT . '/models/User.php';

class LoginController {
    public function index() {
        $userService = new UserService();

        // Kiểm tra người dùng
        $users = $userService->checkUser();
        if ($users) {
            // Nếu đăng nhập thành công, chuyển hướng đến HomeController
            header("Location: /btth02v2/controllers/HomeController.php?action=home");
            exit(); // Dừng thực thi sau khi chuyển hướng
        } else {
            // Nếu không thành công, quay lại trang login hoặc hiển thị thông báo lỗi
            require_once APP_ROOT . '/views/login/login.php'; // Đảm bảo bạn có view login
        }
    }
}

// Khởi tạo đối tượng LoginController và gọi phương thức index
$myObj = new LoginController();
$myObj->index();


<?php
/*Home trang admin*/
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

require_once APP_ROOT . '/configs/DBConnection.php';
require_once APP_ROOT . '/models/Admin.php';

class HomeController {
    private $adminModel;

    public function __construct($dbConnection) {
        $this->adminModel = new AdminModel($dbConnection);
    }

    public function index() {
        // Lấy số lượng bài viết, thể loại, tác giả và người dùng từ cơ sở dữ liệu
        $countArticles = $this->adminModel->getCount('baiviet');
        $countCategories = $this->adminModel->getCount('theloai');
        $countAuthors = $this->adminModel->getCount('tacgia');
        $countUsers = $this->adminModel->getCount('users'); // Đếm số lượng người dùng

        // Chuẩn bị dữ liệu cho view
        $data = [
            'count_baiviet' => $countArticles,
            'count_theloai' => $countCategories,
            'count_tacgia' => $countAuthors,
            'count_users' => $countUsers, // Thêm số lượng người dùng vào dữ liệu
        ];

        // Gọi view cho trang chính với dữ liệu đã lấy
        require_once APP_ROOT . '/views/admin/index.php';
    }
}

// Xử lý route cho HomeController
function handleHomeRoute() {
    // Tạo kết nối cơ sở dữ liệu
    $dbConnection = new DBConnection(); 
    $homeController = new HomeController($dbConnection->getConnection());
    $homeController->index();
}

// Kiểm tra route và gọi controller tương ứng
if (isset($_GET['action']) && $_GET['action'] === 'home') {
    handleHomeRoute();
} else {
    // Nếu không có action, cũng xử lý như trang chính
    handleHomeRoute();
}

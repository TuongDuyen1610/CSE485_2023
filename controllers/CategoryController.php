<?php
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../configs/DBConnection.php';

class CategoryController {
    private $model;
    private $dbConnection;

    public function __construct() {
        $this->dbConnection = new DBConnection(); // Khởi tạo kết nối
        $db = $this->dbConnection->getConnection();
        $this->model = new Category($db); 
    }

    // Phương thức để liệt kê tất cả các danh mục
    public function listCategories() {
        $categories = $this->model->getAllCategories();
        include_once __DIR__ . '/../views/category/CategoryView.php'; // Gọi view để hiển thị danh sách
    }

    // Phương thức để thêm thể loại
    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? ''; // Lấy tên thể loại từ form

            if (!empty($name)) {
                $this->model->addCategory($name); // Thêm thể loại
                header('Location: /btth02v2/controllers/CategoryController.php?action=list'); // Chuyển hướng về danh sách
                exit();
            }
        }
        
        include_once __DIR__ . '/../views/category/AddCategoryView.php'; // Hiển thị form thêm thể loại
    }

    // Phương thức để sửa thể loại
    public function editCategory($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? ''; // Lấy tên thể loại từ form

            if (!empty($name)) {
                $this->model->editCategory($id, $name); // Cập nhật thể loại
                header('Location: /btth02v2/controllers/CategoryController.php?action=list'); // Chuyển hướng về danh sách
                exit();
            }
        }

        $category = $this->model->getCategoryById($id); // Lấy thông tin thể loại để hiển thị trong form
        include_once __DIR__ . '/../views/category/EditCategoryView.php'; // Hiển thị form sửa thể loại
    }

    // Phương thức để xóa thể loại
    public function deleteCategory($id) {
        $this->model->deleteCategory($id); // Xóa thể loại
        header('Location: /btth02v2/controllers/CategoryController.php?action=list'); // Chuyển hướng về danh sách
        exit();
    }
}

// Khởi tạo controller và gọi phương thức tương ứng dựa trên action
$controller = new CategoryController();

$action = $_GET['action'] ?? 'list'; // Lấy action từ URL, mặc định là list

switch ($action) {
    case 'add':
        $controller->addCategory();
        break;
    case 'edit':
        $id = $_GET['id'] ?? 0;
        $controller->editCategory($id);
        break;
    case 'delete':
        $id = $_GET['id'] ?? 0;
        $controller->deleteCategory($id);
        break;
    case 'list':
    default:
        $controller->listCategories();
        break;
}
?>

<?php
require_once __DIR__ . '/../models/Article.php';

// Đặt múi giờ cho Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

class ArticleController
{
    private $model;

    public function __construct()
    {
        $this->model = new Article(); // Khởi tạo đối tượng Article
    }

    // Phương thức để liệt kê tất cả bài viết
    public function listArticles()
    {
        $articles = $this->model->getAllArticles();
        include_once __DIR__ . '/../views/article/list_article.php';

        if (isset($_GET['action'])) {
            $this->handleAction($_GET['action']);
        }
    }

    // Xử lý các hành động thêm, sửa, xóa
    private function handleAction($action)
    {
        switch ($action) {
            case 'add':
                $this->addArticle();
                break;
            case 'edit':
                if (isset($_GET['id'])) {
                    $this->editArticle($_GET['id']);
                }
                break;
            case 'delete':
                if (isset($_GET['id'])) {
                    $this->deleteArticle($_GET['id']);
                }
                break;
            default:
                // Hành động không hợp lệ, có thể thông báo lỗi hoặc bỏ qua
                break;
        }
    }

    // Phương thức để lấy danh sách thể loại
    public function getCategories()
    {
        return $this->model->getCategories(); // Lấy danh sách thể loại từ model
    }

    // Phương thức để lấy danh sách tác giả
    public function getAuthors()
    {
        return $this->model->getAuthors(); // Lấy danh sách tác giả từ model
    }

    // Phương thức để thêm bài viết
    public function addArticle()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nhận dữ liệu từ biểu mẫu
            $data = [
                'tieude' => $_POST['tieude'],
                'ten_bhat' => $_POST['ten_bhat'],
                'ma_tloai' => $_POST['ma_tloai'],  // Lấy mã thể loại
                'tomtat' => $_POST['tomtat'],
                'ma_tgia' => $_POST['ma_tgia'],    // Lấy mã tác giả
                'ngayviet' => date('Y-m-d H:i:s')
            ];

            // Xử lý upload hình ảnh (nếu có)
            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == UPLOAD_ERR_OK) {
                $data['hinhanh'] = $_FILES['hinhanh']['name'];
                move_uploaded_file($_FILES['hinhanh']['tmp_name'], "../../assets/images/" . $data['hinhanh']);
            } else {
                // Nếu không có ảnh thì set mặc định hoặc bỏ qua
                $data['hinhanh'] = null; // Không cần hình ảnh
            }

            // Thêm bài viết vào cơ sở dữ liệu
            if ($this->model->addArticle($data)) {
                header("Location: /btth02v2/controllers/ArticleController.php");
                exit();
            } else {
                echo "Thêm bài viết thất bại.";
            }
        } else {
            // Lấy danh sách thể loại và tác giả để hiển thị trong form thêm
            $categories = $this->getCategories();
            $authors = $this->getAuthors();
            include_once __DIR__ . '/../views/article/add_article.php';
        }
    }

    // Phương thức để sửa bài viết
    public function editArticle($id)
    {
        $article = $this->model->getArticleById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nhận dữ liệu từ biểu mẫu
            $data = [
                'ma_bviet' => $id,
                'tieude' => $_POST['tieude'],
                'ten_bhat' => $_POST['ten_bhat'],
                'ma_tloai' => $_POST['ma_tloai'],  // Lấy mã thể loại từ POST
                'tomtat' => $_POST['tomtat'],
                'ma_tgia' => $_POST['ma_tgia'],    // Lấy mã tác giả từ POST
                'ngayviet' => date('Y-m-d H:i:s')
            ];

            // Xử lý upload hình ảnh nếu có
            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == UPLOAD_ERR_OK) {
                $data['hinhanh'] = $_FILES['hinhanh']['name'];
                move_uploaded_file($_FILES['hinhanh']['tmp_name'], "../../assets/images/" . $data['hinhanh']);
            } else {
                // Giữ nguyên hình ảnh cũ nếu không có hình ảnh mới
                $data['hinhanh'] = $article['hinhanh'];
            }

            // Cập nhật bài viết trong cơ sở dữ liệu
            if ($this->model->updateArticle($data)) {
                header("Location: /btth02v2/controllers/ArticleController.php"); // Chuyển hướng về trang danh sách bài viết
                exit();
            } else {
                echo "Sửa bài viết thất bại.";
            }
        } else {
            // Lấy danh sách thể loại và tác giả để hiển thị trong form sửa
            $categories = $this->getCategories();
            $authors = $this->getAuthors();
            include_once __DIR__ . '/../views/article/edit_article.php';
        }
    }

    // Phương thức để xóa bài viết
    public function deleteArticle($id)
    {
        if ($this->model->deleteArticle($id)) {
            header("Location: /btth02v2/controllers/ArticleController.php"); // Chuyển hướng về trang danh sách bài viết
            exit();
        } else {
            echo "Xóa bài viết thất bại.";
        }
    }
}

// Xử lý route dựa trên hành động
if (isset($_GET['action'])) {
    $controller = new ArticleController();

    switch ($_GET['action']) {
        case 'add':
            $controller->addArticle();
            break;
        case 'edit':
            if (isset($_GET['id'])) {
                $controller->editArticle($_GET['id']);
            }
            break;
        case 'delete':
            if (isset($_GET['id'])) {
                $controller->deleteArticle($_GET['id']);
            }
            break;
        default:
            $controller->listArticles();
            break;
    }
} else {
    $controller = new ArticleController();
    $controller->listArticles();
}

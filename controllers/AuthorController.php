<?php
require_once __DIR__ . '/../models/Author.php';

class AuthorController
{
    private $model;

    public function __construct()
    {
        $this->model = new Author(); // Khởi tạo đối tượng Article
    }

    // Phương thức để liệt kê tất cả bài viết
    public function listAuthor()
    {
        $list = $this->model->getAllAuthor();
        require_once APP_ROOT.'/views/author/index.php';
    }


    // Phương thức để lấy danh sách tác giả
    public function getAuthors()
    {
        $authors = $this->getAuthors();
        include_once __DIR__ . '/../views/article/edit_article.php';
    }

    // Phương thức để thêm bài viết
    public function addAuthor()
    {
       if ($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->model->addAuthor();
            $list = $this->model->getAllAuthor();
            require_once APP_ROOT.'/views/author/index.php';
       }
    }

    // Phương thức để sửa bài viết
    public function editAuthor($id){
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $author = $this->model->getUserNameById($id);
        $this->model->updateAuthor();  // Hàm cập nhật dữ liệu tác giả
        if ($this->model->updateAuthor()){

            $list = $this->model->getAllAuthor();
            require_once APP_ROOT.'/views/author/index.php';
        }
    } else {
        // Nếu không phải phương thức POST, tức là chỉ hiển thị form
        $author = $this->model->getUserNameById($id);
        require_once APP_ROOT.'/views/author/edit.php';
    }
}

    // Phương thức để xóa bài viết
    public function deleteAuthor($id)
    {
        if ($this->model->deleteAuthor($id)) {
            $list = $this->model->getAllAuthor();
            require_once APP_ROOT.'/views/author/index.php';
        } else {
            echo "<script>alert('Không thể xóa tác giả vì vẫn còn bài viết liên quan. Vui lòng xóa hoặc cập nhật các bài viết trước.'); </script>";
            $list = $this->model->getAllAuthor();
            require_once APP_ROOT.'/views/author/index.php';
        }
    }
}

// Xử lý route dựa trên hành động
if (isset($_GET['action'])) {
    $controller = new AuthorController();

    switch ($_GET['action']) {
        case 'add':
            $controller->addAuthor();
            break;
        case 'edit':
            if (isset($_GET['id'])) {
                $controller->editAuthor($_GET['id']);
            }
            break;
        case 'delete':
            if (isset($_GET['id'])) {
                $controller->deleteAuthor($_GET['id']);
            }
            break;
        default:
            $controller->listAuthor();
            break;
    }
} else {
    $controller = new AuthorController();
    $controller->listAuthor();
}

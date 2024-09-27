<?php

if (!defined ('APP_ROOT')){
    define('APP_ROOT', dirname(__DIR__));
}

require_once '/xampp/htdocs/btth02v2/configs/DBConnection.php';


class Author
{
    private $conn;
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DBConnection(); // Tạo một đối tượng DBConnection
        $this->conn = $this->dbConnection->getConnection(); // Lấy kết nối từ DBConnection
        
        // Kiểm tra kết nối
        if ($this->conn->connect_error) {
            die("Kết nối không thành công: " . $this->conn->connect_error);
        }
    }

    // Lấy tất cả bài viết
    public function getAllAuthor()
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM tacgia";
        $result = $conn->query($sql);

        // Kiểm tra nếu có dữ liệu trả về
        $author = [];
        if ($result->num_rows > 0) {
            // Lưu trữ tất cả dữ liệu vào mảng
            while($row = $result->fetch_assoc()) {
                $author[] = $row;
            }
        } else {
            echo "Không có dữ liệu để hiển thị.";
            }
        return $author;
    }

    public function getUserNameById($id)
    {
        $sql = "SELECT * FROM tacgia WHERE ma_tgia = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    // Thêm bài viết
    public function addAuthor()
    {
        $ten_tgia = isset($_POST['author_name']) ? $_POST['author_name'] : '';

        if (isset($_FILES['author_image']) && $_FILES['author_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['author_image']['tmp_name'];
            $fileName = $_FILES['author_image']['name'];
            $fileSize = $_FILES['author_image']['size'];
            $fileType = $_FILES['author_image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Các định dạng ảnh hợp lệ
            $allowedfileExtensions = array('jpg', 'png', 'jpeg');

            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Thư mục lưu trữ file ảnh
                $uploadFileDir = 'C:\\xampp\\htdocs\\btth02v2\\assets\\images\\author\\'; //thay bằng đường dẫn đến thư mục của bạn
                $dest_path = $uploadFileDir . $fileName;

                // Di chuyển file ảnh vào thư mục đích
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Nếu ảnh tải lên thành công, tiến hành thêm thông tin vào CSDL
                    if (!empty($ten_tgia)) {
                        $sql = "INSERT INTO tacgia (ten_tgia, hinh_tgia) VALUES (?, ?)";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bind_param("ss", $ten_tgia, $fileName);
                        if ($stmt->execute()) {
                            // Chuyển hướng sau khi thêm thành công
                            return true;
                        } else {
                            echo "Lỗi khi thêm tác giả: " . $stmt->error;
                        }

                        $stmt->close();
                    } else {
                        echo "<script>alert('Vui lòng nhập tên tác giả'); window.history.back();</script>";
                    }
                } else {
                    echo "Lỗi khi di chuyển hình ảnh.";
                }
            } else {
                echo "Chỉ chấp nhận các định dạng file: " . implode(", ", $allowedfileExtensions);
            }
        } else {
            $hinh_tgia = '';
            if (!empty($ten_tgia)) {
                $sql = "INSERT INTO tacgia (ten_tgia, hinh_tgia) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ss", $ten_tgia, $hinh_tgia);

                if ($stmt->execute()) {
                    // Chuyển hướng sau khi thêm thành công
                    return true;
                } else {
                    echo "Lỗi khi thêm tác giả: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "<script>alert('Vui lòng nhập tên tác giả'); window.history.back();</script>";
            }
        } 
    }

    // Cập nhật bài viết
    public function updateAuthor()
    { 
        $author = $this->getUserNameById($_GET['id']);
            $ten_tgia = $_POST['author_name'];
            $hinh_tgia = $author['hinh_tgia']; // Giữ lại ảnh cũ
            // Kiểm tra upload được ảnh mới chưa
            if (isset($_FILES['author_new_image']) && $_FILES['author_new_image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['author_new_image']['tmp_name'];
                $fileName = $_FILES['author_new_image']['name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                echo $fileName;

                // Các định dạng ảnh hợp lệ
                $allowedfileExtensions = array('jpg', 'png', 'jpeg');

                if (in_array($fileExtension, $allowedfileExtensions)) {
                    // Chỉ di chuyển file ảnh vào thư mục đích mà không cập nhật CSDL
                    $uploadFileDir = APP_ROOT.'/assets/images/author/';
                    $dest_path = $uploadFileDir . $fileName;
                    // echo $fileName;
                    // echo $dest_path;

                    // Di chuyển file ảnh vào thư mục đích
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $hinh_tgia = $fileName; // Cập nhật tên ảnh mới chỉ để hiển thị
                    } else {
                        echo "Lỗi khi di chuyển hình ảnh.";
                    }
                } else {
                    echo "Chỉ chấp nhận các định dạng file: " . implode(", ", $allowedfileExtensions);
                }
            }

            // Cập nhật thông tin tác giả vào cơ sở dữ liệu khi nhấn "Cập nhật"
            if (!empty($ten_tgia)) {

                
                $sql = "UPDATE tacgia SET ten_tgia=?, hinh_tgia=? WHERE ma_tgia=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssi", $ten_tgia, $hinh_tgia, $_GET['id']);

                if ($stmt->execute()) {
                    return true;
                } else {
                    echo "Lỗi khi cập nhật thông tin tác giả: " . $stmt->error;
                }
                $stmt->close();
            } else {
                // echo "<script>alert('Vui lòng nhập đầy đủ thông tin'); window.history.back();</script>";
            }
        return true;
    }

    // Xóa bài viết
    public function deleteAuthor($id)
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        
            // Kiểm tra xem tác giả này có liên kết với bài viết nào không
            $sql_check = "SELECT COUNT(*) as total FROM baiviet WHERE ma_tgia = ?";
            $stmt_check = $this->conn->prepare($sql_check);
            $stmt_check->bind_param("i", $id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            $row_check = $result_check->fetch_assoc();
        
            if ($row_check['total'] > 0) {
                // Nếu có bài viết liên quan, hiển thị thông báo lỗi
                return false;
                
            } else {
                // Nếu không có bài viết liên quan, thực hiện xóa thể loại
                $sql = "DELETE FROM tacgia WHERE ma_tgia = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $id);
        
                if ($stmt->execute()) {
                    // Chuyển hướng về trang author.php sau khi xóa thành công
                    return true;
                } else {
                    echo "Lỗi khi xóa tác giả: " . $this -> conn->error;
                }
            }
        } else {
            echo "Không tìm thấy mã tác giả.<br>";
        }
    }

    //Phương thức kiểm tra xem có bài viết nào liên kết đến tg k
    public function checkFK_Key (){
        $sql_check = "SELECT COUNT(*) as total FROM baiviet WHERE ma_tgia = ?";
        $stmt_check = $this->conn->prepare($sql_check);
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();

    }
    
    // Phương thức lấy danh sách tác giả
    public function getAuthor()
    {
        $ma_tgia = $_GET['id'];
        $sql = "SELECT * FROM tacgia WHERE ma_tgia = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $ma_tgia);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $author = $result->fetch_assoc();
        } else {
            echo "Chưa có thông tin về tác giả nào";
            exit();
        }
        return $author;
    }

    // Đóng kết nối
    public function closeConnection()
    {
        $this->dbConnection = null;
    }

    // Destructor để tự động đóng kết nối khi không sử dụng
    public function __destruct()
    {
        $this->closeConnection();
    }
}

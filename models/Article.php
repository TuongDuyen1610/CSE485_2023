<?php
require_once '/xampp/htdocs/btth02v2/configs/DBConnection.php';

class Article
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
    public function getAllArticles()
    {
        $sql = "SELECT b.*, t.ten_tloai, a.ten_tgia, b.hinhanh 
                FROM baiviet b 
                LEFT JOIN theloai t ON b.ma_tloai = t.ma_tloai 
                LEFT JOIN tacgia a ON b.ma_tgia = a.ma_tgia"; 

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    // Lấy bài viết theo ID
    public function getArticleById($id)
    {
        $sql = "SELECT * FROM baiviet WHERE ma_bviet = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc(); // Trả về bài viết duy nhất
    }

    // Thêm bài viết
    public function addArticle($data)
    {
        $sql = "INSERT INTO baiviet (tieude, ten_bhat, ma_tloai, tomtat, ma_tgia, ngayviet, hinhanh) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        // Kiểm tra nếu chuẩn bị câu lệnh không thành công
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }

        // Nếu không có hình ảnh, set giá trị null
        $hinhanh = !empty($data['hinhanh']) ? $data['hinhanh'] : null;

        // Ràng buộc các tham số
        $stmt->bind_param("ssissss", $data['tieude'], $data['ten_bhat'], $data['ma_tloai'], $data['tomtat'], $data['ma_tgia'], $data['ngayviet'], $hinhanh);
        
        if (!$stmt->execute()) {
            die("Lỗi thêm bài viết: " . $this->conn->error);
        }

        return true; // Trả về true nếu thành công
    }

    // Cập nhật bài viết
    public function updateArticle($data)
    {
        $sql = "UPDATE baiviet SET tieude = ?, ten_bhat = ?, ma_tloai = ?, tomtat = ?, ma_tgia = ?, ngayviet = ?, hinhanh = ? WHERE ma_bviet = ?";
        $stmt = $this->conn->prepare($sql);
        
        // Kiểm tra nếu chuẩn bị câu lệnh không thành công
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }

        // Nếu không có hình ảnh mới, giữ nguyên hình ảnh cũ
        $hinhanh = !empty($data['hinhanh']) ? $data['hinhanh'] : null;

        // Ràng buộc các tham số
        $stmt->bind_param("ssissssi", $data['tieude'], $data['ten_bhat'], $data['ma_tloai'], $data['tomtat'], $data['ma_tgia'], $data['ngayviet'], $hinhanh, $data['ma_bviet']);
        
        if (!$stmt->execute()) {
            die("Lỗi cập nhật bài viết: " . $this->conn->error);
        }

        return true; // Trả về true nếu thành công
    }

    // Xóa bài viết
    public function deleteArticle($id)
    {
        $sql = "DELETE FROM baiviet WHERE ma_bviet = ?";
        $stmt = $this->conn->prepare($sql);
        
        // Kiểm tra nếu chuẩn bị câu lệnh không thành công
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute()) {
            die("Lỗi xóa bài viết: " . $this->conn->error);
        }

        return true; // Trả về true nếu thành công
    }

    // Phương thức lấy danh sách thể loại
    public function getCategories()
    {
        $sql = "SELECT ma_tloai, ten_tloai FROM theloai";
        $stmt = $this->conn->prepare($sql);
        
        // Kiểm tra nếu chuẩn bị câu lệnh không thành công
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC); // Trả về danh sách thể loại
    }

    // Phương thức lấy danh sách tác giả
    public function getAuthors()
    {
        $sql = "SELECT ma_tgia, ten_tgia FROM tacgia";
        $stmt = $this->conn->prepare($sql);
        
        // Kiểm tra nếu chuẩn bị câu lệnh không thành công
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC); // Trả về danh sách tác giả
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

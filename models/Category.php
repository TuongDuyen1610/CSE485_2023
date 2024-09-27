<?php
class Category {
    private $db;

    public function __construct($db) {
        $this->db = $db; // Lưu đối tượng kết nối cơ sở dữ liệu
    }

    // Phương thức để lấy tất cả các thể loại
    public function getAllCategories() {
        $query = "SELECT * FROM theloai"; // Truy vấn để lấy tất cả thể loại
        $result = $this->db->query($query);
        $categories = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row; // Thêm từng thể loại vào mảng
            }
        }

        return $categories; // Trả về mảng thể loại
    }

    // Phương thức để thêm thể loại
    public function addCategory($name) {
        $query = "INSERT INTO theloai (ten_tloai) VALUES (?)"; // Truy vấn để thêm thể loại
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $name); // Liên kết tham số

        return $stmt->execute(); // Thực thi truy vấn và trả về kết quả
    }

    // Phương thức để cập nhật thể loại
    public function editCategory($id, $name) {
        $query = "UPDATE theloai SET ten_tloai = ? WHERE ma_tloai = ?"; // Truy vấn để cập nhật thể loại
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $name, $id); // Liên kết tham số

        return $stmt->execute(); // Thực thi truy vấn và trả về kết quả
    }

    // Phương thức để xóa thể loại
    public function deleteCategory($id) {
        $query = "DELETE FROM theloai WHERE ma_tloai = ?"; // Truy vấn để xóa thể loại
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id); // Liên kết tham số

        return $stmt->execute(); // Thực thi truy vấn và trả về kết quả
    }

    // Phương thức để lấy thông tin thể loại theo ID
    public function getCategoryById($id) {
        $query = "SELECT * FROM theloai WHERE ma_tloai = ?"; // Truy vấn để lấy thông tin thể loại
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id); // Liên kết tham số
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Trả về thông tin thể loại
    }
}
?>

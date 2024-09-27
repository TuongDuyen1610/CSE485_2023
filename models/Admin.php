<?php
require_once APP_ROOT . '/configs/DBConnection.php'; // Đảm bảo bao gồm tệp DBConnection

class AdminModel
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection; // Gán kết nối cơ sở dữ liệu từ tham số truyền vào
    }

    public function getCount($tableName)
    {
        try {
            // Chuẩn bị truy vấn đếm số bản ghi trong bảng cụ thể
            $sql = "SELECT COUNT(*) AS total FROM " . $tableName;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result(); 
            if ($result) {
                $row = $result->fetch_assoc(); // Lấy kết quả trả về dưới dạng mảng kết hợp
                return $row['total']; // Trả về số lượng bản ghi
            }
            return 0; // Trường hợp không có kết quả, trả về 0
        } catch (Exception $e) {
            // Xử lý ngoại lệ nếu có lỗi xảy ra
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

}

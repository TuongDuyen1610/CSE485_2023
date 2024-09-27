<?php
class DBConnection {
    private $conn = null;

    // Constructor để khởi tạo kết nối khi class được gọi
    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "btth01_cse485";

        try {
            // Tạo kết nối MySQLi
            $this->conn = new mysqli($servername, $username, $password, $dbname);

            // Kiểm tra kết nối
            if ($this->conn->connect_error) {
                throw new Exception("Kết nối thất bại: " . $this->conn->connect_error);
            }

            // Thiết lập charset utf8
            if (!$this->conn->set_charset("utf8")) {
                throw new Exception("Lỗi thiết lập charset: " . $this->conn->error);
            }

            
        } catch (Exception $e) {
            echo '<div style="color: red; padding: 5px 15px; border: 1px solid red;">';
            echo $e->getMessage() . "<br>";
            echo '</div>';
            die(); // nếu gặp lỗi sẽ kết thúc chương trình luôn
        }
    }

    // Phương thức để trả về đối tượng kết nối
    public function getConnection() {
        return $this->conn;
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

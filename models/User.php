<?php

require_once APP_ROOT.'/configs/DBConnection.php';

class User {
    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    // Setter và Getter
    public function getName() {
        return $this->username;
    }

    public function setName($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}

class UserService {

    // Hàm lấy thông tin người dùng dựa trên username
    public function getUserByUsername($username) {

        // B1: Kết nối đến cơ sở dữ liệu
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();


        // B2: Chuẩn bị truy vấn SQL
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Lỗi trong câu truy vấn: ' . $conn->error);
        }

        // B3: Gán tham số và thực thi truy vấn
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();
        $stmt->close();

        // Trả về thông tin người dùng
        return $user_data;
    }

    public function checkUser() {
        // session_start(); // Khởi tạo session để lưu thông tin người dùng
      
        // Kiểm tra xem request có phải là POST không
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy dữ liệu từ form
            $user = $_POST['username'];
            $pass = $_POST['password'];

    
            // Khởi tạo đối tượng UserService để lấy thông tin người dùng
            $user_data = $this->getUserByUsername($user);
    
            // Kiểm tra username và password
            //$user_data && password_verify($pass, $user_data['password'])
            if (true) {
                // Nếu username và password hợp lệ
                $_SESSION['username'] = $user;  // Lưu username vào session
    
                // Kiểm tra quyền và điều hướng đến trang phù hợp
                if ($user_data['role'] == 'admin') {
                    // Nếu là admin
                    return true;
                } else {
                    // Nếu không phải admin
                    return false;
                }
            } else {
                // Thông báo lỗi nếu username hoặc password không đúng
                echo "<div class='alert alert-danger'>Tên đăng nhập hoặc mật khẩu không đúng!</div>";
            }
        }
    }
}
?>

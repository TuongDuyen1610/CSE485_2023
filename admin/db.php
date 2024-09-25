<?php

// //ngăn người dùng truy cập k đúng cách
// const _CODE = true;
// if (!defined('_CODE')){
//     die('Access denied...');
// }
// ?> 

<?php

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Tên người dùng MySQL
$password = ""; // Mật khẩu MySQL
$dbname = "btth01_cse485_ex"; // Tên cơ sở dữ liệu của bạn

try {
    // Tạo kết nối MySQLi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        throw new Exception("Kết nối thất bại: " . $conn->connect_error);
    }

    // Thiết lập charset utf8
    if (!$conn->set_charset("utf8")) {
        throw new Exception("Lỗi thiết lập charset: " . $conn->error);
    }

    // echo "Kết nối thành công!";
    
} catch (Exception $e) {
    echo '<div style="color: red; padding: 5px 15px; border: 1px solid red;">';
    echo $e->getMessage() . "<br>";
    echo '</div>';
    die(); // nếu gặp lỗi sẽ kết thúc chương trình luôn
}





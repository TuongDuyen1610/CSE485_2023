<?php
require_once 'db.php';

session_start();

// Tạo CSRF token nếu chưa có
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} 
// Kiểm tra nếu form đã được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token không hợp lệ.");
    } 

    // Lấy tên tác giả từ form
    $ten_tgia = isset($_POST['author_name']) ? $_POST['author_name'] : '';

    // Kiểm tra hình ảnh có được tải lên không
    if (isset($_FILES['author_image']) && $_FILES['author_image']['error'] === UPLOAD_ERR_OK) {
        echo "Đã upload ảnh";
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
            $uploadFileDir = 'C:\\xampp\\htdocs\\btth01_template\\btth01\\images\\author\\';
            $dest_path = $uploadFileDir . $fileName;

            // Di chuyển file ảnh vào thư mục đích
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Nếu ảnh tải lên thành công, tiến hành thêm thông tin vào CSDL
                if (!empty($ten_tgia)) {
                    $sql = "INSERT INTO tacgia (ten_tgia, hinh_tgia) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $ten_tgia, $fileName);

                    if ($stmt->execute()) {
                        // Chuyển hướng sau khi thêm thành công
                        header("Location: ../admin/author.php");
                        exit();
                    } else {
                        echo "Lỗi khi thêm tác giả: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    echo "<script>alert('Vui lòng nhập tên tác giả'); window.history.back();</script>";
                }
            } else {
                echo "Lỗi khi tải lên hình ảnh.";
            }
        } else {
            echo "Chỉ chấp nhận các định dạng file: " . implode(", ", $allowedfileExtensions);
        }
    } else {
        $hinh_tgia = '';
        if (!empty($ten_tgia)) {
            $sql = "INSERT INTO tacgia (ten_tgia, hinh_tgia) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $ten_tgia, $hinh_tgia);

            if ($stmt->execute()) {
                // Chuyển hướng sau khi thêm thành công
                header("Location: ../admin/author.php");
                exit();
            } else {
                echo "Lỗi khi thêm tác giả: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "<script>alert('Vui lòng nhập tên tác giả'); window.history.back();</script>";
        }
    } 
}

// Đóng kết nối
$conn->close();
?>

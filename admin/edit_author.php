<?php
require_once 'db.php';

session_start(); // Khởi tạo phiên

// Lấy thông tin các tác giả
$ma_tgia = $_GET['id'];
$sql = "SELECT * FROM tacgia WHERE ma_tgia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ma_tgia);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $author = $result->fetch_assoc();
} else {
    echo "Chưa có thông tin về tác giả nào";
    exit();
}
$stmt->close();

// Check bảo mật
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token không hợp lệ.");
    }

    $ten_tgia = $_POST['author_name'];
    $hinh_tgia = $author['hinh_tgia']; // Giữ lại ảnh cũ

    // Kiểm tra upload được ảnh mới chưa
    if (isset($_FILES['author_new_image']) && $_FILES['author_new_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['author_new_image']['tmp_name'];
        $fileName = $_FILES['author_new_image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Các định dạng ảnh hợp lệ
        $allowedfileExtensions = array('jpg', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Chỉ di chuyển file ảnh vào thư mục đích mà không cập nhật CSDL
            $uploadFileDir = '..\\images\\author\\';
            $dest_path = $uploadFileDir . $fileName;

            // Di chuyển file ảnh vào thư mục đích
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $hinh_tgia = $fileName; // Cập nhật tên ảnh mới chỉ để hiển thị
            } else {
                echo "Lỗi khi tải lên hình ảnh.";
            }
        } else {
            echo "Chỉ chấp nhận các định dạng file: " . implode(", ", $allowedfileExtensions);
        }
    }

    // Cập nhật thông tin tác giả vào cơ sở dữ liệu khi nhấn "Cập nhật"
    if (!empty($ten_tgia)) {
        $sql = "UPDATE tacgia SET ten_tgia=?, hinh_tgia=? WHERE ma_tgia=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $ten_tgia, $hinh_tgia, $ma_tgia);

        if ($stmt->execute()) {
            header("Location: ../admin/author.php");
            exit();
        } else {
            echo "Lỗi khi cập nhật thông tin tác giả: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Cập nhật thông tin tác giả</h3>
            <form action="edit_author.php?id=<?= $ma_tgia ?>" method="post" enctype="multipart/form-data">

                <div class="input-group mt-3 mb-3">
                    <span class="input-group-text">Mã tác giả</span>
                    <input type="text" class="form-control" name="txtAuthorID" readonly value="<?= htmlspecialchars($author['ma_tgia']) ?>" required>
                </div>

                <div class="input-group mt-3 mb-3">
                    <span class="input-group-text">Tên tác giả</span>
                    <input type="text" class="form-control" name="author_name" value="<?= htmlspecialchars($author['ten_tgia']) ?>" required>
                </div>

                <div class="form-group mt-3 mb-3 d-flex align-items-center">
                    <label for="author_image" style="margin-right: 10px;">Hình tác giả</label>
                    <img id="imagePreview" src="<?= "../images/author/".htmlspecialchars($author['hinh_tgia']) ?>" alt="Hình tác giả" style="width: 100px; height: auto; margin-left: 10px;">
                </div>

                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group float-end">
                    <input name="author_new_image" type="file" id="fileInput" style="display: none;" onchange="document.getElementById('imagePreview').src = window.URL.createObjectURL(this.files[0])">
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click();">Tải ảnh mới</button>
                    <input type="submit" value="Cập nhật" class="btn btn-success">
                    <a href="author.php" class="btn btn-warning">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>

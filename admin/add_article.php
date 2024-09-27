<?php
include 'db.php';

// Lấy danh sách thể loại và tác giả để điền vào các trường chọn
$categories = [];
$authors = [];

// Lấy danh sách thể loại
$sql = "SELECT * FROM theloai";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Lấy danh sách tác giả
$sql = "SELECT * FROM tacgia";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $authors[] = $row;
    }
}

// Kiểm tra xem phương thức có phải POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu từ biểu mẫu
    $tieude = $_POST['txtTitle'];
    $ten_bhat = $_POST['txtSongName'];
    $ma_tloai = $_POST['txtCatId'];
    $ma_tgia = $_POST['txtAuthorId'];
    $tomtat = $_POST['txtSummary'];
    
    // Lấy ngày giờ hiện tại ở Việt Nam
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $ngayviet = date('Y-m-d H:i:s'); // Ngày viết tự động lấy từ hệ thống

    // Kiểm tra xem các trường có rỗng không
    if (!empty($tieude) && !empty($ten_bhat) && !empty($ma_tloai) && !empty($ma_tgia)) {
        // Câu lệnh SQL chèn bài viết mới
        $sql = "INSERT INTO baiviet (tieude, ten_bhat, ma_tloai, ma_tgia, tomtat, ngayviet) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiss", $tieude, $ten_bhat, $ma_tloai, $ma_tgia, $tomtat, $ngayviet);

        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            header("Location: article.php");
            exit();
        } else {
            echo "Lỗi khi thêm bài viết: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin'); window.history.back();</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Administration</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="./">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index.php">Trang ngoài</a></li>
                        <li class="nav-item"><a class="nav-link" href="category.php">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link" href="author.php">Tác giả</a></li>
                        <li class="nav-item"><a class="nav-link active fw-bold" href="article.php">Bài viết</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <h3 class="text-center text-uppercase fw-bold">Thêm bài viết mới</h3>
        <form action="" method="post">
            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Tiêu đề</span>
                <input type="text" class="form-control" name="txtTitle" required>
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Tên bài hát</span>
                <input type="text" class="form-control" name="txtSongName" required>
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Tên thể loại</span>
                <select class="form-select" name="txtCatId" required>
                    <option value="">Chọn thể loại</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['ma_tloai']); ?>"><?php echo htmlspecialchars($category['ten_tloai']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Tên tác giả</span>
                <select class="form-select" name="txtAuthorId" required>
                    <option value="">Chọn tác giả</option>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?php echo htmlspecialchars($author['ma_tgia']); ?>"><?php echo htmlspecialchars($author['ten_tgia']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Tóm tắt</span>
                <textarea class="form-control" name="txtSummary" required></textarea>
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Ngày viết</span>
                <input type="text" class="form-control" name="txtDate" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
            </div>

            <div class="form-group float-end">
                <input type="submit" value="Thêm bài viết" class="btn btn-success">
                <a href="article.php" class="btn btn-warning">Quay lại</a>
            </div>
        </form>
    </main>

    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

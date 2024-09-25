<?php
// Thông tin kết nối database
$servername = "localhost"; // hoặc 127.0.0.1
$username = "root"; // Tên đăng nhập MySQL
$password = ""; // Mật khẩu MySQL
$dbname = "btth01_cse485_ex"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn danh sách bài viết
$sql = "SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, theloai.ten_tloai, baiviet.tomtat, tacgia.ten_tgia, baiviet.ngayviet 
        FROM baiviet
        JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
        JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia";

$result = $conn->query($sql);

// Kiểm tra kết quả truy vấn
$articles = [];
if ($result->num_rows > 0) {
    // Lấy dữ liệu cho mỗi hàng
    while($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
} else {
    $articles = [];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" href="css/style_login.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
        <div class="container-fluid">
            <div class="h3">
                <a class="navbar-brand" href="#">Administration</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Trang ngoài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="article.php">Bài viết</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="container mt-5 mb-5">
    <div class="row">
        <div class="col-sm mb-3">
            <a href="add_article.php" class="btn btn-success">Thêm mới</a>
        </div>
        <div class="col-12">
            <h3 class="text-center text-uppercase fw-bold">Danh sách bài viết</h3>
        </div>
        <?php if (!empty($articles)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Mã bài viết</th>
                        <th>Tiêu đề</th>
                        <th>Tên bài hát</th>
                        <th>Tên thể loại</th>
                        <th>Tóm tắt</th>
                        <th>Tên tác giả</th>
                        <th>Ngày viết</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= htmlspecialchars($article['ma_bviet']) ?></td>
                            <td><?= htmlspecialchars($article['tieude']) ?></td>
                            <td><?= htmlspecialchars($article['ten_bhat']) ?></td>
                            <td><?= htmlspecialchars($article['ten_tloai']) ?></td> <!-- Hiển thị tên thể loại -->
                            <td><?= htmlspecialchars($article['tomtat']) ?></td>
                            <td><?= htmlspecialchars($article['ten_tgia']) ?></td> <!-- Hiển thị tên tác giả -->
                            <td><?= htmlspecialchars($article['ngayviet']) ?></td>
                            <td>
                                <a href="edit_article.php?id=<?= htmlspecialchars($article['ma_bviet']) ?>" title="Sửa"><i class="fas fa-edit"></i></a>
                            </td>
                            <td>
                                <a href="delete_article.php?id=<?= htmlspecialchars($article['ma_bviet']) ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p class="text-center">Không có bài viết nào.</p>
        <?php endif; ?>
    </div>
</main>
<footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>

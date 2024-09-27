<?php
include 'db.php';

// Kiểm tra nếu nhận được ID bài viết từ GET
if (isset($_GET['id'])) {
    $ma_bviet = $_GET['id'];
} else {
    header("Location: article.php");
    exit();
}

// Lấy thông tin bài viết từ cơ sở dữ liệu để hiển thị trên biểu mẫu
$sql = "SELECT b.*, tl.ten_tloai, tg.ten_tgia 
        FROM baiviet b 
        JOIN theloai tl ON b.ma_tloai = tl.ma_tloai 
        JOIN tacgia tg ON b.ma_tgia = tg.ma_tgia 
        WHERE b.ma_bviet=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ma_bviet);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu từ biểu mẫu
    $tieude = $_POST['txtTitle'];
    $ten_bhat = $_POST['txtSongName'];
    $ma_tloai = $_POST['txtCatId']; // Lấy mã thể loại từ trường ẩn
    $tomtat = $_POST['txtSummary'];

    // Kiểm tra xem tiêu đề và tên bài hát có rỗng không
    if (!empty($tieude) && !empty($ten_bhat)) {
        // Lấy ngày giờ hiện tại ở Việt Nam
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ngayviet = date('Y-m-d H:i:s');

        // Câu lệnh SQL cập nhật bài viết
        $sql = "UPDATE baiviet SET tieude=?, ten_bhat=?, ma_tloai=?, tomtat=?, ngayviet=? WHERE ma_bviet=?";
        $stmt = $conn->prepare($sql);

        // Gán các tham số vào câu lệnh SQL
        $stmt->bind_param("ssissi", $tieude, $ten_bhat, $ma_tloai, $tomtat, $ngayviet, $ma_bviet);

        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            header("Location: article.php");
            exit();
        } else {
            echo "Lỗi khi cập nhật bài viết: " . $stmt->error;
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
    <title>Chỉnh sửa bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
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
        <h3 class="text-center text-uppercase fw-bold">Sửa thông tin bài viết</h3>
        <form action="" method="post">
            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Mã bài viết</span>
                <input type="text" class="form-control" name="txtArticleId" readonly value="<?php echo htmlspecialchars($article['ma_bviet']); ?>">
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Tiêu đề</span>
                <input type="text" class="form-control" name="txtTitle" value="<?php echo htmlspecialchars($article['tieude']); ?>" required>
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text">Tên bài hát</span>
                <input type="text" class="form-control" name="txtSongName" value="<?php echo htmlspecialchars($article['ten_bhat']); ?>" required>
            </div>

            <!-- Trường ẩn cho mã thể loại -->
            <input type="hidden" name="txtCatId" value="<?php echo htmlspecialchars($article['ma_tloai']); ?>">

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
                <span class="input-group-text">Tóm tắt</span>
                <textarea class="form-control" name="txtSummary" required><?php echo htmlspecialchars($article['tomtat']); ?></textarea>
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
                <span class="input-group-text">Ngày viết</span>
                <input type="text" class="form-control" name="txtDate" value="<?php echo htmlspecialchars($article['ngayviet']); ?>" readonly>
            </div>

            <div class="form-group float-end">
                <input type="submit" value="Lưu lại" class="btn btn-success">
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
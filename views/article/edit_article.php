<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
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
                            <a class="nav-link active fw-bold" aria-current="page" href="../admin/index.php">Trang chủ</a>
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
        <h3 class="text-center text-uppercase fw-bold">Chỉnh sửa bài viết</h3>
        
        <form action="/btth02v2/controllers/ArticleController.php?action=edit&id=<?= htmlspecialchars($article['ma_bviet']) ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tieude" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="tieude" name="tieude" value="<?= htmlspecialchars($article['tieude']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="ten_bhat" class="form-label">Tên bài hát</label>
                <input type="text" class="form-control" id="ten_bhat" name="ten_bhat" value="<?= htmlspecialchars($article['ten_bhat']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="ma_tloai" class="form-label">Thể loại</label>
                <select class="form-select" id="ma_tloai" name="ma_tloai" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['ma_tloai']) ?>" <?= $category['ma_tloai'] == $article['ma_tloai'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['ten_tloai']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ma_tgia" class="form-label">Tác giả</label>
                <select class="form-select" id="ma_tgia" name="ma_tgia" required>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= htmlspecialchars($author['ma_tgia']) ?>" <?= $author['ma_tgia'] == $article['ma_tgia'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($author['ten_tgia']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tomtat" class="form-label">Tóm tắt</label>
                <textarea class="form-control" id="tomtat" name="tomtat" rows="3" required><?= htmlspecialchars($article['tomtat']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="noidung" class="form-label">Nội dung</label>
                <textarea class="form-control" id="noidung" name="noidung" rows="5"><?= htmlspecialchars($article['noidung']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="hinhanh" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="hinhanh" name="hinhanh">
                <small class="form-text text-muted">Chọn hình ảnh mới nếu bạn muốn thay đổi.</small>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="/btth02v2/controllers/ArticleController.php?action=list" class="btn btn-secondary">Hủy</a>
        </form>
    </main>
    
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

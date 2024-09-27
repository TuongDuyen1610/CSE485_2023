<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài viết</title>
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
                            <a class="nav-link " aria-current="page" href="../index.php">Trang chủ</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="HomeController.php?action=home">Trang ngoài</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="category.php">Thể loại</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="author.php">Tác giả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active fw-bold" href="ArticleController.php">Bài viết</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <div class="col-sm mb-3">
            <a href="/btth02v2/controllers/ArticleController.php?action=add" class="btn btn-success">Thêm mới</a>
        </div>
        <h3 class="text-center text-uppercase fw-bold">Danh sách bài viết</h3>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Mã bài viết</th>
                    <th>Tiêu đề</th>
                    <th>Tên bài hát</th>
                    <th>Tên thể loại</th>
                    <th>Tóm tắt</th>
                    <th>Tên tác giả</th>
                    <th>Ngày viết</th>
                    <th>Hình ảnh</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= htmlspecialchars($article['ma_bviet']) ?></td>
                            <td><?= htmlspecialchars($article['tieude']) ?></td>
                            <td><?= htmlspecialchars($article['ten_bhat']) ?></td>
                            <td><?= htmlspecialchars($article['ten_tloai']) ?></td>
                            <td><?= htmlspecialchars($article['tomtat']) ?></td>
                            <td><?= htmlspecialchars($article['ten_tgia']) ?></td>
                            <td><?= htmlspecialchars($article['ngayviet']) ?></td>
                            <td>
                                <?php if (!empty($article['hinhanh'])): ?>
                                    <img src="../../assets/images/<?= htmlspecialchars($article['hinhanh']) ?>" alt="Hình ảnh bài viết" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    <img src="../../assets/images/default-image.jpg" alt="Hình ảnh " style="width: 100px; height: auto;"> <!-- Hình ảnh mặc định -->
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/btth02v2/controllers/ArticleController.php?action=edit&id=<?= htmlspecialchars($article['ma_bviet']) ?>" title="Sửa"><i class="fas fa-edit"></i></a>
                            </td>
                            <td>
                                <a href="/btth02v2/controllers/ArticleController.php?action=delete&id=<?= htmlspecialchars($article['ma_bviet']) ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">Không có bài viết nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

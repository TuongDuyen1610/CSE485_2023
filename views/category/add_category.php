<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Thể loại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <a class="navbar-brand h3" href="#">Administration</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=admin">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php">Trang ngoài</a></li>
                        <li class="nav-item"><a class="nav-link active fw-bold" href="index.php?controller=category">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=author">Tác giả</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=article">Bài viết</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <h2>Thêm Thể loại</h2>

        <!-- Thông báo lỗi nếu có -->
        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-<?php echo ($_GET['status'] === 'success_add') ? 'success' : 'danger'; ?> mt-3" role="alert">
                <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $_GET['status']))); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=category&action=add" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Tên thể loại</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a href="index.php?controller=category" class="btn btn-secondary">Hủy</a>
        </form>
    </main>

    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px;">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

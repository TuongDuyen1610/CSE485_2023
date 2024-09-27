<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa tác giả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Cập nhật thông tin tác giả</h3>
            <form action="/btth02v2/controllers/AuthorController.php?action=edit&id=<?= htmlspecialchars($author['ma_tgia']) ?>" method="post" enctype="multipart/form-data">

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
                    <img id="imagePreview" src="<?= "/btth02v2/assets/images/author/".htmlspecialchars($author['hinh_tgia']) ?>" alt="Hình tác giả" style="width: 100px; height: auto; margin-left: 10px;">
                </div>

                <div class="form-group float-end">
                    <input name="author_new_image" type="file" id="fileInput" style="display: none;" onchange="document.getElementById('imagePreview').src = window.URL.createObjectURL(this.files[0])">
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click();">Tải ảnh mới</button>
                    <input type="submit" value="Cập nhật" class="btn btn-success">
                    <a href="/btth02v2/controllers/AuthorController.php" class="btn btn-warning">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>

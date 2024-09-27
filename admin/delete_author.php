<?php
include 'db.php';
// Lấy id của tác giả
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kiểm tra xem tác giả này có liên kết với bài viết nào không
    $sql_check = "SELECT COUNT(*) as total FROM baiviet WHERE ma_tgia = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['total'] > 0) {
        // Nếu có bài viết liên quan, hiển thị thông báo lỗi
        echo "<script>alert('Không thể xóa tác giả vì vẫn còn bài viết liên quan. Vui lòng xóa hoặc cập nhật các bài viết trước.'); window.location.href = 'author.php';</script>";
    } else {
        // Nếu không có bài viết liên quan, thực hiện xóa thể loại
        $sql = "DELETE FROM tacgia WHERE ma_tgia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Chuyển hướng về trang author.php sau khi xóa thành công
            echo "Xóa thành công!<br>";
            header("Location: author.php");
            exit();
        } else {
            echo "Lỗi khi xóa tác giả: " . $conn->error;
        }
    }
} else {
    echo "Không tìm thấy mã tác giả.<br>";
}

// Đóng kết nối
$conn->close();
?>

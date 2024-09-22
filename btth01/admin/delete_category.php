<?php 
include '../db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Chuẩn bị câu lệnh SQL với tham số
    $sql = "DELETE FROM theloai WHERE ma_tloai = ?";
    $statement = $conn->prepare($sql);
    
    // Gán giá trị cho tham số
    $statement->bind_param('i', $id);

    // Thực thi câu lệnh SQL
    if ($statement->execute()) {
        header('Location: category.php');
        exit();
    } else {
        echo "Có lỗi xảy ra khi xóa thể loại.";
    }
} else {
    echo "ID không hợp lệ.";
}
?>


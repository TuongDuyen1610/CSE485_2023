<?php
require 'db.php';
if (isset($_GET['id'])) {

    $ma_tgia = $_GET['id'];

    $sql = "DELETE FROM baiviet WHERE ma_bviet = {$_GET['id']}";
    $conn->query($sql);

    header('Location:article.php');
}
?>
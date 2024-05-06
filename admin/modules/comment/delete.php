<?php
require_once '../../config.php';

$id = $_REQUEST['id'];

$sql = "DELETE FROM comments WHERE id = $id";

if (mysqli_query($link, $sql)) {
    print_r(mysqli_query($link, $sql));

    $success_message = "Đã xóa bình luận có mã " . $id;
} else {
    $error_message = "Lỗi xóa bình luận: " . mysqli_error($link);
}

mysqli_close($link);

header("Location: comment.php");
exit();
?>
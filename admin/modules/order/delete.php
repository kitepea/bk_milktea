<?php
// Kết nối đến cơ sở dữ liệu
require_once '../../config.php';

$id = $_REQUEST['id'];

$sql = "DELETE FROM Orders WHERE id = $id";


if (mysqli_query($link, $sql)) {
    // Xóa thành công
    $success_message = "Đã xóa đơn hàng có mã " . $id;
} else {
    // Lỗi khi xóa
    $error_message = "Lỗi xóa đơn hàng: " . mysqli_error($link);
}

// Đóng kết nối đến cơ sở dữ liệu
mysqli_close($link);

// Chuyển hướng về trang quản lý đơn hàng
header("Location: order.php");
exit();
?>
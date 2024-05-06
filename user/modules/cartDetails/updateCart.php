<?php
session_start();

// Kiểm tra nếu yêu cầu là POST và tồn tại dữ liệu giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart'])) {
    // Lấy dữ liệu giỏ hàng từ yêu cầu AJAX
    $cart = json_decode($_POST['cart'], true);

    // Cập nhật giỏ hàng trong $_SESSION
    $_SESSION['cart'] = $cart;

    // Trả về phản hồi (nếu cần)
    echo json_encode(['success' => true]);
} else {
    // Trả về phản hồi lỗi (nếu cần)
    echo json_encode(['error' => 'Invalid request']);
}
?>

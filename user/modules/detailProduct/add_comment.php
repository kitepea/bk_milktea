<?php
require_once '../../includes/config.php';
session_start();

// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn cần đăng nhập để có thể gửi bình luận.']);
    exit;
}

$userId = $_SESSION['user_id'];
$productId = $_POST['product_id'];
$content = $_POST['content'];

// Kiểm tra dữ liệu đầu vào
if (empty($content)) {
    echo json_encode(['status' => 'error', 'message' => 'Nội dung bình luận không được để trống.']);
    exit;
}

$sql = "INSERT INTO Comments (product_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $productId, $userId, $content);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Bình luận đã được gửi thành công.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Đã xảy ra lỗi khi gửi bình luận.']);
}

$stmt->close();
$conn->close();
<?php
session_start();
require_once '../../includes/config.php';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Lấy thông tin người dùng từ session
$userId = $_SESSION['user_id'];

// Lấy thông tin cập nhật từ form
$name = $_POST['name'];
$gender = $_POST['gender'];
// $email = $_POST['email'];
$dateOfBirth = $_POST['dateOfBirth'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Cập nhật thông tin người dùng trong cơ sở dữ liệu
$sql = "UPDATE Users SET name = ?, sex = ?, dateofbirth = ?, phone = ?, address = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $name, $gender, $dateOfBirth, $phone, $address, $userId);

if ($stmt->execute()) {
    // Cập nhật thông tin trong session
    $_SESSION['name'] = $name;
    $_SESSION['gender'] = $gender;
    $_SESSION['dateOfBirth'] = $dateOfBirth;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $address;

    header("Location: personalInfo.php");
} else {
    echo "Lỗi khi cập nhật thông tin: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
<?php
require_once '../../includes/config.php';
session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['change_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $sql = "UPDATE Account SET password = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashedPassword, $username);
            if ($stmt->execute()) {
                // Hiển thị cửa sổ cảnh báo thông báo thành công bằng JavaScript
                echo '<script>alert("Thay đổi mật khẩu thành công!");</script>';
            } else {
                // Hiển thị cửa sổ cảnh báo lỗi nếu có lỗi xảy ra
                echo '<script>alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");</script>';
            }
        } else {
            // Nếu mật khẩu mới và xác nhận mật khẩu không khớp nhau
            echo '<script>alert("Mật khẩu mới và xác nhận mật khẩu không khớp nhau.");</script>';
        }
    } else {
        // Nếu các trường mật khẩu và xác nhận mật khẩu không được gửi đi đầy đủ
        echo '<script>alert("Vui lòng điền đầy đủ thông tin mật khẩu.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thay đổi mật khẩu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../detailProduct/detailProduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="personalInfo.css">
    <link rel="stylesheet" href="../../templates/styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">


</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container mx-auto py-8">
        
    </div>
    <section class="content">
        <aside class="h-full flex flex-col justify-between border-none">
            <div>
                <div class="info">
                    <a href="./personalInfo.php">Thông tin cá nhân</a>
                </div>
                <div class="info">
                    <a href="./change_password.php">Đổi mật khẩu</a>
                </div>
                <div class="info">
                    <a href="#">Đơn mua</a>
                </div>
                <div class="info">
                    <a href="#">Thông báo</a>
                </div>
            </div>
        </aside>
        <main>
        <h1 class="text-2xl font-bold mb-6 text-center">Thay đổi mật khẩu</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="max-w-md mx-auto mt-8">
            <div class="mb-4">
                <label for="new_password" class="block text-gray-700">Mật khẩu mới:</label>
                <input type="password" name="new_password" id="new_password" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-gray-700">Xác nhận mật khẩu:</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            
            <!-- Nút "Thay đổi mật khẩu" -->
            <div class="mt-4 flex justify-center">
                <button type="submit" name="change_password"
                    class="py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Thay
                    đổi mật khẩu</button>
            </div>
        </form>
        </main>        
    </section>
    

    <footer class="grid grid-cols-4 grid-rows-4 gap-4 text-center text-white bg-yellow-400 rounded-lg">
        <div class="col-start-1 col-span-4">
            <h4>BK Milk Tea</h4>
        </div>
        <div class="hover:underline dark:text-yellow-400">
            <a href="#" class="text-white">Về chúng tôi</a>
        </div>
        <div class="hover:underline dark:text-yellow-400">
            <a href="#" class="text-white">Đăng kí tài khoản</a>
        </div>
        <div class="hover:underline dark:text-yellow-400">
            <a href="#" class="text-white">Liên hệ với chúng tôi</a>
        </div>
        <div class="row-span-2">
            <a class="navbar-brand" href="../HomePage/homePage.html">
                <img src="/user/templates/img/logo.png" alt="" class="navigation__logo h-16">
            </a>
        </div>
        <div class="hover:underline dark:text-yellow-400">
            <a href="#" class="text-white">Chính sách bảo mật</a>
        </div>
        <div class="hover:underline dark:text-yellow-400">
            <a href="#" class="text-white">Trung tâm hỗ trợ</a>
        </div>
        <div class="flex justify-center items-center">
            <a href="#" class="text-white mx-2"><i class="fa-brands fa-facebook fa-2xl"></i></a>
            <a href="#" class="text-white mx-2"><i class="fa-brands fa-instagram fa-2xl"></i></a>
            <a href="#" class="text-white mx-2"><i class="fa-brands fa-twitter fa-2xl"></i></a>
        </div>
        <div class="col-span-4">Ho Chi Minh City</div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>

</body>

</html>

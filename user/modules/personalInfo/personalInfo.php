<?php
require_once '../../includes/config.php';
session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

// Lấy thông tin người dùng từ session
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
$name = $_SESSION['name'];
$gender = $_SESSION['gender'];
$dateOfBirth = $_SESSION['dateOfBirth'];
$phone = $_SESSION['phone'];
$address = $_SESSION['address'];

// Truy vấn cơ sở dữ liệu để lấy thông tin người dùng (nếu cần)
$sql = "SELECT id, name, sex, dateofbirth, phone, address FROM Users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../detailProduct/detailProduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="personalInfo.css">
    
</head>

<body>
    <?php include '../../includes/header.php'; ?>

    <div class="container mx-auto py-8">
        
    </div>

    <section class="content">
        <aside class="h-full flex flex-col justify-between">
            <div>
                <div class="info">
                    <a href="/user/modules/personalInfo/personalInfo.php?id=<?php echo $userID ?>">Thông tin cá nhân</a>
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
            <h3 class="text-2xl font-bold mb-6">Hồ Sơ Của Tôi</h3>
            <p class = "text-gray-600 mb-2">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            <hr class="border-black my-6">


            <form action="updateInfo.php" method="POST" class="personal-info-form">
                <input type="hidden" name="id" value="<?php echo $userID ?>">

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 dark:text-white font-medium mb-2">Họ và tên</label>
                    <input type="text" name="name" id="name"
                        class="block w-full py-2.5 px-4 text-base text-gray-900 bg-transparent border-b-2 border-gray-300 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue-600"
                        placeholder=" " value="<?php echo $user['name']; ?>" required />
                </div>

                <div class="mb-6">
                    <label for="phone" class="block text-gray-700 dark:text-white font-medium mb-2">Số điện thoại</label>
                    <input type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" name="phone" id="phone"
                        class="block w-full py-2.5 px-4 text-base text-gray-900 bg-transparent border-b-2 border-gray-300 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue-600"
                        placeholder=" " value="<?php echo $user['phone']; ?>" required />
                </div>

                <div class="mb-6">
                    <label for="gender" class="block text-gray-700 dark:text-white font-medium mb-2">Giới tính</label>
                    <select name="gender" id="gender"
                        class="block w-full py-2.5 px-4 text-base text-gray-900 bg-transparent border-b-2 border-gray-300 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue-600"
                        required>
                        <option value="Nam" <?php if($user['sex'] === 'Nam') echo 'selected'; ?>>Nam</option>
                        <option value="Nữ" <?php if($user['sex'] === 'Nữ') echo 'selected'; ?>>Nữ</option>
                        <option value="Khác" <?php if($user['sex'] === 'Khác') echo 'selected'; ?>>Khác</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="dateOfBirth" class="block text-gray-700 dark:text-white font-medium mb-2">Năm sinh</label>
                    <input type="date" name="dateOfBirth" id="dateOfBirth"
                        class="block w-full py-2.5 px-4 text-base text-gray-900 bg-transparent border-b-2 border-gray-300 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue-600"
                        placeholder=" " value="<?php echo $user['dateofbirth']; ?>" required />
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-gray-700 dark:text-white font-medium mb-2">Địa chỉ</label>
                    <input type="text" name="address" id="address"
                        class="block w-full py-2.5 px-4 text-base text-gray-900 bg-transparent border-b-2 border-gray-300 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue-600"
                        placeholder=" " value="<?php echo $user['address']; ?>" required />
                </div>

                <div class="submit-btn">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">Lưu
                        thay đổi</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>

</body>

</html>

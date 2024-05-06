<?php
require_once '../../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['floating_loginname'];
    $password = $_POST['floating_password'];
    $repeat_password = $_POST['repeat_password'];
    $name = $_POST['floating_name'];
    $birthday = $_POST['floating_birthday'];
    $gender = $_POST['gender'];
    $address = $_POST['floating_address'];
    $phone = $_POST['floating_phone'];
    $email = $_POST['floating_email'];
    $role = 'user';

    if ($password != $repeat_password) {
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Account (username, password, role, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashed_password, $role, $email);
    $stmt->execute();
    $account_id = $stmt->insert_id;

    if ($role == 'admin') {
        $stmt = $conn->prepare("INSERT INTO Admin (id, name, sex, dateofbirth, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $account_id, $name, $gender, $birthday, $phone, $address);
    } 
    if ($role == 'user') {
        $stmt = $conn->prepare("INSERT INTO Users (id, name, sex, dateofbirth, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $account_id, $name, $gender, $birthday, $phone, $address);
    }

    if ($stmt->execute()) {
        header("Location: Login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../../templates/styles/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #fff;">
        <a class="navbar-brand" href="homePage.php">
            <img src="../../templates/img/logo.png" alt="" class="navigation__logo h-20">
        </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../homePage/homePage.php">Trang chủ</a>
            </li>
        </ul>

        <div class="navigation__login" style="margin-left: 30px; margin-right: 100px;">
            <a class="btn btn-outline-secondary" href="./Login.php" role="button">Đăng nhập</a>
            <a class="btn btn-outline-secondary" href="./Register.php" role="button">Đăng ký</a>
        </div>
        <!-- </div> -->
    </nav>

    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-1 gap-8 lg:gap-16">
            <div>
                <div class="w-full lg:max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800"
                    style="margin: auto">
                    <h2 class="text-4xl text-center font-bold text-gray-900 dark:text-white">
                        Đăng ký
                    </h2>
                    <hr style="border: 1px solid rgb(131, 131, 131); margin: 2% 0.5% 2% 0.5%;">
                    <form action="Register.php" method="post">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="floating_loginname" id="floating_loginname"
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_loginname"
                                class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Tên đăng nhập</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="password" name="floating_password" id="floating_password"
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_password"
                                class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mật
                                khẩu</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="password" name="repeat_password" id="floating_repeat_password"
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_repeat_password"
                                class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nhập
                                lại mật khẩu</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="floating_name" id="floating_name"
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_name"
                                class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Họ
                                và tên</label>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="date" name="floating_birthday" id="floating_birthday"
                                    class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="floating_birthday"
                                    class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Năm
                                    sinh</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <select id="gender" name="gender"
                                    class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required>
                                    <option value="M">Nam</option>
                                    <option value="F">Nữ</option>
                                </select>
                                <label for="gender"
                                    class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Giới
                                    tính</label>
                            </div>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="floating_address" id="floating_address"
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_address"
                                class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Địa
                                chỉ</label>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" name="floating_phone"
                                    id="floating_phone"
                                    class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="floating_phone"
                                    class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Số
                                    điện thoại</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="email" name="floating_email" id="floating_email"
                                    class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="floating_email"
                                    class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Địa
                                    chỉ Email</label>
                            </div>
                        </div>
                        <!-- <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <select name="role"
                                    class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    id="floating_roles" placeholder=" " required>
                                    <option value="user">Người dùng</option>
                                    <option value="admin">Quản trị viên</option>
                                </select>
                                <label for="floating_address"
                                    class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Vai
                                    trò</label>
                            </div>
                        </div> -->
                        <div class="text-base font-medium text-gray-900 dark:text-white">
                            Bằng cách nhấp vào Đăng ký, bạn đồng ý với
                            <a href="#" target="_blank">Điều khoản</a>,
                            <a href="#" target="_blank">Chính sách quyền riêng tư</a>
                            và <a href="#" target="_blank">Chính sách cookie</a> của chúng tôi.
                            <p></p>
                        </div>
                        <div class="flex justify-center">
                            <button id="login-button" type="submit" class="w-100 px-5 py-3 text-base font-medium text-center text-white bg-yellow-400 rounded-lg hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-200 sm:w-auto dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-600">
                                Đăng ký
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="grid grid-cols-4 grid-rows-4 gap-4 text-center text-white bg-yellow-400 rounded-lg ">
        <div class="col-start-1 col-span-4 ">
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
                <img src="../../templates/img/logo.png" alt="" class="navigation__logo h-16">
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
<?php
session_start();
require_once '../../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM Account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // $stmt = $conn->prepare("SELECT a.id, a.password, a.role, a.email, u.name, u.sex, u.dateofbirth, u.phone, u.address
    //                         FROM Account a
    //                         INNER JOIN Users u ON a.id = u.id
    //                         WHERE a.username = ?");
    // $stmt->bind_param("s", $username);
    // $stmt->execute();
    
    // $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $role = $row['role'];
        // $row = $result->fetch_assoc();
        // $userId = $row['id'];
        $hashed_password = $row['password'];
        // $role = $row['role'];
        // $email = $row['email'];
        // $name = $row['name'];
        // $gender = $row['sex'];
        // $dateOfBirth = $row['dateofbirth'];
        // $phone = $row['phone'];
        // $address = $row['address'];

        if ($role === 'admin') {
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $username;
            header("Location: ../../../admin/modules/users/index.php");
            exit();
        } elseif (password_verify($password, $hashed_password)) {
            $stmt = $conn->prepare("SELECT a.id, a.password, a.role, a.email, u.name, u.sex, u.dateofbirth, u.phone, u.address
                            FROM Account a
                            INNER JOIN Users u ON a.id = u.id
                            WHERE a.username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            
            $result = $stmt->get_result();

            $row = $result->fetch_assoc();

            $_SESSION['role'] = $row['role'];;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['gender'] = $row['sex'];
            $_SESSION['dateOfBirth'] = $row['dateofbirth'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['address'] = $row['address'];
            header("Location: ../homePage/homePage.php");
            exit();
        } else {
            echo "Sai tên đăng nhập hoặc mật khẩu";
        }
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
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../templates/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
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

    <section class="bg-gray-50 dark:bg-gray-900 min-h-screen-xl">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-8 lg:gap-16">
            <div class="flex flex-col justify-center">

                <!-- images in here -->
                <img class="max-w-full" src="../../templates/img/login1.png" alt="">
            
            </div>
            <div>
                <div class="w-full lg:max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center" style="font-size: 24pt">
                        Đăng nhập
                    </h2>
                    <form class="mt-8 space-y-6" action="#" method = "post">
                        <div>
                            <label for="username"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên đăng
                                nhập</label>
                            <input type="text" name="username" id="username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Tên đăng nhập" required>
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mật khẩu</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" aria-describedby="remember" name="remember" type="checkbox"
                                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                    required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="font-medium text-gray-500 dark:text-gray-400">Ghi nhớ tài khoản</label>
                            </div>
                            <a href="#"
                                class="ml-auto text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Quên mật khẩu?</a>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button id="login-button" type="submit" class="w-100 px-5 py-3 text-base font-medium text-center text-white bg-yellow-400 rounded-lg hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-200 sm:w-auto dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-600">
                                Đăng nhập
                            </button>
                        </div>
                        <div class="text-sm font-medium text-gray-900 dark:text-white text-center">
                            Chưa có tài khoản? <a href="./Register.php"
                                class="text-yellow-500 hover:underline dark:text-yellow-400">Đăng ký ngay</a>
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
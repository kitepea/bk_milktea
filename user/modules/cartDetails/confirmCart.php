<?php
    require_once '../../includes/config.php';
    session_start();
    $isLoggedIn = isset($_SESSION['username']);
    $username = $isLoggedIn ? $_SESSION['username'] : '';

    $productData = isset($_POST['productData']) ? $_POST['productData'] : '';
    $products = json_decode($productData, true); // Tham số true để giải mã thành mảng kết hợp


    // Kiểm tra xem nút "Đặt hàng" đã được nhấn hay chưa
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullName = isset($_POST['floating_loginname']) ? $_POST['floating_loginname'] : '';
        $email = isset($_POST['floating_email']) ? $_POST['floating_email'] : '';
        $phone = isset($_POST['floating_phone']) ? $_POST['floating_phone'] : '';
        $address = isset($_POST['floating_address']) ? $_POST['floating_address'] : '';
        $note = isset($_POST['floating_note']) ? $_POST['floating_note'] : '';
        $shippingMethod = isset($_POST['shipping_method']) ? $_POST['shipping_method'] : '';
        $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';


        $totalMoney = 0;


            // Lấy user_id từ session
            $userId = $_SESSION['user_id'];

            // Bắt đầu giao dịch
            $conn->begin_transaction();

            try {

                // Thêm đơn hàng vào bảng Orders
                $stmt = $conn->prepare("INSERT INTO Orders (user_id, full_name, email, phone_number, address, note, shipping_method, payment_method, total_money) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isssssssi", $userId, $fullName, $email, $phone, $address, $note, $shippingMethod, $paymentMethod, $totalMoney);

                $stmt->execute();
                $orderId = $conn->insert_id;

                // Commit giao dịch
                $conn->commit();

                echo "Đặt hàng thành công!";
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $conn->rollback();
                echo "Lỗi khi đặt hàng: " . $e->getMessage();
            }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết giỏ hàng</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <link rel="stylesheet" href="confirmCart.css">
</head>

<body>
    <?php
    include '../../includes/header.php'
    ?>

<div class="container mx-auto py-8">
        
        </div>
        <div class="container mx-auto py-8">
        
        </div>

    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-1 gap-8 lg:gap-16">
            <div>
                <div class="w-full lg:max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800"
                    style="margin: auto">
                    <h2 class="text-2xl text-center font-bold text-gray-900 dark:text-white">
                        Thông tin nhận hàng
                    </h2>
                    <hr style="border: 1px solid rgb(131, 131, 131); margin: 2% 0.5% 2% 0.5%;">
                    <form action="confirmCart.php" method="post">

                    <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="floating_loginname" id="floating_loginname"
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_loginname"
                                class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Người đặt</label>
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

                            <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="floating_address" id="floating_address"
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_address"
                                class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Địa
                                chỉ</label>
                        </div>

                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="floating_note" id="floating_note"
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_note"
                                class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ghi chú</label>
                        </div>

                        <div class="relative z-0 w-full mb-6 group">
                                <select id="shipping_method" name="shipping_method"
                                    class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required>
                                    <option value="Hỏa tốc">Hỏa tốc</option>
                                    <option value="Giao nhanh">Giao nhanh</option>
                                </select>
                                <label for="shipping_method"
                                    class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Phương thức giao hàng</label>
                            </div>

                        <div class="relative z-0 w-full mb-6 group">
                                <select id="payment_method" name="payment_method"
                                    class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required>
                                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                                    <option value="other">Phương thức thanh toán khác</option>
                                </select>
                                <label for="payment_method"
                                    class="peer-focus:font-medium absolute text-base text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Phương thức thanh toán</label>
                            </div>

                            <div class="flex justify-center">
                            <input type="hidden" id="totalMoney" name="totalMoney">
                            <button id="submit_order" type="submit"
                                class="w-100 px-5 py-3 text-base font-medium text-center text-white bg-yellow-400 rounded-lg hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-200 sm:w-auto dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-600">
                                Đặt hàng
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

    <script>
   
</script>

</body>

</html> 
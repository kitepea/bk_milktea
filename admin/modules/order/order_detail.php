<?php
// Kết nối đến cơ sở dữ liệu
require_once '../../config.php';

// Lấy id của đơn hàng từ URL
$id = $_GET['id'];

// Truy vấn cơ sở dữ liệu để lấy thông tin chi tiết của đơn hàng
$order_sql = "SELECT * FROM Orders WHERE id = $id";
$order_result = mysqli_query($link, $order_sql);

// Truy vấn cơ sở dữ liệu để lấy thông tin các mặt hàng trong đơn hàng
$order_details_sql = "SELECT Product.name AS product_name, Order_details.number_of_products 
                      FROM Order_details 
                      INNER JOIN Product ON Order_details.product_id = Product.id 
                      WHERE Order_details.order_id = $id";
$order_details_result = mysqli_query($link, $order_details_sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../include/header-footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
  </head>
  <body>
    <div class="container-self">
        <?php include '../include/header.php' ?>
        <div class="body my-5 container-fluid">
            <div class="row mb-2 text-center">
                <div class="h3 text-primary">Chi tiết đơn hàng</div>
            </div>
            <div class="row mb-2">
                <div class="col-xl-3 col-md-4 col-sm-12">
                    <a href="./order.php">
                        <button class="btn btn-primary m-3">
                            Quay lại
                        </button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="container mb-5">
                        <div class="row">
                            <div class="col-12 shadow bg-body rounded p-3 mb-3">
                            <?php 
                                if ($order_result && mysqli_num_rows($order_result) > 0) {
                                    $order_row = mysqli_fetch_assoc($order_result);
                                    // Hiển thị thông tin chi tiết của đơn hàng
                                    echo "<p>Đơn hàng: " . $order_row['id'] . "</p>";
                                    echo "<p>Người đặt: " . $order_row['full_name'] . "</p>";
                                    echo "<p>Email: " . $order_row['email'] . "</p>";
                                    echo "<p>Địa chỉ nhận hàng: " . $order_row['address'] . "</p>";
                                    echo "<p>Số điện thoại: " . $order_row['phone_number'] . "</p>";
                                    // Ghi chú
                                    echo "<p>Thời gian đặt: " . $order_row['order_date'] . "</p>";
                                    echo "<p>Trạng thái đơn hàng: " . $order_row['status'] . "</p>";
                                    echo "<p>Tổng tiền: " . $order_row['total_money'] . "</p>";
                                    echo "<p>Phương thức thanh toán: " . $order_row['payment_method'] . "</p>";

                                    // Hiển thị các mặt hàng trong đơn hàng
                                    if ($order_details_result && mysqli_num_rows($order_details_result) > 0) {
                                        echo "<p>Các mặt hàng:</p>";
                                        echo "<ul>";
                                        while ($order_details_row = mysqli_fetch_assoc($order_details_result)) {
                                            echo "<li>" . $order_details_row['product_name'] . " - Số lượng: " . $order_details_row['number_of_products'] . "</li>";
                                        }
                                        echo "</ul>";
                                    } else {
                                        echo "<p>Không có mặt hàng nào trong đơn hàng này.</p>";
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../include/footer.php' ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

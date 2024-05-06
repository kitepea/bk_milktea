<?php
// Kết nối đến cơ sở dữ liệu
require_once '../../config.php';

// Xử lý yêu cầu chỉnh sửa thông tin đơn hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $order_id = $_GET["id"]; // Lấy order_id từ tham số truyền qua URL
    $full_name = $_POST["full_name"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];
    $note = $_POST["note"];
    $status = $_POST["status"];

    $sql = "UPDATE Orders SET full_name='$full_name', phone_number='$phone_number', address='$address', note='$note', status='$status' WHERE id='$order_id'";

    if (mysqli_query($link, $sql)) {
        header("Location: order.php");
        exit();
    } else {
        echo "Error updating order: " . mysqli_error($link);
    }
}

// Lấy thông tin đơn hàng cần chỉnh sửa
if (isset($_GET["id"])) {
    $order_id = $_GET["id"];
    $sql = "SELECT * FROM Orders WHERE id=$order_id";
    $result = mysqli_query($link, $sql);
    $order = mysqli_fetch_assoc($result);
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../include/header-footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="container-self">
    <?php
        include '../include/header.php'
        ?>
        <div class="body my-5 container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col text-center h4 text-primary">
                        Cập nhật đơn hàng
                    </div>
                </div>
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8 shadow p-3 mb-5 bg-body rounded">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ tên người đặt</label>
                                <input type="text" class="form-control" name="full_name" value=<?php echo $order['full_name'] ?> id="name" placeholder=<?php echo $order['full_name'] ?>>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone_number" value=<?php echo $order['phone_number']?> id="quantity" placeholder=<?php echo $order['phone_number']?>>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="<?php echo $order['address']; ?>" id="address" placeholder="<?php echo $order['address']; ?>">

                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Ghi chú</label>
                                <input type="text" class="form-control" name="note" value="<?php echo $order['note']; ?>" id="note" placeholder=<?php echo $order['note']; ?>>
                            </div>
                                <label for="desc" class="form-label">Trạng thái đơn hàng</label>
                                <select name="status" class="form-select" id="">
                                    <option value="1">Đang chờ</option>
                                    <option value="2">Đang xử lý</option>
                                    <option value="3">Đã giao</option>
                                    <option value="4">Đang giao</option>
                                    <option value="5">Huỷ đơn   </option>
                                </select>
                                <input type="submit" class="btn btn-primary w-100 mt-2" value="Cập nhật" name="update">
                            </div>
                        </form>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>


        </div>
        <?php
        include '../include/footer.php'
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php


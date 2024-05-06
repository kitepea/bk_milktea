<?php
// admin/comments.php

// Kết nối đến cơ sở dữ liệu
require_once '../../config.php';

// Truy vấn để lấy tất cả các bình luận từ cơ sở dữ liệu
$sql = "SELECT c.id, c.content, u.name
    FROM comments c
    JOIN Users u ON c.user_id = u.id";
$result = mysqli_query($link, $sql);
// print_r($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bình luận</title>
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
            <table class="table table-striped text-center">
                <thead>
                    <tr class="table-primary text-center">
                        <th scope ="cole">STT</th>
                        <th scope ="cole">Tên</th>
                        <th colspan='2' scope ="cole">Bình luận</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                if (mysqli_num_rows($result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>
                        <tbody>
                            <tr>
                                <td class='align-middle text-center' scope="row"><?php echo $count ?></td>
                                <td class='align-middle'><?php echo $row["name"] ?></td>
                                <td class='align-middle text-center'><?php echo $row["content"] ?></td>
                                <td class='align-middle'>
                                    <div class="d-inline-flex">
                                        <!-- delete -->
                                        <a href="./delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger m-1" onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i class="fas fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                <?php
                        $count++;
                    };
                }
                ?>
                </tbody>
            </table>
            <!-- modal delete
            <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Xoá đơn hàng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="delete.php" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="id" />
                                <p>Bạn chắc chắn muốn xoá?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary btn-outline-light" type="button" data-bs-dismiss="modal">Đóng
                                    lại</button>
                                <button class="btn btn-danger btn-outline-light" type="submit">Xác nhận</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
        </div>
        <?php
        include '../include/footer.php'
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<?php
// Giải phóng kết quả
mysqli_free_result($result);

// Đóng kết nối
mysqli_close($link);
?>
</html>

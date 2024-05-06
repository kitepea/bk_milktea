<?php
require_once '../../config.php';

$sql = "SELECT * FROM Users";
$users = mysqli_query($link, $sql);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../include/header-footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                        <th scope="col">STT</th>
                        <th scope="col">Username</th>
                        <th scope="col">Giới tính</th>
                        <th scope="col">Ngày sinh</th>
                        <th scope="col">SĐT</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php
                if ($users->num_rows > 0) {
                    $count = 1;
                    while ($row = $users->fetch_assoc()) {
                ?>
                        <tbody>
                            <tr>
                                <th class='align-middle text-center' scope="row"><?php echo $count ?></th>
                                <td class='align-middle text-center'><?php echo $row["name"] ?></td>
                                <td class='align-middle'><?php echo $row["sex"] ?></td>
                                <td class='align-middle text-center'><?php echo $row["dateofbirth"] ?></td>
                                <td class='align-middle'><?php echo $row["phone"] ?></td>
                                <td class='align-middle text-center'><?php echo $row["address"] ?></td>
                                <td class='align-middle'>
                                    <div class="d-inline-flex">
                                        <button type='button' class='btn-delete btn btn-danger m-1' data-bs-id='<?php echo $row['id'] ?>' data-bs-target='#Delete' data-bs-toggle='modal'><i class="fas fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                <?php
                        $count++;
                    };
                }
                ?>
            </table>
            <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Xoá người dùng</h5>
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
            </div>
        </div>
        <?php
        include '../include/footer.php'
        ?>
    </div>
    <script>
        $(".btn-delete").click(function(e) {
            const id = this.getAttribute('data-bs-id')
            $("#Delete input[name='id']").val(id);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
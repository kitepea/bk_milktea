<?php

$rootPath = '/admin/modules';
$currentPage = 1;
$totalPage = 1;

require_once '../../config.php';

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../include/header-footer.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
</head>

<body>

<?php
    $sqlShowProducts = "SELECT p.id, p.name, p.price, p.description, c.name AS category_name 
    FROM product p 
    INNER JOIN categories c ON p.category_id = c.id
    ORDER BY p.id";
    $products = $link->query($sqlShowProducts);
    ?>
    <div class="container-self">
        <?php
        include '../include/header.php'
        ?>
        <div class="body my-5 container-fluid">
            <div class="row mb-2 text-center">
                <div class="h3 text-primary">Quản lý sản phẩm</div>
            </div>
            <div class="row mb-2">
                <div class="col-xl-3 col-md-4 col-sm-12">
                    <a href="./add.php" class="ms-3 mb-3 btn btn-primary">Thêm sản phẩm</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="container-fluid mb-5">
                        <div class="row">
                            <?php
                            if ($products->num_rows > 0) {
                                $totalProducts = $products->num_rows;
                                $currentPage = 1;
                                if (isset($_GET['page'])) {
                                    settype($_GET['page'], 'int');
                                    $currentPage = $_GET['page'];
                                }
                                $limit = 6;
                                $totalPage = ceil($totalProducts / $limit);

                                if ($currentPage > $totalPage) {
                                    $currentPage = $totalPage;
                                } elseif ($currentPage < 1) {
                                    $currentPage = 1;
                                }

                                $start = ($currentPage - 1) * $limit;
                                $sqlShowProducts = $sqlShowProducts . " LIMIT $start, $limit";
                                $products = $link->query($sqlShowProducts);
                            ?>
                                <div class="col-12 mb-3">
                                    <table class="table">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th scope="col">#id</th>
                                                <th scope="col">Tên sản phẩm</th>
                                                <th scope="col">Giá</th>
                                                <th scope="col">Mô tả</th>
                                                <th scope="col">Loại đồ uống</th>
                                                <th scope="col">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $products->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <th class='align-middle text-center' scope="row"><?php echo $row['id'] ?></th>
                                                    <td class='align-middle text-center'><?php echo $row['name'] ?></td>
                                                    <td class='align-middle text-center'><?php echo $row['price'] ?></td>
                                                    <td class='align-middle text-center'><?php echo $row['description'] ?></td>
                                                    <td class='align-middle text-center'><?php echo $row['category_name'] ?></td>
                                                    <td class='align-middle text-center'>
                                                        <a href="./update.php?id=<?= $row['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
                                                        <a href="javascript:void(0)" onclick="openDeleteModal(<?php echo $row['id'] ?>)" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            } else {
                                echo '<div class="alert alert-warning" role="alert"><i class="far fa-circle"></i> Không tìm thấy sản phẩm nào</div>';
                            }
                            $link->close();
                            ?>
                        </div>
                        <div class="row">
                            <!-- Pagination -->
                            <nav class="mt-3">
                                <ul class="pagination pagination-lg d-flex justify-content-center">
                                    <?php
                                    if ($currentPage > 1 && $totalPage > 1) {
                                    ?>
                                        <li class="page-item">
                                            <a href="<?php echo $rootPath ?>/products/index.php?page=<?php echo ($currentPage - 1); ?>" class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" data-remote="true">&lsaquo; Prev</a>
                                        </li>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    for ($i = 1; $i <= $totalPage; $i++) {
                                        if ($i == $currentPage) {
                                    ?>
                                            <li class="page-item active">
                                                <span rel="prev" class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" data-remote="true"><?php echo $i ?></span>
                                            </li>
                                        <?php
                                        } else {
                                        ?>
                                            <li class="page-item">
                                                <a data-remote="true" class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="<?php echo $rootPath ?>/products/index.php?page=<?php echo $i ?>"><?php echo $i ?></a>
                                            </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    if ($currentPage < $totalPage && $totalPage > 1) {
                                    ?>
                                        <li class="page-item">
                                            <a href="<?php echo $rootPath; ?>/products/index.php?page=<?php echo ($currentPage + 1) ?>" class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" data-remote="true">Next &rsaquo;</a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa sản phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc chắn muốn xóa sản phẩm này không?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <a href="#" id="confirmDeleteButton" class="btn btn-danger">Xóa</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="notificationModalLabel">Thông báo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="notificationMessage">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <?php
        include '../include/footer.php'
        ?>
    </div>
    <script>
        function openDeleteModal(id) {
            var deleteUrl = 'delete.php?id=' + id;
            document.getElementById('confirmDeleteButton').setAttribute('href', deleteUrl);
            var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.cookie.indexOf('thongBao') !== -1) {
                var thongBao = decodeURIComponent(document.cookie.replace(/(?:(?:^|.*;\s*)thongBao\s*=\s*([^;]*).*$)|^.*$/, "$1"));

                var notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
                notificationModal.show();

                document.getElementById('notificationMessage').innerText = thongBao;

                document.cookie = "thongBao=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
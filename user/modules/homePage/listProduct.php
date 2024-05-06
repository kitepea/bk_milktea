<?php
require_once '../../includes/config.php';
session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

$allProductsHTML = '';

$sql = "SELECT p.id AS product_id, p.name AS product_name, p.price, p.image_url, c.name AS category_name
        FROM Product p
        JOIN Categories c ON p.category_id = c.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imageUrl = $row["image_url"] ?? '../../templates/img/default-img.jpg'; 

        $allProductsHTML .= '
        <div class="w-52 bg-white shadow-md rounded-xl transform transition duration-500 hover:scale-105 hover:shadow-xl">
            <a href="../detailProduct/detailProduct.php?id=' . $row["product_id"] . '">                
                <img src="' . $imageUrl . '" alt="' . htmlspecialchars($row["product_name"], ENT_QUOTES, 'UTF-8') . '" class="h-60 w-52 object-cover rounded-t-xl" />
                <div class="px-4 py-3 w-52">
                    <span class="text-gray-400 mr-3 uppercase text-xs">' . htmlspecialchars($row["category_name"], ENT_QUOTES, 'UTF-8') . '</span>
                    <p class="text-lg font-bold text-black truncate block capitalize">' . htmlspecialchars($row["product_name"], ENT_QUOTES, 'UTF-8') . '</p>
                    <div class="flex items-center">
                        <p class="text-lg font-semibold text-black cursor-auto my-3">$' . number_format($row["price"]) . '</p>
                        <!-- Thêm nút mua hoặc thêm vào giỏ hàng tại đây nếu cần -->
                    </div>
                </div>
            </a>
        </div>
        ';
    }
}

$conn->close();

?>

<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Danh sách sản phẩm</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="homePage.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    </head>
<body>
    <?php
   include '../../includes/header.php'
  ?>

    <div class="container mx-auto py-8" id="all-products">
    <div class="text-center p-10">
        <h1 class="text-3xl">Tất cả sản phẩm</h1>
    </div>

    <div class="mb-4">
    <nav class="flex justify-center">
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
            <li class="mr-2 relative">
                <a href="#" class="inline-flex p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group" id="categoryDropdown">
                    <span>Danh mục sản phẩm</span>
                </a>
                <div class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600" id="categoryDropdownList">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-category="all">Tất cả</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-category="Trà sữa">Trà sữa</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-category="Cà phê">Cà phê</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-category="Sinh tố - Nước ép">Sinh tố - Nước ép</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="mr-2">
                <a href="#" class="inline-flex p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group" data-sort="asc">
                    <span>Giá tăng dần</span>
                </a>
            </li>
            <li class="mr-2">
                <a href="#" class="inline-flex p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray -300 group" data-sort="desc">
                    <span>Giá giảm dần</span>
                </a>
            </li>
            <li class="mr-2">
                <a href="#" class="inline-flex p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group" data-sort="bestselling">
                    <span>Bán chạy</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
    
    <section id="Projects" class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-5 md:grid-cols-2 justify-items-center justify-center gap-y-8 gap-x-14 mt-10 mb-5">
        <?php echo $allProductsHTML; ?>
    </section>

    <nav aria-label="Page navigation example" class="mt-8 flex items-center justify-center">
        <ul class="inline-flex -space-x-px text-sm" id="pagination">
            <!-- Nút phân trang sẽ được tạo tại đây -->
        </ul>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const categoryDropdown = document.getElementById('categoryDropdown');
    const categoryDropdownList = document.getElementById('categoryDropdownList');

    categoryDropdown.addEventListener('click', function() {
        categoryDropdownList.classList.toggle('hidden');
    });

    const filterLinks = document.querySelectorAll('a[data-category], a[data-sort]');
    filterLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const category = this.dataset.category;
            const sort = this.dataset.sort;
            if (category) {
                filterProducts('category_filter.php', category, sort);
            } else {
                filterProducts('price_filter.php', category, sort);
            }
        });
    });
});

function filterProducts(url, category, sort) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const productsSection = document.getElementById('Projects');
            productsSection.innerHTML = xhr.responseText;
        }
    };
    const params = `category=${encodeURIComponent(category)}&sort=${encodeURIComponent(sort)}`;
    xhr.send(params);
}
</script>


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
</body>
</html>
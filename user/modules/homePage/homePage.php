<?php
require_once '../../includes/config.php';

session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

$milkTea_ProductHTML = '';
$coffee_ProductHTML = '';
$juice_ProductHTML = '';
$allProductsHTML = '';

$sql = "SELECT p.id AS product_id, p.name AS product_name, p.price, p.image_url, c.name AS category_name
        FROM Product p
        JOIN Categories c ON p.category_id = c.id
        WHERE c.name = 'Trà sữa';
    ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imageUrl = $row["image_url"] ?? '../../templates/img/default-img.jpg'; 

        $milkTea_ProductHTML .= '
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

$sql = "SELECT p.id AS product_id, p.name AS product_name, p.price, p.image_url, c.name AS category_name
        FROM Product p
        JOIN Categories c ON p.category_id = c.id
        WHERE c.name = 'Cà phê';
    ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imageUrl = $row["image_url"] ?? '../../templates/img/default-img.jpg'; 

        $coffee_ProductHTML .= '
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


$sql = "SELECT p.id AS product_id, p.name AS product_name, p.price, p.image_url, c.name AS category_name
        FROM Product p
        JOIN Categories c ON p.category_id = c.id
        WHERE c.name = 'Sinh tố - Nước ép';
    ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imageUrl = $row["image_url"] ?? '../../templates/img/default-img.jpg'; 

        $juice_ProductHTML .= '
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

$sql = "SELECT p.id AS product_id, p.name AS product_name, p.price, p.image_url, c.name AS category_name
        FROM Product p
        JOIN Categories c ON p.category_id = c.id
        ORDER BY p.quantity_sold DESC, p.id ASC
        LIMIT 20;";

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
    <title>Trang chủ</title>
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
    

  <div class="mx-auto relative">

    <!-- <div class="absolute left-0 right-0 mx-auto flex justify-between px-52 -bottom-16 z-50 ">
      <a href="#" class="bg-white rounded-lg shadow-lg w-64 h-28 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl">
          <img src="../templates/img/ad1.jpg" alt="" class="w-full h-full object-cover">
      </a>
      <a href="#" class="bg-white rounded-lg shadow-lg w-64 h-28 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl">
        <img src="../img/b1.png" alt="" class="w-full h-full object-cover">
      </a>
      <a href="#" class="bg-white rounded-lg shadow-lg w-64 h-28 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl">
        <img src="../img/b1.png" alt="" class="w-full h-full object-cover">
      </a>
      <a href="#" class="bg-white rounded-lg shadow-lg w-64 h-28 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl">
        <img src="../img/b1.png" alt="" class="w-full h-full object-cover">
      </a>
    </div>
     -->

     

    <div id="default-carousel" class="relative" data-carousel="slide" data-interval="5000">
        <!-- Carousel wrapper -->
        <div class="overflow-hidden relative rounded-lg h-500 sm:h-128 md:h-144 lg:h-192 xl:h-200 2xl:h-500">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <span class="absolute text-2xl font-semibold text-white sm:text-3xl dark:text-gray-600">First Slide</span>
                <img src="../../templates/img/carousel-1.jpg" class="block absolute w-full h-full object-cover" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="../../templates/img/carousel-2.png" class="block absolute w-full h-full object-cover" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="../../templates/img/carousel-3.png" class="block absolute w-full h-full object-cover" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
              <img src="../../templates/img/carousel-4.png" class="block absolute w-full h-full object-cover" alt="...">
            </div>

            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
              <img src="../../templates/img/carousel-5.png" class="block absolute w-full h-full object-cover" alt="...">
            </div>
             <!-- Item 6 -->
             <div class="hidden duration-700 ease-in-out" data-carousel-item>
              <img src="../../templates/img/carousel-6.png" class="block absolute w-full h-full object-cover" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        </div>
        <!-- Slider controls -->
        <button type="button" class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-600/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-600/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden">Previous</span>
            </span>
        </button>
        <button type="button" class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-600/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-600/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="hidden">Next</span>
            </span>
        </button>
    </div>
    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</div>

<div >
    <div style="text-align: center; color: #be1e4c;">
        <div style="margin: 52px 0;"></div>
        <h2>SẢN PHẨM CỦA CHÚNG TÔI</h2>
        <div style="margin: 52px 0;"></div>
        <div style="margin: auto; width: 120px; border-bottom: 2px solid #be1e4c;"></div>    
        <div style="margin: 100px 0;"></div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 md:grid-cols-2">

    <div class="bg-white rounded-lg overflow-hidden">
        <a href="#" class="block relative">
        <img src="https://maycha.com.vn/wp-content/uploads/2024/01/luu-do-thanh-mai-300x300.png" alt="" class="w-full h-auto">
        <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300"></div>
        </a>
        <div class="p-4">
        <h4 class="text-lg font-bold mb-2 text-center"><a href="#" class="hover:text-indigo-600" style="color: #be1e4c">Trà Lựu Đỏ Trân Châu Thanh Mai</a></h4>
        <p class="text-gray-600 text-sm text-center">Vị trà đậm đà ẩn chứa hương bánh thơm bánh thơm nồng nàn đặc trưng của Tiramisu tạo nên tầng vị giác đan xen hoàn hảo mà không thể bỏ qua.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden">
        <a href="#" class="block relative">
        <img src="../../templates/img/ts-matcha-vang-sua-768x768.png" alt="" class="w-full h-auto">
        <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300"></div>
        </a>
        <div class="p-4">
        <h4 class="text-lg font-bold mb-2 text-center"><a href="#" class="hover:text-indigo-600" style="color: #be1e4c">Trà Sữa Matcha</a></h4>
        <p class="text-gray-600 text-sm text-center">Hương trà xanh thơm mát cùng với lớp kem sữa thơm béo.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden">
        <a href="#" class="block relative">
        <img src="https://maycha.com.vn/wp-content/uploads/2024/01/luu-do-mang-cau-300x300.png" alt="Trà Lựu Đỏ Mãng Cầu" class="w-full h-auto">
        <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300"></div>
        </a>
        <div class="p-4">
        <h4 class="text-lg font-bold mb-2 text-center"><a href="#" class="hover:text-indigo-600" style="color: #be1e4c">Trà Lựu Đỏ Mãng Cầu</a></h4>
        <p class="text-gray-600 text-sm text-center">Vị trà đậm đà ẩn chứa hương bánh thơm bánh thơm nồng nàn đặc trưng của Tiramisu tạo nên tầng vị giác đan xen hoàn hảo mà không thể bỏ qua.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden">
        <a href="#" class="block relative">
        <img src="../../templates/img/tiramibo-768x768.png" alt="" class="w-full h-auto">
        <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300"></div>
        </a>
        <div class="p-4">
        <h4 class="text-lg font-bold mb-2 text-center"><a href="#" class="hover:text-indigo-600" style="color: #be1e4c">Trà Sữa Bơ</a></h4>
        <p class="text-gray-600 text-sm text-center">Vị trà đậm đà ẩn chứa hương bánh thơm bánh thơm nồng nàn đặc trưng của Tiramisu tạo nên tầng vị giác đan xen hoàn hảo mà không thể bỏ qua.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden">
        <a href="#" class="block relative">
        <img src="../../templates/img/TS-MUOI-1-768x768.png" alt="" class="w-full h-auto">
        <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300"></div>
        </a>
        <div class="p-4">
        <h4 class="text-lg font-bold mb-2 text-center"><a href="#" class="hover:text-indigo-600" style="color: #be1e4c">Trà Sữa Muối</a></h4>
        <p class="text-gray-600 text-sm text-center">Hương vị đậm trà vùng núi Tây Côn Lĩnh kết hợp với lớp foam muối hồng mằn mặn</p>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden">
        <a href="#" class="block relative">
        <img src="../../templates/img/sua-tuoi-duong-den-kem-trung-khe-tran-chau-768x768.png" alt="" class="w-full h-auto">
        <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300"></div>
        </a>
        <div class="p-4">
        <h4 class="text-lg font-bold mb-2 text-center"><a href="#" class="hover:text-indigo-600" style="color: #be1e4c">Trà Sữa Kem Trứng </a></h4>
        <p class="text-gray-600 text-sm text-center">Kết hợp ngọt ngào giữa trà xanh và sữa tươi, uống cùng trân châu đường đen dẻo dai.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden">
        <a href="#" class="block relative">
        <img src="../../templates/img/tra-mang-cau-thanh-yen-quy-ha-768x768.png" alt="" class="w-full h-auto">
        <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300"></div>
        </a>
        <div class="p-4">
        <h4 class="text-lg font-bold mb-2 text-center"><a href="#" class="hover:text-indigo-600" style="color: #be1e4c">Trà Thanh Yên Mãng Cầu</a></h4>
        <p class="text-gray-600 text-sm text-center">Trà Thanh Yên dịu nhẹ kết hợp với vị mãng cầu tươi chua ngọt thanh mát</p>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden">
        <a href="#" class="block relative">
        <img src="../../templates/img/tiramisu-768x768.png" alt="" class="w-full h-auto">
        <div class="absolute inset-0 bg-black bg-opacity-0 transition-all duration-300"></div>
        </a>
        <div class="p-4">
        <h4 class="text-lg font-bold mb-2 text-center"><a href="#" class="hover:text-indigo-600" style="color: #be1e4c">Trà Sữa Tỉamisu</a></h4>
        <p class="text-gray-600 text-sm text-center">Vị trà đậm đà ẩn chứa hương bánh thơm bánh thơm nồng nàn đặc trưng của Tiramisu tạo nên tầng vị giác đan xen hoàn hảo mà không thể bỏ qua.</p>
        </div>
    </div>
    </div>
        <div style="text-align: center;">
            <a href="./listProduct.php" target="_self" class="button-styled">
                <span class="edgtf-btn-text">Xem thêm</span>
            </a>
        </div>
    
</div>


<div class="container mx-auto py-8">

    <div class="absolute pt-32 right-6 -bottom-62 z-30 the-image">
        <a href="#" class="bg-white rounded-lg shadow-lg">
            <img src="../../templates/img/1.gif" alt="..." class="w-36 h-42 object-cover rounded-lg">
        </a>
    </div>
    
    <div class="mx-auto px-4 bg-blue-300 rounded-lg m-10">
    <div class="flex justify-between items-center text-white">
        <h3 class="text-2xl font-bold mb-2">Trà sữa</h3>
        <a class="text-white" href="./listProduct.php">Xem tất cả <i class="fas fa-chevron-right ml-2"></i></a>
    </div>
    <hr class="border-white my-6">
    <div class="container mx-auto relative "> 
        <div class="flex flex-nowrap overflow-x-hidden scroll whitespace-nowrap scroll-smooth scrollbar-hide justify-items-center justify-start gap-x-12 p-3" id="milkTea-slider">
        <?php echo $milkTea_ProductHTML; ?>
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-1/2 -translate-y-1/2 -left-6 z-10 flex justify-center items-center px-4 h-10 cursor-pointer group focus:outline-none" id="milkTea-prev">
        <span class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-600/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-600/70 group-focus:outline-none">
            <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span class="hidden">Previous</span>
        </span>
        </button>
        <button type="button" class="absolute top-1/2 -translate-y-1/2 -right-4 z-10 flex justify-center items-center px-4 h-10 cursor-pointer group focus:outline-none" id="milkTea-next">
        <span class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-600/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-600/70 group-focus:outline-none">
            <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="hidden">Next</span>
        </span>
        </button>
    </div>
    </div>
  
    <div class="mx-auto px-4 bg-green-300 rounded-lg m-10">
    <div class="flex justify-between items-center text-white">
        <h3 class="text-2xl font-bold mb-2">Cà phê</h3>
        <a class="text-white" href="./listProduct.php">Xem tất cả <i class="fas fa-chevron-right ml-2"></i></a>
    </div>
    <hr class="border-white my-6">
    <div class="container mx-auto relative "> 
        <div class="flex flex-nowrap overflow-x-hidden scroll whitespace-nowrap scroll-smooth scrollbar-hide justify-items-center justify-start gap-x-12 p-3" id="coffee-slider">
        <?php echo $coffee_ProductHTML; ?>
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-1/2 -translate-y-1/2 -left-6 z-10 flex justify-center items-center px-4 h-10 cursor-pointer group focus:outline-none" id="coffee-prev">
        <span class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-600/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-600/70 group-focus:outline-none">
            <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span class="hidden">Previous</span>
        </span>
        </button>
        <button type="button" class="absolute top-1/2 -translate-y-1/2 -right-4 z-10 flex justify-center items-center px-4 h-10 cursor-pointer group focus:outline-none" id="coffee-next">
        <span class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-600/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-600/70 group-focus:outline-none">
            <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="hidden">Next</span>
        </span>
        </button>
    </div>
    </div>
  
    <div class="mx-auto px-4 bg-red-300 rounded-lg m-10">
        <div class="flex justify-between items-center text-white">
            <h3 class="text-2xl font-bold mb-2">Sinh tố - Nước ép</h3>
            <a class="text-white" href="./listProduct.php">Xem tất cả <i class="fas fa-chevron-right ml-2"></i></a>
        </div>
        <hr class="border-white my-6">
        <div class="container mx-auto relative "> 
            <div class="flex flex-nowrap overflow-x-hidden scroll whitespace-nowrap scroll-smooth scrollbar-hide justify-items-center justify-start gap-x-12 p-3" id="juice-slider">
            <?php echo $juice_ProductHTML; ?>
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-1/2 -translate-y-1/2 -left-6 z-10 flex justify-center items-center px-4 h-10 cursor-pointer group focus:outline-none" id="juice-prev">
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-600/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-600/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden">Previous</span>
            </span>
            </button>
            <button type="button" class="absolute top-1/2 -translate-y-1/2 -right-4 z-10 flex justify-center items-center px-4 h-10 cursor-pointer group focus:outline-none" id="juice-next">
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-600/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-600/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="hidden">Next</span>
            </span>
            </button>
        </div>
    </div>
    
</div>


<div class="container">
    <a href="#" class="bg-white rounded-lg shadow-lg w-64 h-28 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl">
        <img src="../../templates/img/ad1.jpg" alt="" class="w-full h-full object-cover">
    </a>
</div>


  <div class="container mx-auto py-8" id="all-products">
    <div class="text-center p-10">
        <h1 class="text-3xl">Sản phẩm bán chạy</h1>
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

    document.addEventListener('DOMContentLoaded', (event) => {
    const img = document.querySelector('.the-image');
    const imgOffsetTop = img.offsetTop;

    window.addEventListener('scroll', () => {
        const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollPosition > imgOffsetTop) {
            img.style.position = 'fixed';
            img.style.top = '0px';
        } else {
            img.style.position = 'absolute';
            img.style.top = `${imgOffsetTop}px`;
            }
        });
    });

    function handleSliderClick(slider, prevButton, nextButton) {
        const scrollAmount = 4 * slider.scrollWidth / slider.children.length;

        prevButton.addEventListener('click', () => {
            slider.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });

        nextButton.addEventListener('click', () => {
            slider.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    }

    const milkTeaSlider = document.getElementById('milkTea-slider');
    const milkTeaPrevButton = document.getElementById('milkTea-prev');
    const milkTeaNextButton = document.getElementById('milkTea-next');
    handleSliderClick(milkTeaSlider, milkTeaPrevButton, milkTeaNextButton);

    const coffeeSlider = document.getElementById('coffee-slider');
    const coffeePrevButton = document.getElementById('coffee-prev');
    const coffeeNextButton = document.getElementById('coffee-next');
    handleSliderClick(coffeeSlider, coffeePrevButton, coffeeNextButton);

    const juiceSlider = document.getElementById('juice-slider');
    const juicePrevButton = document.getElementById('juice-prev');
    const juiceNextButton = document.getElementById('juice-next');
    handleSliderClick(juiceSlider, juicePrevButton, juiceNextButton);

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
</body>

</html>


<?php
require_once '../../includes/config.php';

session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

$productId = isset($_GET['id']) ? $_GET['id'] : null;

$sql = "SELECT p.id, p.name, p.price, p.description, p.image_url, c.name AS category_name
        FROM Product p
        JOIN Categories c ON p.category_id = c.id
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Lấy ảnh sản phẩm từ bảng Product
$productImage = $product['image_url'] ?? '../img/default-img.jpg';

$sql = "SELECT id, name, price FROM Product WHERE category_id = (SELECT id FROM Categories WHERE name = 'Topping')";
$result = $conn->query($sql);
$toppings = $result->fetch_all(MYSQLI_ASSOC);

function chunkArray($array, $chunkSize) {
    $chunks = array_chunk($array, $chunkSize);
    return $chunks;
}

$toppingChunks = chunkArray($toppings, 5);

// Lấy danh sách bình luận của sản phẩm
$sql = "SELECT c.id, c.content, c.created_at, u.name
        FROM Comments c
        JOIN Users u ON c.user_id = u.id
        WHERE c.product_id = ?
        ORDER BY c.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$comments = $result->fetch_all(MYSQLI_ASSOC);
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chi tiết sản phẩm</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="detailProduct.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    </head>
<body>
<?php
   include '../../includes/header.php'
  ?>

  <div class="bg-gray-100 dark:bg-gray-800 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="flex flex-col md:flex-row -mx-4">
            <div class="md:flex-1 px-4">
                
            <div class="h-[460px] rounded-lg dark:bg-gray-700 mb-4">
                <?php if (!empty($productImage)): ?>
                    <img class="w-full h-full object-cover" src="<?php echo $productImage; ?>" alt="Product Image">
                <?php else: ?>
                    <img class="w-full h-full object-cover" src="../../templates/img/default-img.jpg" alt="Product Image">
                <?php endif; ?>
            </div>
                <div class="flex -mx-2 mb-4">
                        <div class="w-1/2 px-2">
                            <button class="w-full bg-gray-900 dark:bg-gray-600 text-white py-2 px-4 rounded-full font-bold hover:bg-gray-800 dark:hover:bg-gray-700 addToCart" id = "addToCart">Thêm vào giỏ hàng</button>
                        </div>
                        <div class="w-1/2 px-2">
                            <button class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white py-2 px-4 rounded-full font-bold hover:bg-gray-300 dark:hover:bg-gray-600 addAndGoToCart" id = "addAndGoToCart">Mua ngay</button>
                        </div>
                    </div>
            </div>
            <div class="md:flex-1 px-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2"><?php echo $product['name']; ?></h2>
                <div class="flex mb-4">
                    <div class="mr-4">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Giá: </span>
                        <span class="text-gray-600 dark:text-gray-300"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</span>
                    </div>
                    <div>
                        <span class="font-bold text-gray-700 dark:text-gray-300">Tình trạng:</span>
                        <span class="text-gray-600 dark:text-gray-300">Còn hàng</span>
                    </div>
                </div>
                <div class="mb-4">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Chọn Size:</span>
                    <div class="flex items-center mt-2">
                        <button id="sizeSmallBtn" class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-white py-2 px-4 rounded-full font-bold mr-2 hover:bg-gray-400 dark:hover:bg-gray-600" data-size="small">Nhỏ</button>
                        <button id="sizeMediumBtn" class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-white py-2 px-4 rounded-full font-bold mr-2 hover:bg-gray-400 dark:hover:bg-gray-600" data-size="medium">Vừa</button>
                        <button id="sizeLargeBtn" class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-white py-2 px-4 rounded-full font-bold mr-2 hover:bg-gray-400 dark:hover:bg-gray-600" data-size="large">Lớn</button>
                    </div>
                </div>

                <div class="mb-4">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Chọn Topping:</span>
                    <?php foreach ($toppingChunks as $toppingChunk): ?>
                        <div class="flex flex-wrap items-center mt-2">
                            <?php foreach ($toppingChunk as $topping): ?>
                                <button id="topping-<?php echo $topping['id']; ?>" class="topping-button bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-white py-2 px-4 rounded-full font-bold mr-2 mb-2 hover:bg-gray-400 dark:hover:bg-gray-600" data-price="<?php echo $topping['price']; ?>"><?php echo $topping['name']; ?></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mb-4 flex items-center">
                    <span class="font-bold text-gray-700 dark:text-gray-300 mr-2">Số lượng:</span>
                    <div class="flex items-center border border-gray-300 dark:border-gray-700 rounded-md">
                        <button id="decrementBtn" class="text-gray-700 dark:text-white bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 px-3 border-r border-gray-300 dark:border-gray-700 rounded-l-md focus:outline-none">
                            −
                        </button>
                        <input id="quantityInput" type="number" min="1" value="1" class="w-16 text-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:outline-none" />
                        <button id="incrementBtn" class="text-gray-700 dark:text-white bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 px-3 border-l border-gray-300 dark:border-gray-700 rounded-r-md focus:outline-none">
                            +
                        </button>
                    </div>
                </div>
                

                
                <div class="mb-4">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Tổng giá:</span>
                    <span id="totalPrice" class="text-gray-600 dark:text-gray-300"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</span>
                </div>

                <div>
                    <span class="font-bold text-gray-700 dark:text-gray-300">Mô tả sản phẩm:</span>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                        <?php echo $product['description']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto py-8">
    <div class="my-8">
    <h3 class="text-lg font-bold mb-4">Bình luận</h3>
    <div id="comment-list" class="space-y-4">
        <?php foreach ($comments as $comment): ?>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-md">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-lg font-semibold"><?php echo $comment['name']; ?></h4>
                    <span class="text-gray-500 text-sm">
                        <?php
                            $timestamp = strtotime($comment['created_at']);
                            $formattedDate = date('s:i:H d-m-Y', $timestamp);
                            echo $formattedDate;
                        ?>
                    </span>
                </div>
                <p class="text-gray-700 dark:text-gray-300"><?php echo $comment['content']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($isLoggedIn): ?>
        <div class="mt-4">
            <h4 class="text-md font-bold mb-2">Gửi bình luận</h4>
            <form id="comment-form" class="flex flex-col">
                <textarea id="comment-content" class="w-full border border-gray-300 rounded-md py-2 px-3 mb-2" placeholder="Nhập bình luận của bạn..." rows="3"></textarea>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md self-start hover:bg-blue-600">Gửi</button>
            </form>
        </div>
    <?php else: ?>
        <p>Bạn cần đăng nhập để có thể gửi bình luận.</p>
    <?php endif; ?>
</div>                        
    </div>

</div>

<script>

    
    const productPrice = <?php echo $product['price']; ?>;
    const toppingButtons = document.querySelectorAll('.topping-button');
    const sizeButtons = document.querySelectorAll('button[data-size]');
    const totalPriceElement = document.getElementById('totalPrice');
    const quantityInput = document.getElementById('quantityInput');
    const quantity = parseInt(quantityInput.value, 10);

    let currentSize = 'small';
    const sizePrice = {
        'small': 1,
        'medium': 1.25,
        'large': 1.5
    };

    let totalPrice = productPrice;
    totalPriceElement.textContent = `${totalPrice}đ`;

    const selectedToppings = new Map();

    function updateTotalPrice() {
        const quantity = parseInt(quantityInput.value, 10);
        const baseTotalPrice = productPrice * sizePrice[currentSize];
        totalPrice = baseTotalPrice * quantity;

        for (const [toppingName, price] of selectedToppings.entries()) {
            totalPrice += price * quantity;
        }
        totalPriceElement.textContent = `${totalPrice}đ`;
    }

    sizeButtons.forEach(button => {
    button.addEventListener('click', () => {
        const size = button.getAttribute('data-size');

        const currentSizeButton = document.querySelector(`button[data-size="${currentSize}"]`);
        currentSizeButton.classList.remove('bg-yellow-500', 'text-white');
        currentSizeButton.classList.add('bg-gray-300', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-white');

        button.classList.remove('bg-gray-300', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-white');
        button.classList.add('bg-yellow-500', 'text-white');

        currentSize = size;
        updateTotalPrice();
    });
});

document.querySelector('button[data-size="small"]').click();

    function toggleTopping(button) {
        const toppingName = button.textContent.trim();
        const price = parseInt(button.getAttribute('data-price'));

        if (selectedToppings.has(toppingName)) {
            selectedToppings.delete(toppingName);
            button.classList.remove('bg-yellow-500', 'text-white');
            button.classList.add('topping-button');
        } else {
            selectedToppings.set(toppingName, price);
            button.classList.remove('topping-button');
            button.classList.add('bg-yellow-500', 'text-white');
        }

        updateTotalPrice();
    }

    toppingButtons.forEach(button => {
        button.addEventListener('click', () => {
            toggleTopping(button);
        });
    });



    document.getElementById('decrementBtn').addEventListener('click', function () {
        let currentValue = parseInt(quantityInput.value, 10);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotalPrice(); 
        }
    });

    document.getElementById('incrementBtn').addEventListener('click', function () {
        let currentValue = parseInt(quantityInput.value, 10);
        quantityInput.value = currentValue + 1;
        updateTotalPrice(); 
    });

    window.addEventListener('DOMContentLoaded', function() {
    const addToCartButton = document.querySelector('.addToCart');
    addToCartButton.addEventListener('click', function() {
        let product_name = "<?php echo $product['name']; ?>";
        let product_image = "<?php echo $productImage; ?>";
        let product_size = currentSize;
        let product_toppings = [];
        for (let [key, value] of selectedToppings) {
            product_toppings.push(key);
        }
        let product_totalPrice = totalPrice;
        let product_quantity = quantityInput.value;
        let product_info = {
            name: product_name,
            image: product_image,
            size: product_size,
            toppings: product_toppings,
            totalPrice: product_totalPrice,
            quantity: product_quantity
        };

        // Tìm vị trí trống tiếp theo trong localStorage
        let index = 0;
        while (localStorage.getItem(`product${index}`) !== null) {
            index++;
        }

        let objectString = JSON.stringify(product_info);
        localStorage.setItem(`product${index}`, objectString);
        updateCartCount();
    });

    // Lấy tất cả các khóa (keys) trong localStorage
    var localStorageKeys = Object.keys(localStorage);

    // Tạo một mảng để lưu các sản phẩm
    var products = [];

    // Lặp qua các khóa và lấy dữ liệu từ localStorage
    localStorageKeys.forEach(function(key) {
        var productData = localStorage.getItem(key);
        var product = JSON.parse(productData);
        products.push(product);
    });

    // Cập nhật số sản phẩm trong giỏ hàng
    function updateCartCount() {
        let localStorageLength = localStorage.length;
        let cart_count = document.querySelector('.cart-count');
        if (cart_count) {
            cart_count.innerHTML = localStorageLength;
        }
    }
    updateCartCount();
});


    // Lấy thông tin người dùng và sản phẩm
    const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
    const productId = <?php echo $productId; ?>;

    // Xử lý sự kiện gửi bình luận
    const commentForm = document.getElementById('comment-form');
    const commentContent = document.getElementById('comment-content');

    commentForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn gửi form theo cách thông thường

        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!isLoggedIn) {
            alert('Bạn cần đăng nhập để có thể gửi bình luận.');
            return;
        }

        const content = commentContent.value.trim();

        // Kiểm tra nội dung bình luận
        if (content === '') {
            alert('Vui lòng nhập nội dung bình luận.');
            return;
        }

        // Gửi yêu cầu AJAX đến add_comment.php
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_comment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    commentContent.value = ''; // Xóa nội dung bình luận
                    alert(response.message); // Hiển thị thông báo thành công
                    window.location.reload(); // Tải lại trang
                } else {
                    alert(response.message); // Hiển thị thông báo lỗi
                }
            }
        };
        xhr.send('product_id=' + productId + '&content=' + encodeURIComponent(content));
    });
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
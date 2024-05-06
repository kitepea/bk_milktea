<?php
require_once '../../includes/config.php';

session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

if ($isLoggedIn) {
// Lấy thông tin người dùng từ session
$userId = $_SESSION['user_id'];
$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$address = $_SESSION['address'];
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

    <link rel="stylesheet" href="cart.css">
</head>

<body>
<div class="wrapper">

    <?php
    include '../../includes/header.php'
    ?>

    <div class="container mx-auto py-8">
        
    </div>
    <div class="container mx-auto py-8">
        
    </div>

    <section class="cart-content">
        <p>Giỏ hàng</p>
        <div class="content">
            <div class="cart-items">
                <div class="item item-title">
                    <span>Thông tin sản phẩm</span>
                    <span>Số lượng</span>
                    <span>Thành tiền</span>
                </div>
                <div class="items">
                </div>
                <div class="no-items" style="display: none;">Không có đơn hàng nào trong giỏ</div>
            </div>
            <div class="cart-submit">
            <?php if ($isLoggedIn): ?>
                <div class="deliveryAddress">
                    <p>Thông tin nhận hàng</p>
                    <div>
                        <p>Người nhận: <?php echo $name; ?></p>
                        <p>SĐT: <?php echo $phone; ?></p>
                    </div>
                    <p class="address">Địa chỉ: <?php echo $address; ?></p>
                </div>
                <?php endif; ?>
                <div class="money">
                    <div class="estimate">
                        <p>Tạm tính</p>
                        <p class="estimate_price"></p>
                    </div>
                    <div class="final">
                        <p>Tổng tiền</p>
                        <p class="final_price"></p>
                    </div>
                </div>
                    <a href="confirmCart.php"><button type="submit" class="buy-btn">Xác Nhận</button></a>
  


            </div>
        </div>
    </section>
    <div class="push"></div>
</div>
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

    window.onload = function() {
        let localStorageLength = localStorage.length;
        let noItemsDiv = document.querySelector('.no-items');

        if (localStorageLength === 0) {
            noItemsDiv.style.display = 'block';
        } else {
            noItemsDiv.style.display = 'none';
            // displayProduct();
        }
    };

        function displayProduct() {
        let items = document.querySelector('.items');
        let localStorageLength = localStorage.length;
        let products = [];
        let basePrice = [];

        while (items.firstChild) {
        items.removeChild(items.firstChild);
    }

        for (let i = 0; i < localStorageLength; i++) {
            products.push(JSON.parse(localStorage.getItem(`product${i}`)));
            basePrice.push(products[i]["totalPrice"] / products[i]["quantity"]);
        }

        for (let i = 0; i < localStorageLength; i++) {
            let toppings = "";
            for (let j = 0; j < products[i]["toppings"].length; j++) {
                toppings += products[i]["toppings"][j];
                if (j != products[i]["toppings"].length - 1) {
                    toppings += ", ";
                }
            }

            if (products[i]["size"] == "small") {
                products[i]["size"] = "Nhỏ";
            } else if (products[i]["size"] == "medium") {
                products[i]["size"] = "Vừa";
            } else {
                products[i]["size"] = "Lớn";
            }

            let item = document.createElement('div');
            item.classList.add('item');
            item.innerHTML = `
                <div class="item-info">
                    <div class="item-img">
                        <img src="${products[i]["image"]}" alt="Product image"
                            class="product_image">
                    </div>
                    <div class="item-details">
                        <span class="product_name" title="Thông tin sản phẩm">${products[i]["name"]}</span>
                        <span>Size: <span class="product_size">${products[i]["size"]}</span></span>
                        <span>Topping: <span class="product_toppings">${toppings}</span></span>
                    </div>
                </div>
                <div class="quantity">
                    <input title="Số lượng" type="number" min="1" name="item-quantity" class="product_quantity"
                        value="${products[i]["quantity"]}">
                </div>
                <div class="product_totalPrice" data-basePrice="${basePrice[i]}" data-price="${products[i]["totalPrice"]}">${products[i]["totalPrice"]} VNĐ</div>
                <button class="remove-btn" data-index="${i}">
                    <i class="fa-solid fa-trash"></i> Xóa
                </button>
            `;
            items.appendChild(item);
        }


    }
    displayProduct();

    // Tổng tiền phải trả
    function updateFinalPrice() {
        let totalPrices = document.querySelectorAll('.product_totalPrice');
        let finalPrice = 0;
        for (let i = 0; i < totalPrices.length; i++) {
            finalPrice += +(totalPrices[i].getAttribute('data-price'));
        }
        let estimate_price = document.querySelector('.estimate_price');
        let final_price = document.querySelector('.final_price');
        estimate_price.innerHTML = finalPrice + " VNĐ";
        final_price.innerHTML = finalPrice + " VNĐ";
    }
    updateFinalPrice();

    // Cập nhật số lượng sản phẩm từng loại
    function updateQuantity() {
        let product_quantity = document.querySelectorAll('.product_quantity');
        let totalPrices = document.querySelectorAll('.product_totalPrice');
        let items = document.querySelectorAll('.item');
        for (let i = 0; i < product_quantity.length; i++) {
            product_quantity[i].addEventListener('change', function(event) {
                let newValue = event.target.value;
                if (newValue == 0) {
                    items[i].remove();
                    localStorage.removeItem(`product${i}`);
                    updateCartCount();
                    updateFinalPrice();
                } else {
                    let basePrice = +(totalPrices[i].getAttribute('data-basePrice'));
                    let newPrice = parseInt(product_quantity[i].value) * basePrice;
                    totalPrices[i].setAttribute('data-price', newPrice);
                    totalPrices[i].innerHTML = newPrice + " VNĐ";
                    updateFinalPrice();
                }
            });
        }
    }
    updateQuantity();

    // Xóa sản phẩm khỏi giỏ hàng
    let removeBtns = document.querySelectorAll('.remove-btn');
    removeBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            let index = btn.getAttribute('data-index');
            localStorage.removeItem(`product${index}`);
            btn.parentNode.remove();
            updateCartCount();
            updateFinalPrice();
        });
    });

    function updateCartCount() {
        let localStorageLength = localStorage.length;
        let cart_count = document.querySelector('.cart-count');
        cart_count.innerHTML = localStorageLength;
    }
    updateCartCount();
    
    </script>
</body>

</html>
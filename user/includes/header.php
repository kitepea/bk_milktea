<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
    <a class="navbar-brand" href="homePage.php">
        <img src="../../templates/img/logo.png" alt="" class="navigation__logo h-20">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../homePage/homePage.php">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Giới thiệu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listProduct.php">Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Cửa hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Liên hệ</a>
            </li>
            <li class="nav-item">
                <div class="cart-container">
                    <a href="../cartDetails/cart.php" class="cart-link">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
        <a class="navbar-brand" href="homePage.php">
            <img src="/user/templates/img/logo.png" alt="" class="navigation__logo h-20">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../homePage/homePage.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listProduct.php">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cửa hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Liên hệ</a>
                </li>
                <li class="nav-item">
                    <div class="cart-container">
                        <a href="../cartDetails/cart.php" class="cart-link">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            <?php if ($isLoggedIn): ?>
                <div class="relative inline-block">
                    <button onclick="toggleMenu()" class="flex items-center focus:outline-none text-gray-700 hover:text-gray-900 font-semibold rounded-lg px-4 py-2">
                        <span><?php echo $username; ?></span>
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 hidden">
                        <a href="../personalInfo/personalInfo.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Thông tin tài khoản</a>
                        <a href="../modules/cartDetails/cart.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Đơn mua</a>
                        <a href="../Login/logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Đăng xuất</a>
                    </div>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
        <?php if ($isLoggedIn) : ?>
            <div class="relative inline-block">
                <button onclick="toggleMenu()" class="flex items-center focus:outline-none text-gray-700 hover:text-gray-900 font-semibold rounded-lg px-4 py-2">
                    <span><?php echo $username; ?></span>
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 hidden">
                    <a href="../personalInfo/personalInfo.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Thông tin tài khoản</a>
                    <a href="../modules/cartDetails/cart.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Đơn mua</a>
                    <a href="../Login/logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Đăng xuất</a>
                </div>
            </div>
        <?php else : ?>
            <div class="navigation__login" style="margin-left: 30px; margin-right: 100px;">
                <a class="btn btn-outline-secondary" href="../Login/Login.php" role="button">Đăng nhập</a>
                <a class="btn btn-outline-secondary" href="../Login/Register.php" role="button">Đăng ký</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<script>
    function toggleMenu() {
    var menu = document.getElementById('menu');
    var menuStyle = window.getComputedStyle(menu);
    var isMenuVisible = menuStyle.display !== 'none';

    if (isMenuVisible) {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
}

    // Cập nhật số sản phẩm trong giỏ hàng
    function updateCartCount() {
        let localStorageLength = localStorage.length;
        let cart_count = document.querySelector('.cart-count');
        if (cart_count) {
            cart_count.innerHTML = localStorageLength;
        }
    }
    updateCartCount();


   // Lấy phần tử nút toggle
    var navbarToggler = document.querySelector('.navbar-toggler');

    // Lấy phần tử menu collapse
    var navbarCollapse = document.querySelector('#navbarNav');

    // Khởi tạo đối tượng Collapse của Bootstrap
    var bsCollapse = new bootstrap.Collapse(navbarCollapse, {
        toggle: false // Đặt thành false để không tự động toggle khi khởi tạo
    });

    // Lắng nghe sự kiện click trên nút toggle
    navbarToggler.addEventListener('click', function() {
        // Toggle hiển thị/ẩn menu
        bsCollapse.toggle();
    });

    // Lấy phần tử body
var body = document.querySelector('body');

// Lắng nghe sự kiện click trên phần tử body
body.addEventListener('click', function(event) {
    // Kiểm tra nếu đích click không phải là nút toggle hoặc không nằm trong menu collapse
    if (!navbarToggler.contains(event.target) && !navbarCollapse.contains(event.target)) {
        // Nếu menu đang mở, đóng nó
        if (navbarCollapse.classList.contains('show')) {
            bsCollapse.hide();
        }
    }
});
</script>

<style>
    @media (max-width: 767px) {
        .navbar-nav {
            flex-direction: column;
            align-items: stretch;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            padding: 10px 15px;
            border-radius: 5px;
        }

        .form-inline {
            margin-top: 15px;
        }

        .navigation__login {
            margin-top: 15px;
            display: flex;
            justify-content: center;
        }
    }
</style>
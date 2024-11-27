<?php
require_once('../../model/config.php');
require_once('../../model/product.php');
require_once('../../model/cart.php');

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize cart if it's not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the user is logged in
$user = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') : null;

if ($user) {
    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Fetch cart data from the database if necessary
    $cart_query = "SELECT c.cart_id, ci.cart_item_id, ci.product_id, ci.quantity, p.name_product, p.price
                   FROM Cart c
                   JOIN Cart_Item ci ON c.cart_id = ci.cart_id
                   JOIN Product p ON ci.product_id = p.product_id
                   WHERE c.user_id = ?";
    
    $stmt = $conn->prepare($cart_query);
    $stmt->bind_param("i", $user_id); // 'i' for integer
    $stmt->execute();

    $result = $stmt->get_result();
    $cart_items = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();
} else {
    $cart_items = $_SESSION['cart']; // If not logged in, use session cart data
}

// Count the number of items in the cart
$giohang_count = count($cart_items);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cart.css">
    <style>
      .l1 {
    position: relative;
    display: inline-block;
}

/* Initially hide the login/sign-up menu */
.l1 ul {
    display: none;
    position: absolute;
    top: 100%; /* Place the menu directly below the icon */
    left: 50%;  /* Position it at the center */
    transform: translateX(-50%); /* Offset to ensure it's truly centered */
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Deeper shadow for better visibility */
    list-style: none;
    margin: 0;
    z-index: 100; /* Ensure the dropdown appears above other elements */
    width: 180px; /* Fixed width for consistent dropdown */
    opacity: 0; /* Hide the dropdown initially */
    visibility: hidden; /* Keep the dropdown invisible */
    transition: opacity 0.3s ease, visibility 0s 0.3s; /* Smooth fade-in/fade-out effect */
}

/* Show the menu when hovering over the .l1 container */
.l1:hover ul {
    display: block;
    opacity: 1;
    visibility: visible; /* Make it visible with a smooth transition */
    transition: opacity 0.3s ease, visibility 0s 0s; /* Instant visibility change when hovering */
}

/* Style the items inside the dropdown menu */
.l1 ul li {
    padding: 8px 15px;
    font-size: 16px;
    color: #333;
    transition: background-color 0.3s; /* Smooth background change on hover */
}

/* Style for the links inside the dropdown */
.l1 ul li a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    display: block;
}

/* Hover effect for the links */
.l1 ul li a:hover {
    color: #00693e;  /* Green color on hover */
}

/* Change background color of menu items when hovering */
.l1 ul li:hover {
    background-color: #f0f0f0;  /* Light grey background on hover */
}

/* Style the profile icon */
.l1 .icon {
    width: 30px; /* Adjust size of the profile icon */
    height: 30px;
    cursor: pointer;
    transition: transform 0.3s ease; /* Smooth scale-up effect on hover */
}

/* Add hover effect to profile icon */
.l1 .icon:hover {
    transform: scale(1.1); /* Slightly increase the size of the icon when hovered */
}

    
    </style>
</head>
<body>
     <!--Header-->
     <header class="header">
    <div class="header-left">
        <img src="../../img/logo đen.png" height="50%" alt="Logo" class="logo">
        <input type="text" placeholder="Bạn muốn mua gì..." class="search-bar">
    </div>
    
    <div class="header-right">
        <div class="icons">
            <!-- <a href="./control/index.php?chucnang=cart"> -->
            <span class="cart-count">🛒 <?php echo $giohang_count; ?></span>
            </a>
        </div>
        <div class="user-greeting">
            <?php if ($user): ?>
                <b style="position:relative; vertical-align: middle; font-weight:400; margin-top: 40px;">Xin chào - <?php echo $user; ?></b>
            <?php endif; ?>
        </div>
        
        <div class="l1">
            <i class="icons">
            <img src="../../img/profile.png" alt="Profile Icon" class="icon">

                <ul>
                    <?php if (isset($_SESSION['username'])) { ?>
                        <li><a href="../control/index.php?chucnang=view">Giỏ hàng</a></li>
                        <li><a href="hoadon.php">Hóa đơn</a></li>
                        <li><a href="../control/index.php?chucnang=logout">Đăng xuất</a></li>
                    <?php } else { ?>
                        <li><a href="../control/index.php?chucnang=login">Đăng nhập</a></li>
                        <li><a href="../control/index.php?chucnang=dangki">Đăng ký</a></li>
                    <?php } ?>
                </ul>
            </i>
        </div>
        
    </div>
</header>
    <nav class="navbar">
        <ul class="nav-list">
            <li><a href="#">Trang Chủ</a></li>
            <li class="dropdown">
                <a href="/Menu/Menu.html" class="nav-link">Menu</a>
                <div class="dropdown-content">
                    <div class="submenu">
                        <h4>THỨC UỐNG</h4>
                        <ul>
                            <li>Bst mới "teararmisu"</li>
                            <li>Best seller</li>
                            <li>Trà trái cây</li>
                            <li>Trà sữa</li>
                            <li>Kem silky</li>
                            <li>Cà phê</li>
                            <li>Đá xay</li>
                            <li>Bst kim cúc mộc tê</li>
                        </ul>
                    </div>
                    <div class="submenu">
                        <h4>BÁNH</h4>
                        <ul>
                            <li>Bánh lạnh</li>
                            <li>Bánh cookies - croissant</li>
                            <li>Bánh mì</li>
                        </ul>
                        <h4>BST LY GẤU GIÁNG SINH</h4>
                        <ul>
                            <li>Combo ly gấu và nước 169k</li>
                            <li>Ly gấu 149k</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link">Sản Phẩm Đóng Gói</a>
                <div class="dropdown-content">
                    <div class="submenu">
                        <h4>TRÀ</h4>
                        <ul>
                            <li>Trà hộp giấy</li>
                            <li>Trà gói cao</li>
                            <li>Trà túi lọc</li>
                            <li>Trà trà tam giác</li>
                            <li>Trà lài</li>
                            <li>Trà xanh </li>
                        </ul>
                    </div>
                    <div class="submenu">
                        <h4>CÀ PHÊ</h4>
                        <ul>
                            <li>Cà phê hạt không bơ</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link">Về chúng tôi</a>
                <div class="dropdown-content">
                    <div class="submenu">
                        <ul>
                            <li>Giới thiệu về công ty</li>
                            <li>Thư viện hình ảnh</li>
                            <li>Liên hệ</li>
                        </ul>

            <li><a href="#">Khuyến Mãi</a></li>
            <li><a href="#">Hỗ Trợ</a></li>
        </ul>
    </nav>

    <!-- Giỏ hàng -->
    <div class="cart-container">
        <div class="cart-items">
            <h2>Giỏ hàng của tôi</h2>
            <?php if (!empty($cart_items)): ?>
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                    <?php 
                    $total = 0;
                    foreach ($cart_items as $item): 
                        $item_total = $item['quantity'] * $item['price'];
                        $total += $item_total;
                    ?>
                   <tr>
                      <td><?php echo htmlspecialchars($item['name_product'], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td><?php echo $item['quantity']; ?></td>
                      <td><?php echo number_format($item['price'], 3, ',', '.') . "đ"; ?></td> <!-- Chỉnh lại số chữ số -->
                      <td><?php echo number_format($item_total, 3, ',', '.') . "đ"; ?></td> <!-- Chỉnh lại số chữ số -->
                  </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>Giỏ hàng của bạn hiện tại trống.</p>
            <?php endif; ?>
        </div>
        
        <div class="cart-summary">
            <h3><span id="total-items"><?php echo $giohang_count; ?></span> Món</h3>
            <div class="summary-details">
                <p>Tổng đơn hàng: <span id="subtotal"><?php echo number_format($total, 0, ',', '.') . "đ"; ?></span></p>
                <p>Phí giao hàng: <span id="shipping">10.000đ</span></p>
                <p>Tổng thanh toán: <span id="total" class="highlight"><?php echo number_format($total + 10000, 0, ',', '.') . "đ"; ?></span></p>
            </div>
            <button id="checkout-btn" onclick="window.location.href='checkout.php'">Thanh toán</button>
        </div>
    </div>

<!-- Footter -->
<footer style="background-color: #007a2a; color: white; padding: 20px; font-size: 15px; line-height: 1.6;">
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
      <!-- Phần địa chỉ -->
      <div style="flex: 1 1 300px; min-width: 300px;">
        <h4 style="font-size: 17px; margin-bottom: 10px;">ĐỊA CHỈ</h4>
        <p style="margin-bottom: 10px;">
          Trụ sở chính: Công ty Cổ Phần Phúc Long Heritage - ĐKKD: 0316 871719 do sở KHĐT TPHCM cấp lần đầu ngày 21/05/2021<br>
          Nhà máy: D_8D_CN Đường XE 1, Khu Công Nghiệp Mỹ Phước III, phường Mỹ Phước, thị xã Bến Cát, tỉnh Bình Dương, Việt Nam.<br>
          Địa chỉ: Phòng 702, Tầng 7, Tòa nhà Central Plaza, số 17 Lê Duẩn, phường Bến Nghé, quận 1, Hồ Chí Minh.
        </p>
        <p style="margin-bottom: 10px;">
          Hotline Đặt hàng: <b>1800 6779</b><br>
          Hotline Công ty: <b>1900 2345 18</b> (Bấm phím 0: Lễ Tân | phím 1: CSKH)<br>
          Email: <a href="mailto:sales@phuclong.masangroup.com" style="color: white;">sales@phuclong.masangroup.com</a>, <a href="mailto:info2@phuclong.masangroup.com" style="color: white;">info2@phuclong.masangroup.com</a>
        </p>
      </div>
  
      <!-- Các danh mục -->
      <div style="flex: 2 1 600px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
        <!-- Cột 1 -->
        <div>
          <h4 style="font-size: 17px; margin-bottom: 8px;">CÔNG TY</h4>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 8px;"><a href="/gioi-thieu" style="color: white; text-decoration: none;">Giới thiệu công ty</a></li>
            <li style="margin-bottom: 8px;"><a href="/thu-vien-hinh-anh" style="color: white; text-decoration: none;">Thư viện hình ảnh</a></li>
            <li style="margin-bottom: 8px;"><a href="/lien-he" style="color: white; text-decoration: none;">Liên hệ</a></li>
          </ul>
        </div>
  
        <div>
          <h4 style="font-size: 17px; margin-bottom: 8px;">TUYỂN DỤNG</h4>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 8px;"><a href="/tuyen-dung/htch" style="color: white; text-decoration: none;">HTCH</a></li>
            <li style="margin-bottom: 8px;"><a href="/tuyen-dung/kiosk" style="color: white; text-decoration: none;">Kiosk</a></li>
            <li style="margin-bottom: 8px;"><a href="/tuyen-dung/van-phong" style="color: white; text-decoration: none;">Văn phòng</a></li>
            <li style="margin-bottom: 8px;"><a href="/tuyen-dung/nha-may" style="color: white; text-decoration: none;">Nhà máy</a></li>
          </ul>
        </div>
  
        <div>
          <h4 style="font-size: 17px; margin-bottom: 8px;">KHUYẾN MÃI</h4>
          <ul style="list-style: none; padding: 0; margin: 0;">
<li style="margin-bottom: 8px;"><a href="/khuyen-mai" style="color: white; text-decoration: none;">Tin khuyến mãi</a></li>
          </ul>
        </div>
  
        <!-- Cột 2 -->
        <div>
          <h4 style="font-size: 17px; margin-bottom: 8px;">CỬA HÀNG</h4>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 8px;"><a href="/cua-hang" style="color: white; text-decoration: none;">Danh sách cửa hàng</a></li>
          </ul>
        </div>
  
        <div>
          <h4 style="font-size: 17px; margin-bottom: 8px;">HỘI VIÊN</h4>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 8px;"><a href="/hoi-vien/faq" style="color: white; text-decoration: none;">Câu hỏi thường gặp (FAQ)</a></li>
            <li style="margin-bottom: 8px;"><a href="/hoi-vien/dieu-khoan-chuong-trinh" style="color: white; text-decoration: none;">Điều khoản và điều kiện chương trình hội viên</a></li>
            <li style="margin-bottom: 8px;"><a href="/hoi-vien/dieu-khoan-the-tra-truoc" style="color: white; text-decoration: none;">Điều khoản & Điều kiện Thẻ trả trước</a></li>
          </ul>
        </div>
  
        <div>
          <h4 style="font-size: 17px; margin-bottom: 8px;">ĐIỀU KHOẢN SỬ DỤNG</h4>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 8px;"><a href="/dieu-khoan/chinh-sach-bao-mat" style="color: white; text-decoration: none;">Chính sách bảo mật thông tin</a></li>
            <li style="margin-bottom: 8px;"><a href="/dieu-khoan/chinh-sach-dat-hang" style="color: white; text-decoration: none;">Chính sách đặt hàng</a></li>
          </ul>
        </div>
      </div>
    </div>
  
   <!-- Phần cuối -->
<div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; font-size: 16px;">
    <p>© Công ty CP Phúc Long Heritage 2024</p>
    <div>
      <img src="http://online.gov.vn/Content/EndUser/LogoCCDVSaleNoti/logoSaleNoti.png" alt="Đã thông báo Bộ Công Thương" style="height: 40px; margin-right: 15px;">
      <a href="#"><img src="/img/IG.jpg" alt="Instagram" style="height: 30px;"></a>
      <a href="#"><img src="/img/Face.jpg" alt="Facebook" style="height: 30px; margin: 0 15px;"></a>
      <a href="#"><img src="/img/youtube.jpg" alt="YouTube" style="height: 30px;"></a>
    </div>
  </div>
  </footer>


    <script src="cart.js"></script>   
</body>
</html>
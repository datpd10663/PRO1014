
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
     <!--Header-->
     <header class="header">
        <div class="header-left">
            <img src="/img/Logo.jpg" alt="Logo" class="logo">
            <input type="text" placeholder="Bạn muốn mua gì..." class="search-bar">
        </div>
        <div class="header-right">
            <div class="delivery-option">
                <img src="https://phuclong.com.vn/_next/static/images/delivery-686d7142750173aa8bc5f1d11ea195e4.png" alt="Delivery Icon" class="delivery-icon">
                <span>Chọn Phương Thức Nhận Hàng</span>
            </div>
            <a href="#"><img src="../../img/Mail.jpg" alt="Mail Icon" class="icon"></a>
                <a href="#"><img src="../../img/Profile.jpg" alt="Profile Icon" class="icon"></a>
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
            <h2>GIỎ HÀNG CỦA TÔI</h2>
            <!-- Giỏ hàng sẽ được render bằng JavaScript -->
        </div>
    
        <div class="cart-summary">
            <h3><span id="total-items">0</span> MÓN</h3>
            <div class="summary-details">
                <p>Tổng đơn hàng: <span id="subtotal">0đ</span></p>
                <p>Phí giao hàng: <span id="shipping">10.000đ</span></p>
                <p>Tổng thanh toán: <span id="total" class="highlight">10.000đ</span></p>
            </div>
            <button id="checkout-btn">Thanh Toán <span id="final-total">10.000đ</span></button>
        </div>
    </div>
    
    <!-- Gợi ý sản phẩm -->
    <div class="combo-section">
        <h3>Sẽ ngon hơn khi thưởng thức cùng bạn bè...</h3>
        <div class="combo-items">
            <div class="combo-item" data-name="Trà Sữa Ô Long" data-price="48000">
                <img src="https://hcm.fstorage.vn/images/2022/dmcap081-dmcap083-phin-den-da_d852660d-1e23-46bd-a1af-117247dc77f0-og.png" alt="Trà Sữa Ô Long">
                <p>Trà Sữa Ô Long</p>
                <p>48.000đ</p>
            </div>
            <div class="combo-item" data-name="Trà Sữa Matcha" data-price="52000">
                <img src="https://hcm.fstorage.vn/images/2022/dmcap093-dmcap094-cappuccino-vietnamo_55905766-ff9f-435b-aa3b-e14018c188a3-og.png" alt="Trà Sữa Matcha">
                <p>Trà Sữa Matcha</p>
                <p>52.000đ</p>
            </div>
            <div class="combo-item" data-name="Trà Đào" data-price="35000">
                <img src="https://hcm.fstorage.vn/images/2022/dmcap082-dmcap084-phin-sua-da_3795a527-1b5b-4aaa-9d92-0d82385e4406-og.png" alt="Trà Đào">
                <p>Trà Đào</p>
                <p>35.000đ</p>
            </div>
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
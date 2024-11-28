    <?php
    // Start session and include necessary files
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('../model/config.php');
    require_once('../model/dangnhap.php');
    require_once('../model/product.php');
    require_once('../model/cart.php');
    include_once('../model/order.php');

    if (isset($_GET['chucnang'])) {
        $chucnang = $_GET['chucnang'];

        switch ($chucnang) {
            
            case 'login':
                include('../views/dangnhap/dangnhap.php');
                break;

                case 'xulylogin':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
                        $username = trim($_POST['username']);
                        $password = trim($_POST['password']);
                
                        // Chuỗi salt cố định (phải giống với salt trong phần đăng ký)
                        $salt = 'chuoi_bao_mat'; 
                        $hashed_password = hash('sha256', $salt . $password);
                
                        // Truy vấn cơ sở dữ liệu
                        $sql = "SELECT * FROM User WHERE username = ? AND password = ? LIMIT 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $username, $hashed_password);
                        $stmt->execute();
                        $result = $stmt->get_result();
                
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                
                            // Khởi động session
                            if (session_status() === PHP_SESSION_NONE) {
                                session_start();
                            }
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['role_id'] = $row['role_id'];
                
                            // Chuyển hướng dựa trên vai trò
                            switch ($row['role_id']) {
                                case 1:
                                    header("Location: ../admin/admin.php");
                                    break;
                                case 2:
                                    header("Location: nhanvien.php");
                                    break;
                                default:
                                    header("Location: ../index.php");
                            }
                            exit();
                        } else {
                            $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
                        }
                        $stmt->close();
                    }
                
                    include('../views/dangnhap/dangnhap.php');
                    break;
                
                
                
                    
                    case 'logout':
                        // Start the session
                        session_start();
                        // Unset all session variables
                        session_unset();
                        // Destroy the session
                        session_destroy();
                        // Redirect to homepage or login page
                        header("Location: ../index.php");
                        exit(); // Ensure the script stops after redirection
                        break;
                
            case 'dangki':
                include('../views/dangnhap/dangki.php');
                break;

                case 'xulydangki':
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
                        $username = trim($_POST['username']);
                        $email = trim($_POST['email']);
                        $password = trim($_POST['password']);
                        $phone_number = trim($_POST['phone_number']);
                        $address = trim($_POST['address']);
                
                        // Gọi hàm thêm mới tài khoản
                        if (themmoitk($username, $email, $password, $phone_number, $address)) {
                            echo "Đăng ký thành công!";
                            header("Location: index.php?chucnang=login");
                            exit();
                        } else {
                            echo "Lỗi: Không thể đăng ký!";
                        }
                    }
                    break;
                

                case 'themmoi':
                    // Show form to add new product
                    include('../admin/addproduct.php');
                    break;
        
                    case 'xulythemmoi':
                        if (isset($_POST['name_product']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['category_id'])) {
                            if (isset($_FILES['ava'])) {
                                $picture = $_FILES['ava'];
                                $path = __DIR__ . '/uploadFiles';
                                if (!is_dir($path))
                                    mkdir($path, 0777, true); // Create directory if not exists
                    
                                // Move uploaded file
                                if (move_uploaded_file($picture['tmp_name'], $path . '/' . $picture['name'])) {
                                    $duongdan = 'uploadFiles/' . $picture['name'];
                    
                                    // Check if category exists in the database
                                    $madm = $_POST['category_id'];
                                    $madm_check_query = "SELECT * FROM Category WHERE category_id = ?";
                                    $stmt = $conn->prepare($madm_check_query);
                                    $stmt->bind_param("s", $madm);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                    
                                    if ($result->num_rows > 0) {
                                        // Insert product into the database
                                        $sql = "INSERT INTO Product (name_product, description, price, address, category_id) VALUES (?, ?, ?, ?, ?)";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("ssiss", $_POST['name_product'], $_POST['description'], $_POST['price'], $duongdan, $_POST['category_id']);
                                        if ($stmt->execute()) {
                                            echo 'Thêm mới sản phẩm thành công!';
                                            header('Location: ../admin/admin.php');
                                        } else {
                                            echo 'Lỗi khi chèn dữ liệu: ' . $stmt->error;
                                        }
                                    } else {
                                        echo 'Lỗi: Mã danh mục không tồn tại.';
                                    }
                                } else {
                                    echo 'Upload file không thành công!';
                                }
                            }
                        }
                        break;     
                        case 'sua':
                            if (isset($_GET['ma'])) {
                                $product_id = $_GET['ma'];
                        
                                // Truy vấn lấy thông tin sản phẩm từ database
                                $sql = "SELECT * FROM Product WHERE product_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $product_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                        
                                if ($result->num_rows > 0) {
                                    $sanpham = $result->fetch_assoc();
                                } else {
                                    echo "Không tìm thấy sản phẩm.";
                                    exit;
                                }
                                $stmt->close();
                        
                                // Hiển thị form sửa (gọi file giao diện `updateproduct.php`)
                                include('../admin/updateproduct.php');
                            } else {
                                echo "Mã sản phẩm không hợp lệ.";
                                exit;
                            }
                            break;
                
                            case 'xulysua':
                                if (isset($_GET['ma'])) {
                                    $product_id = $_GET['ma'];
                                    
                                    // Truy vấn lấy thông tin sản phẩm
                                    $sql = "SELECT * FROM Product WHERE product_id = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $product_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                            
                                    if ($result->num_rows > 0) {
                                        $sanpham = $result->fetch_assoc();
                                    } else {
                                        echo "Không tìm thấy sản phẩm.";
                                        exit;
                                    }
                                    $stmt->close();
                            
                                    // Kiểm tra và xử lý dữ liệu từ form
                                    if (isset($_POST['name_product'], $_POST['description'], $_POST['price'])) {
                                        $name_product = $_POST['name_product'];
                                        $description = $_POST['description'];
                                        $price = $_POST['price'];
                            
                                        // Xử lý hình ảnh
                                        $address = $sanpham['address']; // Giữ hình ảnh hiện tại
                                        if (isset($_FILES['address']) && $_FILES['address']['error'] == 0) {
                                            $picture = $_FILES['address'];
                                            $filename = time() . '_' . basename($picture['name']);
                                            $upload_path = __DIR__ . '/../control/uploadFiles/' . $filename;
                            
                                            if (move_uploaded_file($picture['tmp_name'], $upload_path)) {
                                                $address = 'uploadFiles/' . $filename;
                                            } else {
                                                echo "Upload file không thành công!";
                                                exit;
                                            }
                                        }
                            
                                        // Cập nhật sản phẩm
                                        $sql_update = "UPDATE Product SET name_product = ?, description = ?, price = ?, address = ? WHERE product_id = ?";
                                        $stmt = $conn->prepare($sql_update);
                                        $stmt->bind_param("ssdsi", $name_product, $description, $price, $address, $product_id);
                                        if ($stmt->execute()) {
                                            header('Location: ../admin/admin.php');
                                            exit;
                                        } else {
                                            echo "Lỗi cập nhật: " . $stmt->error;
                                        }
                                        $stmt->close();
                                    } else {
                                        echo "Dữ liệu không hợp lệ.";
                                        exit;
                                    }
                                }
                                break; 
                                case 'xoa':
                                    if (isset($_GET['ma'])) {
                                        $product_id = $_GET['ma'];
                                
                                        // Truy vấn thông tin sản phẩm từ database
                                        $sql = "SELECT * FROM Product WHERE product_id = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $product_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                
                                        if ($result->num_rows > 0) {
                                            $sanpham = $result->fetch_assoc();
                                        } else {
                                            echo "Không tìm thấy sản phẩm cần xóa.";
                                            exit;
                                        }
                                        $stmt->close();
                                
                                        // Hiển thị giao diện xác nhận xóa
                                        include('../admin/delete.php');
                                    } else {
                                        echo "Mã sản phẩm không hợp lệ.";
                                        exit;
                                    }
                                    break;
                                case 'xulyxoa':
                                    if (isset($_POST['macanxoa'], $_POST['xacnhan'])) {
                                        if ($_POST['xacnhan'] == 'xoa') {
                                            xoa($_POST['macanxoa']);
                                            header('Location: ../admin/admin.php');
                                            exit;
                                        }
                                        if ($_POST['xacnhan'] == 'huy') {
                                            header('Location: ../admin/admin.php');
                                            exit;
                                        }
                                    }
                                    break;     
                                    case 'add':
                                        // Kiểm tra người dùng đã đăng nhập chưa
                                        if (!isset($_SESSION['user_id'])) {
                                            echo "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.";
                                            exit;
                                        }
                            
                                        $user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session
                            
                                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                            // Lấy thông tin từ form
                                            $product_id = $_POST['product_id'];
                                            $size = $_POST['size'];
                                            $sweetness = $_POST['sweetness'];
                                            $ice = $_POST['ice'];
                            
                                            // Bước 1: Kiểm tra hoặc tạo mới giỏ hàng
                                            $sql_cart = "SELECT cart_id FROM Cart WHERE user_id = ?";
                                            $stmt_cart = $conn->prepare($sql_cart);
                                            $stmt_cart->bind_param("i", $user_id);
                                            $stmt_cart->execute();
                                            $result_cart = $stmt_cart->get_result();
                            
                                            if ($result_cart->num_rows == 0) {
                                                // Nếu chưa có giỏ hàng, thêm mới
                                                $sql_insert_cart = "INSERT INTO Cart (user_id) VALUES (?)";
                                                $stmt_insert_cart = $conn->prepare($sql_insert_cart);
                                                $stmt_insert_cart->bind_param("i", $user_id);
                                                $stmt_insert_cart->execute();
                                                $cart_id = $conn->insert_id;
                                                $stmt_insert_cart->close();
                                            } else {
                                                // Nếu đã có giỏ hàng, lấy cart_id
                                                $row_cart = $result_cart->fetch_assoc();
                                                $cart_id = $row_cart['cart_id'];
                                            }
                                            $stmt_cart->close();
                            
                                            // Bước 2: Thêm chi tiết sản phẩm vào bảng ProductDetail
                                            $sql_detail = "INSERT INTO ProductDetail (product_id, size, sweetness_level, ice_level) 
                                                           VALUES (?, ?, ?, ?)";
                                            $stmt_detail = $conn->prepare($sql_detail);
                                            $stmt_detail->bind_param("isss", $product_id, $size, $sweetness, $ice);
                                            if ($stmt_detail->execute()) {
                                                $stmt_detail->close();
                            
                                                // Bước 3: Thêm sản phẩm vào chi tiết giỏ hàng
                                                $sql_check_item = "SELECT cart_item_id, quantity FROM Cart_Item 
                                                                   WHERE cart_id = ? AND product_id = ?";
                                                $stmt_check_item = $conn->prepare($sql_check_item);
                                                $stmt_check_item->bind_param("ii", $cart_id, $product_id);
                                                $stmt_check_item->execute();
                                                $result_check_item = $stmt_check_item->get_result();
                            
                                                if ($result_check_item->num_rows > 0) {
                                                    // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
                                                    $row_item = $result_check_item->fetch_assoc();
                                                    $new_quantity = $row_item['quantity'] + 1;
                            
                                                    $sql_update_item = "UPDATE Cart_Item SET quantity = ? WHERE cart_item_id = ?";
                                                    $stmt_update_item = $conn->prepare($sql_update_item);
                                                    $stmt_update_item->bind_param("ii", $new_quantity, $row_item['cart_item_id']);
                                                    $stmt_update_item->execute();
                                                    $stmt_update_item->close();
                                                } else {
                                                    // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
                                                    $quantity = 1; // Mặc định số lượng là 1
                                                    $sql_insert_item = "INSERT INTO Cart_Item (cart_id, product_id, quantity) 
                                                                        VALUES (?, ?, ?)";
                                                    $stmt_insert_item = $conn->prepare($sql_insert_item);
                                                    $stmt_insert_item->bind_param("iii", $cart_id, $product_id, $quantity);
                                                    $stmt_insert_item->execute();
                                                    $stmt_insert_item->close();
                                                }
                                                $stmt_check_item->close();
                            
                                                // Chuyển hướng sau khi thêm thành công
                                                header("Location: ../views/cart/cartview.php");
                                                exit;
                                            } else {
                                                echo "Có lỗi xảy ra khi thêm chi tiết sản phẩm.";
                                            }
                                        }
                                        break;
                            
                                        case 'view':
                                            if (isset($_SESSION['user_id'])) {
                                                $user_id = $_SESSION['user_id'];
                                                $cart = getCart($user_id);
                                                include('../views/cart/cartview.php');
                                            } else {
                                                echo "Vui lòng đăng nhập để xem giỏ hàng.";
                                            }
                                            break;
                                            
                                            case 'update':
                                                if (isset($_POST['cart_item_id']) && isset($_POST['quantity'])) {
                                                    // Lặp qua từng sản phẩm và cập nhật số lượng
                                                    foreach ($_POST['cart_item_id'] as $key => $cart_item_id) {
                                                        $quantity = $_POST['quantity'][$key];
                                                
                                                        // Thực hiện cập nhật số lượng sản phẩm trong giỏ hàng
                                                        $sql = "UPDATE cart_item SET quantity = ? WHERE cart_item_id = ?";
                                                
                                                        // Chuẩn bị câu lệnh SQL và liên kết các tham số
                                                        if ($stmt = $conn->prepare($sql)) {
                                                            $stmt->bind_param("ii", $quantity, $cart_item_id); // 'ii' là kiểu dữ liệu (integer, integer)
                                                            $stmt->execute(); // Thực thi câu lệnh
                                                            $stmt->close(); // Đóng câu lệnh chuẩn bị
                                                        } else {
                                                            echo "Lỗi khi chuẩn bị câu lệnh: " . $conn->error;
                                                        }
                                                    }
                                                
                                                    // Sau khi cập nhật xong, bạn có thể chuyển hướng lại giỏ hàng hoặc hiển thị thông báo
                                                    header("Location: ../views/cart/cartview.php"); // Đổi sang trang giỏ hàng của bạn
                                                    exit();
                                                } else {
                                                    echo "Dữ liệu không hợp lệ.";
                                                }
                                            
                                            case 'remove':
                                                if (isset($_GET['cart_item_id'])) {
                                                    $cart_item_id = $_GET['cart_item_id'];
                                                    if (removeItemFromCart($cart_item_id)) {
                                                        header("Location: ../views/cart/cartview.php");
                                                        exit();
                                                    } else {
                                                        echo "Lỗi khi xóa sản phẩm khỏi giỏ hàng.";
                                                    }
                                                }
                                                break;
                                                // case 'place_order':
                                                //     // Kiểm tra nếu giỏ hàng không trống
                                                //     if (isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items'])) {
                                                //         // Lấy tổng từ session
                                                //         $cart_total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
                                                    
                                                //         $_SESSION['cart_total'] = $cart_total;
                                                //     } else {
                                                //         echo "Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng.";
                                                //         exit();
                                                //     }
                                                
                                                //     // Lấy thông tin từ người dùng
                                                //     $user_id = $_SESSION['user_id'];
                                                //     $address = $_POST['address'];
                                                //     $total_amount = $_SESSION['cart_total']; // Lấy giá trị từ session
                                                //     $status = "Pending";
                                                
                                                //     // Gọi model để đặt hàng
                                                //     if (placeOrder($user_id, $address, $total_amount, $status)) {
                                                //         // Xóa giỏ hàng sau khi đặt hàng thành công
                                                //         unset($_SESSION['cart_items']);
                                                //         unset($_SESSION['cart_total']);
                                                
                                                //         // Chuyển hướng đến trang thành công
                                                //         header("Location: ../views/order/success.php");
                                                //         exit();
                                                //     } else {
                                                //         echo "Đã xảy ra lỗi khi đặt hàng.";
                                                //     }
                                                //     break;
                                            }   
                                     }

    
    ?>

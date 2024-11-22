    <?php
    // Start session and include necessary files
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('../model/config.php');
    require_once('../model/dangnhap.php');
    require_once('../model/product.php');

    if (isset($_GET['chucnang'])) {
        $chucnang = $_GET['chucnang'];

        switch ($chucnang) {
            
            case 'login':
                include('../views/dangnhap/dangnhap.php');
                break;

                case 'xulylogin':
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
                        $username = trim($_POST['username']);
                        $password = trim($_POST['password']);
                
                        $sql = "SELECT * FROM User WHERE username = ? AND password = ? limit 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $username, $password);
                        $stmt->execute();
                        $result = $stmt->get_result();
                
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['role_id'] = $row['role_id'];
                
                            if ($row['role_id'] == 1) {
                                header("Location: ../admin/admin.php");
                            } elseif ($row['role_id'] == 2) {
                                header("Location: nhanvien.php");
                            } else {
                                header("Location: ../index.php");
                            }
                            exit();
                        } else {
                            // Gán thông báo lỗi
                            $error = "Tài khoản hoặc mật khẩu không đúng!";
                        }
                        $stmt->close();
                    }
                
                    // Gọi giao diện login và truyền lỗi
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
                                            if (isset($_POST['product_id'], $_POST['quantity']) && isset($_SESSION['id'])) {
                                                $product_id = (int)$_POST['product_id'];
                                                $quantity = (int)$_POST['quantity'];
                                                $user_id = (int)$_SESSION['id'];
                                        
                                                if (addToCart($user_id, $product_id, $quantity)) {
                                                    header("Location: ../views/cart/cartview.php");
                                                    exit;
                                                } else {
                                                    echo "Lỗi khi thêm sản phẩm vào giỏ hàng.";
                                                }
                                            } else {
                                                echo "Dữ liệu không hợp lệ.";
                                            }
                                            break;
                                        
                                            
                                            case 'view':
                                                if (isset($_SESSION['id'])) {
                                                    $user_id = $_SESSION['id'];
                                                    $cart = getCart($user_id);
                                                    include('../views/cart/cartview.php');
                                                }
                                                break;
                                    
                                            case 'update':
                                                if (isset($_POST['cart_item_id'], $_POST['quantity'])) {
                                                    $cart_item_id = $_POST['cart_item_id'];
                                                    $quantity = $_POST['quantity'];
                                                    if (updateCartItem($cart_item_id, $quantity)) {
                                                        header("Location: ../views/cart/cartview.php");
                                                    } else {
                                                        echo "Lỗi khi cập nhật giỏ hàng.";
                                                    }
                                                }
                                                break;
                                    
                                            case 'remove':
                                                if (isset($_GET['cart_item_id'])) {
                                                    $cart_item_id = $_GET['cart_item_id'];
                                                    if (removeItemFromCart($cart_item_id)) {
                                                        header("Location: ../views/cart/cartview.php");
                                                    } else {
                                                        echo "Lỗi khi xóa sản phẩm khỏi giỏ hàng.";
                                                    }
                                                }
                                                break;
                                            }   
                                     }

    
    ?>

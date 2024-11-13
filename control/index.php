<?php
// Start session and include necessary files at the top
session_start();
require_once('./PRO1014/model/config.php'); // Include your database configuration
require_once('');
require_once('model/danhmuc.php');
require_once('model/dangnhap.php');

if (isset($_GET['chucnang'])) {
    $chucnang = $_GET['chucnang'];

    switch ($chucnang) {
        case 'hienthitc':
            $tatcasanpham = tatcasanpham();
            include('admin.php');
            break;

        case 'themmoitc':
            include('views/thucung/them.php');
            break;

        case 'xylythemmoitc':
            if (isset($_POST['masp'], $_POST['tensp'], $_POST['dongia'], $_POST['mota'], $_POST['madm'])) {
                if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
                    $picture = $_FILES['hinhanh'];
                    $path = __DIR__ . '/uploadFiles';
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $filename = basename($picture['name']);
                    $fullpath = $path . '/' . $filename;

                    if (move_uploaded_file($picture['tmp_name'], $fullpath)) {
                        $hinhanh = 'uploadFiles/' . $filename;
                        themmoi($_POST['masp'], $_POST['tensp'], $hinhanh, $_POST['dongia'], $_POST['mota'], $_POST['madm']);
                        header('Location: index.php?chucnang=hienthitc');
                        exit;
                    } else {
                        echo 'Upload file không thành công!';
                    }
                } else {
                    echo 'Vui lòng chọn file hình ảnh!';
                }
            } else {
                echo 'Vui lòng nhập đầy đủ thông tin!';
            }
            break;

        case 'suatc':
            if (isset($_GET['ma'])) {
                $ma_san_pham = $_GET['ma'];
                $sql = "SELECT * FROM sanpham WHERE masp = ?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("s", $ma_san_pham);
                $stmt->execute();
                $result = $stmt->get_result();
                $sanpham = $result->fetch_assoc();
                $stmt->close();
            }
            include('views/thucung/sua.php');
            break;

        case 'xulysuatc':
            if (isset($_GET['ma'])) {
                $ma_san_pham = $_GET['ma'];
                $sql = "SELECT * FROM sanpham WHERE masp = ?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("s", $ma_san_pham);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $sanpham = $result->fetch_assoc();
                } else {
                    echo "Không tìm thấy sản phẩm.";
                    exit;
                }
                $stmt->close();

                if (isset($_POST['masp'], $_POST['tensp'], $_POST['mota'], $_POST['dongia'])) {
                    $duongdan = $sanpham['hinhanh']; // Default image path

                    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
                        $picture = $_FILES['hinhanh'];
                        $filename = basename($picture['name']);
                        $fullpath = __DIR__ . '/uploadFiles/' . $filename;

                        if (move_uploaded_file($picture['tmp_name'], $fullpath)) {
                            $duongdan = 'uploadFiles/' . $filename;
                        } else {
                            echo 'Upload file không thành công!';
                            exit;
                        }
                    }

                    $sql_update = "UPDATE sanpham SET tensp = ?, mota = ?, dongia = ?, hinhanh = ? WHERE masp = ?";
                    $stmt = $connection->prepare($sql_update);
                    $stmt->bind_param("sssss", $_POST['tensp'], $_POST['mota'], $_POST['dongia'], $duongdan, $_POST['masp']);
                    if ($stmt->execute()) {
                        header('Location: index.php?chucnang=hienthitc');
                        exit;
                    } else {
                        echo "Lỗi cập nhật: " . $stmt->error;
                        exit;
                    }
                    $stmt->close();
                } else {
                    echo "Dữ liệu không hợp lệ.";
                    exit;
                }
            }
            break;

        case 'xoatc':
            include('views/thucung/xoa.php');
            break;

        case 'xulyxoatc':
            if (isset($_POST['macanxoa'], $_POST['xacnhan'])) {
                if ($_POST['xacnhan'] == 'xoa') {
                    xoa($_POST['macanxoa']);
                    header('Location: index.php?chucnang=hienthitc');
                    exit;
                }
                if ($_POST['xacnhan'] == 'huy') {
                    header('Location: index.php?chucnang=hienthitc');
                    exit;
                }
            }
            break;

        case 'hienthidm':
            $tatcadanhmuc = tatcadanhmuc();
            include('views/danhmuc/hienthidm.php');
            break;

        case 'themdm':
            include('views/danhmuc/themdm.php');
            break;

        case 'xulythemdm':
            if (isset($_POST['tendm'], $_POST['mota'])) {
                $tendm = $_POST['tendm'];
                $mota = $_POST['mota'];

                $sql = "INSERT INTO danhmuc (tendm, mota) VALUES (?, ?)";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ss", $tendm, $mota);
                if ($stmt->execute()) {
                    header('Location: index.php?chucnang=hienthidm');
                } else {
                    echo "Lỗi: " . $stmt->error;
                }
                $stmt->close();
            }
            break;

        case 'xoadm':
            include('views/danhmuc/xoadm.php');
            break;

        case 'xulyxoadm':
            if (isset($_POST['macanxoa'], $_POST['xacnhan'])) {
                if ($_POST['xacnhan'] == 'xoa') {
                    $sql = "DELETE FROM danhmuc WHERE madm = ?";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("s", $_POST['macanxoa']);
                    $stmt->execute();
                    header('Location: index.php?chucnang=hienthidm');
                    exit;
                }
                if ($_POST['xacnhan'] == 'huy') {
                    header('Location: index.php?chucnang=hienthidm');
                    exit;
                }
            }
            break;

        case 'suadm':
            if (isset($_GET['ma'])) {
                $ma_danhmuc = $_GET['ma'];
                $sql = "SELECT * FROM danhmuc WHERE madm = ?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("s", $ma_danhmuc);
                $stmt->execute();
                $result = $stmt->get_result();
                $danhmuc = $result->fetch_assoc();
                $stmt->close();
            }
            include('views/danhmuc/suadm.php');
            break;

        case 'xulysuadm':
            if (isset($_GET['ma'])) {
                $ma_danhmuc = $_GET['ma'];
                if (isset($_POST['tendm'], $_POST['mota'])) {
                    $sql = "UPDATE danhmuc SET tendm = ?, mota = ? WHERE madm = ?";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("sss", $_POST['tendm'], $_POST['mota'], $ma_danhmuc);
                    if ($stmt->execute()) {
                        header('Location: index.php?chucnang=hienthidm');
                    } else {
                        echo "Lỗi cập nhật: " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
            break;

        case 'login':
            include('views/dangnhap/login.php');
            break;

        case 'xulylogin':
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
                $tentk = $_POST['tentk'];
                $matkhau = $_POST['matkhau'];

                $sql = "SELECT * FROM taikhoan WHERE tentk = ? AND matkhau = ?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ss", $tentk, $matkhau);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION['matk'] = $row['matk'];
                    $_SESSION['tentk'] = $row['tentk'];
                    $_SESSION['vaitro'] = $row['vaitro'];

                    if ($row['vaitro'] == 'admin') {
                        header("Location: admin.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit();
                } else {
                    $error = "Tài khoản hoặc mật khẩu không đúng!";
                }
                $stmt->close();
            }
            include('views/dangnhap/login.php');
            break;

        case 'dangki':
            include('views/dangnhap/dangki.php');
            break;

        case 'xulydangki':
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
                $tentk = $_POST['tentk'];
                $email = $_POST['email'];
                $matkhau = $_POST['matkhau'];
                $vaitro = $_POST['vaitro'];

                $sql = "INSERT INTO taikhoan (tentk, email, matkhau, vaitro) VALUES (?, ?, ?, ?)";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ssss", $tentk, $email, $matkhau, $vaitro);
                if ($stmt->execute()) {
                    echo "Đăng ký thành công!";
                } else {
                    echo "Lỗi: " . $stmt->error;
                }
                $stmt->close();
            }
            break;
            case 'hoadon':
                include('hoadon.php');
                break;
            
            case 'logout':
                include('logout.php');
                break;

        default:
            include('views/trangchu.php');
            break;
    }
} else {
    include('views/trangchu.php');
}
?>

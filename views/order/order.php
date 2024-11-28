<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../control/index.php?chucnang=login");
    exit();
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #34495e;
        }
        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-container button:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Nhập địa chỉ giao hàng</h2>
        <form action="../../control/index.php?chucnang=place_order" method="post">
            <input type="text" name="address" placeholder="Nhập địa chỉ giao hàng" required>
            <button type="submit">Xác nhận đặt hàng</button>
        </form>
    </div>
</body>
</html>

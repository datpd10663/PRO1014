<?php
require_once('../../model/config.php');

// Kiểm tra trạng thái session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy danh sách hóa đơn từ cơ sở dữ liệu
$sql = "SELECT i.invoice_id, i.invoice_date, i.product_id, p.name_product, i.payment_status, 
               i.total_amount, i.due_date, i.payment_date, i.billing_address
        FROM Invoice i
        JOIN Product p ON i.product_id = p.product_id
        WHERE i.user_id = ?
        ORDER BY i.invoice_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$invoices = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn của tôi</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <h1>Hóa đơn của tôi</h1>
    
    <?php if (!empty($invoices)): ?>
        <table>
            <thead>
                <tr>
                    <th>Mã hóa đơn</th>
                    <th>Ngày lập</th>
                    <th>Sản phẩm</th>
                    <th>Trạng thái thanh toán</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đến hạn</th>
                    <th>Ngày thanh toán</th>
                    <th>Địa chỉ thanh toán</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td><?php echo $invoice['invoice_id']; ?></td>
                        <td><?php echo $invoice['invoice_date']; ?></td>
                        <td><?php echo htmlspecialchars($invoice['name_product']); ?></td>
                        <td><?php echo $invoice['payment_status']; ?></td>
                        <td><?php echo number_format($invoice['total_amount'], 2, ',', '.') . "đ"; ?></td>
                        <td><?php echo $invoice['due_date']; ?></td>
                        <td><?php echo $invoice['payment_date'] ? $invoice['payment_date'] : 'Chưa thanh toán'; ?></td>
                        <td><?php echo htmlspecialchars($invoice['billing_address']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Bạn chưa có hóa đơn nào.</p>
    <?php endif; ?>

    <button onclick="window.location.href='../index.php';">Quay lại trang chính</button>
</body>
</html>

<?
// Hàm để đặt hàng
function placeOrder($user_id, $address, $total_amount, $status) {
    require_once('config.php'); // Kết nối DB
    
    // Câu lệnh SQL để thêm đơn hàng vào DB
    $sql = "INSERT INTO orders (user_id, address, total_amount, status) VALUES (?, ?, ?, ?)";
    
    // Chuẩn bị câu truy vấn
    $stmt = $conn->prepare($sql);
    
    // Gán giá trị cho các tham số
    $stmt->bind_param("isss", $user_id, $address, $total_amount, $status);
    
    // Thực thi câu truy vấn và trả về kết quả
    return $stmt->execute();
    var_dump(function_exists('placeOrder'));
}

?>
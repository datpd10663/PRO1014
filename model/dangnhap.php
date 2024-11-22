<?php
require_once('config.php');

function tatcataikhoan()
{
    global $conn;
    $sql = "SELECT * FROM User limit 1";
    return mysqli_query($conn, $sql);
}

function themmoitk($username, $email, $password, $phone_number, $address)
{
    global $conn;
    
    // Default role is 3 (user)
    $role_id = 3; 

    $sql = "INSERT INTO User (role_id, username, email, password, phone_number, address) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $role_id, $username, $email, $password, $phone_number, $address);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function chinhsuatk($id, $username, $password, $phone_number, $address)
{
    global $conn;

    $sql = "UPDATE User 
            SET username = ?, password = ?, phone_number = ?, address = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $password, $phone_number, $address, $id);
    $stmt->execute();
}

function xoatk($id)
{
    global $conn;
    $sql = "DELETE FROM User WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
?>

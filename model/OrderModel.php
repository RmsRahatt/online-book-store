<?php
require_once '../config/db.php';

function getAllOrders($conn) {
    $sql = "SELECT orders.*, users.username FROM orders 
            JOIN users ON orders.user_id = users.id 
            ORDER BY order_date DESC";
    return mysqli_query($conn, $sql);
}

function updateOrderStatus($conn, $order_id, $status) {
    $sql = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
    return mysqli_query($conn, $sql);
}
?>
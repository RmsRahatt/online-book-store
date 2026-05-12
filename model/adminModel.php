<?php
require_once(__DIR__ . '/../config/db.php');

// ==================== BOOK FUNCTIONS ====================

function getAllBooks(){
    $con = getConnection();
    $sql = "SELECT books.*, categories.name as category_name 
            FROM books, categories 
            WHERE books.category_id = categories.id 
            ORDER BY books.id DESC";
    $result = mysqli_query($con, $sql);
    $books = [];
    while($row = mysqli_fetch_assoc($result)){
        $books[] = $row;
    }
    return $books;
}

function getBookById($id){
    $con = getConnection();
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function addBook($title, $author, $desc, $price, $category_id, $image_path, $stock){
    $con = getConnection();
    $sql = "INSERT INTO books (title, author, description, price, category_id, image_path, stock) 
            VALUES ('$title', '$author', '$desc', $price, $category_id, '$image_path', $stock)";
    return mysqli_query($con, $sql);
}

function updateBook($id, $title, $author, $desc, $price, $category_id, $image_path, $stock){
    $con = getConnection();
    $sql = "UPDATE books SET title='$title', author='$author', description='$desc', 
            price=$price, category_id=$category_id, image_path='$image_path', stock=$stock 
            WHERE id=$id";
    return mysqli_query($con, $sql);
}

function deleteBook($id){
    $con = getConnection();
    
    $checkSql = "SELECT count(*) as total FROM order_items, orders 
                 WHERE order_items.order_id = orders.id 
                 AND order_items.book_id = $id 
                 AND orders.status = 'pending'";
    $checkResult = mysqli_query($con, $checkSql);
    $row = mysqli_fetch_assoc($checkResult);

    if($row['total'] > 0){
        return "blocked";
    }

    $book = getBookById($id);
    if($book['image_path'] != "" && file_exists('../' . $book['image_path'])){
        unlink('../' . $book['image_path']);
    }

    $sql = "DELETE FROM books WHERE id = $id";
    mysqli_query($con, $sql);
    return "deleted";
}

// ==================== CATEGORY FUNCTIONS ====================

function getAllCategories(){
    $con = getConnection();
    $result = mysqli_query($con, "SELECT * FROM categories ORDER BY name ASC");
    $categories = [];
    while($row = mysqli_fetch_assoc($result)){
        $categories[] = $row;
    }
    return $categories;
}

// ==================== USER / CUSTOMER FUNCTIONS ====================

function getAllUsers(){
    $con = getConnection();
    $sql = "SELECT id, name, email, role, created_at FROM users ORDER BY id DESC";
    $result = mysqli_query($con, $sql);
    $users = [];
    while($row = mysqli_fetch_assoc($result)){
        $users[] = $row;
    }
    return $users;
}

function getAllCustomers(){
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE role = 'customer' ORDER BY id DESC";
    $result = mysqli_query($con, $sql);
    $customers = [];
    while($row = mysqli_fetch_assoc($result)){
        $customers[] = $row;
    }
    return $customers;
}

function deleteCustomer($id){
    $con = getConnection();
    
    mysqli_query($con, "DELETE FROM cart WHERE user_id = $id");
    
    $orderSql = "SELECT id FROM orders WHERE user_id = $id";
    $orderRes = mysqli_query($con, $orderSql);
    while($order = mysqli_fetch_assoc($orderRes)){
        $oid = $order['id'];
        mysqli_query($con, "DELETE FROM payments WHERE order_id = $oid");
        mysqli_query($con, "DELETE FROM order_items WHERE order_id = $oid");
    }
    
    mysqli_query($con, "DELETE FROM orders WHERE user_id = $id");
    return mysqli_query($con, "DELETE FROM users WHERE id = $id AND role = 'customer'");
}

// ==================== ORDER FUNCTIONS ====================

function getAllOrders($status_filter = '', $date_filter = ''){
    $con = getConnection();
    $sql = "SELECT orders.*, users.name as customer_name 
            FROM orders, users 
            WHERE orders.user_id = users.id";

    if($status_filter != ''){
        $sql .= " AND orders.status = '$status_filter'";
    }
    if($date_filter != ''){
        $sql .= " AND DATE(orders.order_date) = '$date_filter'";
    }

    $sql .= " ORDER BY orders.order_date DESC";
    $result = mysqli_query($con, $sql);
    
    $orders = [];
    while($row = mysqli_fetch_assoc($result)){
        $orders[] = $row;
    }
    return $orders;
}

function getOrderItems($order_id){
    $con = getConnection();
    $sql = "SELECT order_items.*, books.title as book_title 
            FROM order_items, books 
            WHERE order_items.book_id = books.id 
            AND order_items.order_id = $order_id";
    $result = mysqli_query($con, $sql);
    
    $items = [];
    while($row = mysqli_fetch_assoc($result)){
        $items[] = $row;
    }
    return $items;
}

function updateOrderStatus($order_id, $status){
    $con = getConnection();
    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    return mysqli_query($con, $sql);
}

// ==================== DASHBOARD COUNTS ====================

function getDashboardCounts(){
    $con = getConnection();
    $data = [];

    $r1 = mysqli_query($con, "SELECT COUNT(*) as total FROM books");
    $data['books'] = mysqli_fetch_assoc($r1)['total'];

    $r2 = mysqli_query($con, "SELECT COUNT(*) as total FROM users WHERE role='customer'");
    $data['customers'] = mysqli_fetch_assoc($r2)['total'];

    $r3 = mysqli_query($con, "SELECT COUNT(*) as total FROM orders");
    $data['orders'] = mysqli_fetch_assoc($r3)['total'];

    $r4 = mysqli_query($con, "SELECT SUM(total_amount) as total FROM orders");
    $row = mysqli_fetch_assoc($r4);
    $data['revenue'] = $row['total'] ? $row['total'] : 0;

    return $data;
}
?>
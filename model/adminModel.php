<?php
require_once(__DIR__ . '/../config/db.php');


function getAllBooks() {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(
        "SELECT books.*, categories.name AS category_name
         FROM books
         JOIN categories ON books.category_id = categories.id
         ORDER BY books.id DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getBookById($id) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addBook($title, $author, $desc, $price, $category_id, $image_path, $stock) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(
        "INSERT INTO books (title, author, description, price, category_id, image_path, stock)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    return $stmt->execute([$title, $author, $desc, $price, $category_id, $image_path, $stock]);
}

function updateBook($id, $title, $author, $desc, $price, $category_id, $image_path, $stock) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(
        "UPDATE books SET title = ?, author = ?, description = ?, price = ?, category_id = ?, image_path = ?, stock = ?
         WHERE id = ?"
    );
    return $stmt->execute([$title, $author, $desc, $price, $category_id, $image_path, $stock, $id]);
}

function deleteBook($id) {
    $pdo = getPDO();

    $check = $pdo->prepare(
        "SELECT COUNT(*) AS total FROM order_items
         JOIN orders ON order_items.order_id = orders.id
         WHERE order_items.book_id = ? AND orders.status = 'pending'"
    );
    $check->execute([$id]);
    $row = $check->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        return "blocked";
    }

    $book = getBookById($id);
    if ($book && $book['image_path'] != "" && file_exists('../' . $book['image_path'])) {
        unlink('../' . $book['image_path']);
    }

    $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$id]);
    return "deleted";
}


function getAllCategories() {
    $pdo  = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY name ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCategoryById($id) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addCategory($name) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    return $stmt->execute([$name]);
}

function updateCategory($id, $name) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
    return $stmt->execute([$name, $id]);
}

function deleteCategory($id) {
    $pdo = getPDO();

    $check = $pdo->prepare("SELECT COUNT(*) AS total FROM books WHERE category_id = ?");
    $check->execute([$id]);
    $row = $check->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        return "blocked";
    }

    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return "deleted";
}


function getAllUsers() {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(
        "SELECT id, name, email, role, created_at FROM users ORDER BY id DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCustomers() {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE role = 'customer' ORDER BY id DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteCustomer($id) {
    $pdo = getPDO();

    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$id]);

    $stmt = $pdo->prepare("SELECT id FROM orders WHERE user_id = ?");
    $stmt->execute([$id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as $order) {
        $stmt = $pdo->prepare("DELETE FROM payments WHERE order_id = ?");
        $stmt->execute([$order['id']]);

        $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->execute([$order['id']]);
    }

    $stmt = $pdo->prepare("DELETE FROM orders WHERE user_id = ?");
    $stmt->execute([$id]);

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'customer'");
    return $stmt->execute([$id]);
}


function getAllOrders($status_filter = '', $date_filter = '') {
    $pdo    = getPDO();
    $params = [];

    $sql = "SELECT orders.*, users.name AS customer_name
            FROM orders
            JOIN users ON orders.user_id = users.id
            WHERE 1=1";

    if ($status_filter !== '') {
        $sql     .= " AND orders.status = ?";
        $params[] = $status_filter;
    }
    if ($date_filter !== '') {
        $sql     .= " AND DATE(orders.order_date) = ?";
        $params[] = $date_filter;
    }

    $sql .= " ORDER BY orders.order_date DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOrderItems($order_id) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(
        "SELECT order_items.*, books.title AS book_title
         FROM order_items
         JOIN books ON order_items.book_id = books.id
         WHERE order_items.order_id = ?"
    );
    $stmt->execute([$order_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateOrderStatus($order_id, $status) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    return $stmt->execute([$status, $order_id]);
}


function getDashboardCounts() {
    $pdo  = getPDO();
    $data = [];

    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM books");
    $stmt->execute();
    $data['books'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM categories");
    $stmt->execute();
    $data['categories'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");
    $stmt->execute();
    $data['customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM orders");
    $stmt->execute();
    $data['orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM orders WHERE status = 'pending'");
    $stmt->execute();
    $data['pending'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $pdo->prepare("SELECT SUM(total_amount) AS total FROM orders");
    $stmt->execute();
    $row             = $stmt->fetch(PDO::FETCH_ASSOC);
    $data['revenue'] = $row['total'] ? $row['total'] : 0;

    return $data;
}

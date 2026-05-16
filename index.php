<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controller/BookController.php';
require_once __DIR__ . '/controller/CartController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($page === 'cart') {
    $controller = new CartController($conn);
    $controller->showCart();
} elseif ($page === 'book') {
    $controller = new BookController($conn);
    $controller->showDetails();
} else {
    require_once __DIR__ . '/search_test.php';
}
?>
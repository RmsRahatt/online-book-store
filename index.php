<?php
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'default';

if ($page === 'cart') {
    require_once 'config/database.php';
    require_once 'controller/CartController.php';
    $controller = new CartController($conn);
    $controller->showCart();

} elseif ($page === 'search') {
    require_once 'search_test.php';

} elseif ($page === 'book') {
    require_once 'config/database.php';
    require_once 'controller/BookController.php';
    $controller = new BookController($conn);
    $controller->showDetails();

} elseif ($page === 'checkout') 
    require_once 'view/checkout.php';
     elseif ($page === 'history') 
    require_once 'view/purchase_history.php';
 elseif ($page === 'default') {
    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 'admin'){
            header('location: view/admin/dashboard.php');
        } else {
            header('location: view/home.php');
        }
    } else {
        header('location: view/login.php');
    }
}
exit();
?>
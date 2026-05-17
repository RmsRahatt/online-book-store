<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controller/CartController.php';

$controller = new CartController($conn); 
$controller->showCart();
?>
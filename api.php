<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controller/ApiController.php';

$api = new ApiController($conn);

$action = isset($_GET['action']) ? $_GET['action'] : 'search';

if ($action === 'add_to_cart') {
    $api->addToCart();
} elseif ($action === 'update_cart') {
    $api->updateCart();
} elseif ($action === 'remove_from_cart') {
    $api->removeFromCart();
} else {
    $api->searchBooks();
}
?>
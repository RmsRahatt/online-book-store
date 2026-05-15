<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controller/BookController.php';

$_GET['id'] = 1;

$controller = new BookController($conn); 
$controller->showDetails();
?>
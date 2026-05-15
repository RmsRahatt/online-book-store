<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controller/ApiController.php';

$api = new ApiController($conn);

$api->searchBooks();
?>
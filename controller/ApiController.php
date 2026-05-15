<?php
require_once __DIR__ . '/../model/BookModel.php';
require_once __DIR__ . '/../config/database.php';

class ApiController {
    private $bookModel;

    public function __construct($dbConnection) {
        $this->bookModel = new BookModel($dbConnection);
    }

    public function searchBooks() {
        header('Content-Type: application/json');

        $searchTerm = isset($_GET['q']) ? $_GET['q'] : '';
        $filterType = isset($_GET['filter']) ? $_GET['filter'] : 'title';

        $results = $this->bookModel->search($searchTerm, $filterType);

        echo json_encode($results);
        exit;
    }
}
?>
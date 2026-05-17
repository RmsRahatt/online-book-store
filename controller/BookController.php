<?php
require_once __DIR__ . '/../model/BookModel.php';

class BookController {
    private $bookModel;

    public function __construct($dbConnection) {
        $this->bookModel = new BookModel($dbConnection);
    }

    public function showDetails() {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $bookId = (int) $_GET['id'];
            $book = $this->bookModel->getBookById($bookId);

            if ($book) {
                require_once __DIR__ . '/../view/book_details.php';
            } else {
                echo "<h1>Book not found.</h1>";
            }
        } else {
            echo "<h1>Invalid book ID.</h1>";
        }
    }
}
?>
<?php
require_once __DIR__ . '/../model/BookModel.php';
require_once __DIR__ . '/../model/CartModel.php';
require_once __DIR__ . '/../config/database.php';

class ApiController {
    private $bookModel;
    private $cartModel;

    public function __construct($dbConnection) {
        $this->bookModel = new BookModel($dbConnection);
        $this->cartModel = new CartModel($dbConnection);
    }

    public function searchBooks() {
        header('Content-Type: application/json');

        $rawSearch = isset($_GET['q']) ? trim($_GET['q']) : '';
        $rawFilter = isset($_GET['filter']) ? trim($_GET['filter']) : 'title';

        $searchTerm = htmlspecialchars(strip_tags($rawSearch));
        $filterType = htmlspecialchars(strip_tags($rawFilter));

        $validFilters = ['title', 'author', 'category'];
        if (!in_array($filterType, $validFilters)) {
            $filterType = 'title';
        }

        $results = $this->bookModel->search($searchTerm, $filterType);

        foreach ($results as &$book) {
            $book['title'] = htmlspecialchars($book['title']);
            $book['author'] = htmlspecialchars($book['author']);
            $book['category_name'] = htmlspecialchars($book['category_name']);
        }

        echo json_encode($results);
        exit;
    }
    public function addToCart() {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 1; 
            $_SESSION['role'] = 'customer';
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['book_id']) || !isset($data['quantity']) || 
            !is_numeric($data['book_id']) || !is_numeric($data['quantity']) || $data['quantity'] < 1) {
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
            exit;
        }

        $bookId = (int)$data['book_id'];
        $quantity = (int)$data['quantity'];
        $userId = $_SESSION['user_id'];

        $result = $this->cartModel->addToCart($userId, $bookId, $quantity);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Book added to cart!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error. Could not add to cart.']);
        }
        exit;
    }
    public function updateCart() {
        header('Content-Type: application/json');
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 1; 
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['cart_id']) || !isset($data['quantity']) || !is_numeric($data['cart_id']) || !is_numeric($data['quantity'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid data.']);
            exit;
        }

        $result = $this->cartModel->updateQuantity((int)$data['cart_id'], $_SESSION['user_id'], (int)$data['quantity']);
        echo json_encode(['success' => $result]);
        exit;
    }

    public function removeFromCart() {
        header('Content-Type: application/json');
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 1; 
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['cart_id']) || !is_numeric($data['cart_id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid data.']);
            exit;
        }

        $result = $this->cartModel->removeFromCart((int)$data['cart_id'], $_SESSION['user_id']);
        echo json_encode(['success' => $result]);
        exit;
    }
}
?>


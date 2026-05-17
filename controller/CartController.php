<?php
require_once __DIR__ . '/../model/CartModel.php';

class CartController {
    private $cartModel;

    public function __construct($dbConnection) {
        $this->cartModel = new CartModel($dbConnection);
    }

    public function showCart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 1;
        }

        $userId = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItems($userId);

        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += ($item['price'] * $item['quantity']);
        }

        require_once __DIR__ . '/../view/cart.php';
    }
}
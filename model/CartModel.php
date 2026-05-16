<?php
class CartModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addToCart($userId, $bookId, $quantity) {
        try {
            $checkSql = "SELECT id, quantity FROM cart WHERE user_id = :user_id AND book_id = :book_id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':user_id' => $userId, ':book_id' => $bookId]);
            $existingItem = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                $newQuantity = $existingItem['quantity'] + $quantity;
                $updateSql = "UPDATE cart SET quantity = :quantity WHERE id = :cart_id";
                $updateStmt = $this->db->prepare($updateSql);
                return $updateStmt->execute([':quantity' => $newQuantity, ':cart_id' => $existingItem['id']]);
            } else {
                $insertSql = "INSERT INTO cart (user_id, book_id, quantity) VALUES (:user_id, :book_id, :quantity)";
                $insertStmt = $this->db->prepare($insertSql);
                return $insertStmt->execute([':user_id' => $userId, ':book_id' => $bookId, ':quantity' => $quantity]);
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getCartItems($userId) {
        try {
            $sql = "SELECT c.id AS cart_id, c.quantity, b.id AS book_id, b.title, b.price, b.stock 
                    FROM cart c 
                    JOIN books b ON c.book_id = b.id 
                    WHERE c.user_id = :user_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    public function updateQuantity($cartId, $userId, $quantity) {
        try {
            $sql = "UPDATE cart SET quantity = :quantity WHERE id = :cart_id AND user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':quantity' => $quantity, ':cart_id' => $cartId, ':user_id' => $userId]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function removeFromCart($cartId, $userId) {
        try {
            $sql = "DELETE FROM cart WHERE id = :cart_id AND user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':cart_id' => $cartId, ':user_id' => $userId]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
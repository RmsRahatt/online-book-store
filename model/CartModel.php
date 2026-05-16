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
}
?>
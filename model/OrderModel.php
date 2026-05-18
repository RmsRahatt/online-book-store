<?php
class OrderModel {
    private $db;

    public function __construct($db_conn) {
        $this->db = $db_conn;
    }

    public function createOrder($user_id, $total, $payment) {
        try {
            $status = 'pending';
            $sql = "INSERT INTO orders (user_id, total_amount, status, payment_method) 
                    VALUES (:user_id, :total, :status, :payment)";
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':user_id' => $user_id,
                ':total'   => $total,
                ':status'  => $status,
                ':payment' => $payment
            ]);

            if ($result) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>

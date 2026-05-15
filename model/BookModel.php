<?php
class BookModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getBookById($id) {
        try {
            $sql = "SELECT b.*, c.name AS category_name 
                    FROM books b 
                    LEFT JOIN categories c ON b.category_id = c.id 
                    WHERE b.id = :id";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
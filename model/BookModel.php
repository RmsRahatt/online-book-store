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

    public function search($searchTerm, $filterType) {
        try {
            $sql = "SELECT b.*, c.name AS category_name 
                    FROM books b 
                    LEFT JOIN categories c ON b.category_id = c.id 
                    WHERE ";

            if ($filterType === 'author') {
                $sql .= "b.author LIKE :term";
            } elseif ($filterType === 'category') {
                $sql .= "c.name LIKE :term";
            } else {
                $sql .= "b.title LIKE :term";
            }

            $stmt = $this->db->prepare($sql);
            $wildcardTerm = '%' . $searchTerm . '%';
            $stmt->bindParam(':term', $wildcardTerm, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}

// ✅ Procedural functions — সরাসরি PDO connection বানাচ্ছে
function _makeConnection() {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=book_store;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function getCategories(){
    $pdo  = _makeConnection();
    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeaturedBooks(){
    $pdo  = _makeConnection();
    $stmt = $pdo->prepare("SELECT * FROM books ORDER BY id DESC LIMIT 10");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getBooksByCategory($id){
    $pdo  = _makeConnection();
    $stmt = $pdo->prepare("SELECT * FROM books WHERE category_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

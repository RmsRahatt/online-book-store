<?php

session_start();

require_once "../model/bookModel.php";

if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit();
}

$id    = intval($_GET['id']);
$books = getBooksByCategory($id);

include "header.php";
?>

<h2>Books in this Category</h2>

<?php if (count($books) == 0): ?>
    <p>No books found in this category.</p>
<?php endif; ?>

<div class="book-container">
<?php foreach ($books as $book): ?>
    <div class="book-card">
        <?php if (!empty($book['image_path'])): ?>
            <img src="../public/uploads/books/<?php echo htmlspecialchars($book['image_path']); ?>" width="100"><br><br>
        <?php endif; ?>
        <h3><?php echo htmlspecialchars($book['title']); ?></h3>
        <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
        <p>Price: <?php echo htmlspecialchars($book['price']); ?> BDT</p>
        <p><?php echo htmlspecialchars($book['description']); ?></p>
    </div>
<?php endforeach; ?>
</div>

<?php include "footer.php"; ?>

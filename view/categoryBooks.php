<?php

session_start();

require_once "../model/bookModel.php";

if(!isset($_SESSION['status'])){
    header("location: login.php");
    exit();
}

$id     = intval($_GET['id']);
$result = getBooksByCategory($id); // ✅ PDO array

include "header.php";

?>

<h2>Books</h2>

<?php foreach($result as $book){ ?>

<div class="book-card">

    <h3><?php echo htmlspecialchars($book['title']); ?></h3>

    <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>

    <p>Price: <?php echo htmlspecialchars($book['price']); ?></p>

    <p><?php echo htmlspecialchars($book['description']); ?></p>

</div>

<?php } ?>

<?php include "footer.php"; ?>

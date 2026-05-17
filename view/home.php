<?php

session_start();

require_once "../controller/autoLogin.php";
require_once "../model/bookModel.php";

if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit();
}

$categories = getCategories();
$books      = getFeaturedBooks();

include "header.php";
?>

<h2>Welcome <?php echo htmlspecialchars($_SESSION['name']); ?></h2>

<h2>Categories</h2>

<ul>
<?php foreach ($categories as $row): ?>
    <li>
        <a href="categoryBooks.php?id=<?php echo $row['id']; ?>">
            <?php echo htmlspecialchars($row['name']); ?>
        </a>
        &nbsp;
        <a href="#" onclick="loadBooks(<?php echo $row['id']; ?>); return false;">
            [Load Without Reload]
        </a>
    </li>
<?php endforeach; ?>
</ul>

<div id="bookResults"></div>

<hr>

<h2>Featured Books</h2>

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

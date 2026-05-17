<?php

session_start();

require_once "../controller/autoLogin.php";
require_once "../model/bookModel.php";

if(!isset($_SESSION['status'])){

    header("location: login.php");

    exit();
}

$categories = getCategories();
$books = getFeaturedBooks();

include "header.php";

?>

<h2>
Welcome
<?php
echo htmlspecialchars(
    $_SESSION['name']
);
?>
</h2>

<h2>Categories</h2>

<ul>

<?php
while($row = mysqli_fetch_assoc($categories)){
?>

<li>

<a href="categoryBooks.php?id=<?php
echo $row['id'];
?>">

<?php
echo htmlspecialchars(
    $row['name']
);
?>

</a>

</li>

<?php
}
?>

</ul>

<hr>

<h2>Featured Books</h2>

<div class="book-container">

<?php
while($book = mysqli_fetch_assoc($books)){
?>

<div class="book-card">

<h3>
<?php
echo htmlspecialchars(
    $book['title']
);
?>
</h3>

<p>
Author:
<?php
echo htmlspecialchars(
    $book['author']
);
?>
</p>

<p>
Price:
<?php
echo htmlspecialchars(
    $book['price']
);
?>
</p>

<p>
<?php
echo htmlspecialchars(
    $book['description']
);
?>
</p>

</div>

<?php
}
?>

</div>

<?php include "footer.php"; ?>
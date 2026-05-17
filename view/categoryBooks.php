<?php

session_start();

require_once "../model/bookModel.php";

if(!isset($_SESSION['status'])){

    header("location: login.php");

    exit();
}

$id = intval($_GET['id']);

$result = getBooksByCategory($id);

include "header.php";

?>

<h2>Books</h2>

<?php
while($book = mysqli_fetch_assoc($result)){
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

<?php include "footer.php"; ?>
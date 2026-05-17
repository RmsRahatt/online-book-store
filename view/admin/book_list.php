<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../../index.php');
        exit();
    }
    require_once('../../model/adminModel.php');
    $books = getAllBooks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Management</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">

    <?php if(isset($_SESSION['success'])){ ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php } ?>
    <?php if(isset($_SESSION['error'])){ ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>

    <h2>Book Management</h2>
    <a href="book_add.php" class="btn btn-success add-btn-spacing">+ Add New Book</a>

    <table>
        <tr>
            <th>#</th>
            <th>Cover</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Price (৳)</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>
        <?php if(count($books) == 0){ ?>
            <tr>
                <td colspan="8" class="empty-table-msg">No books found. Add one!</td>
            </tr>
        <?php } ?>
        <?php $i = 1; foreach($books as $book){ ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td>
                <?php if($book['image_path']){ ?>
                    <img src="../../<?php echo htmlspecialchars($book['image_path']); ?>" class="thumb" alt="cover">
                <?php } else { ?>
                    <span class="no-image-text">No image</span>
                <?php } ?>
            </td>
            <td><?php echo htmlspecialchars($book['title']); ?></td>
            <td><?php echo htmlspecialchars($book['author']); ?></td>
            <td><?php echo htmlspecialchars($book['category_name']); ?></td>
            <td><?php echo number_format($book['price'], 2); ?></td>
            <td><?php echo $book['stock']; ?></td>
            <td>
                <a href="book_edit.php?id=<?php echo $book['id']; ?>" class="btn btn-primary">Edit</a>
                <form method="post" action="../../controller/bookDelete.php" style="display:inline;"
                      onsubmit="return confirm('Are you sure you want to delete this book?')">
                    <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>
</body>
</html>
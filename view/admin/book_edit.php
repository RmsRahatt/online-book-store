<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../../index.php');
        exit();
    }
    if(!isset($_GET['id'])){
        header('location: book_list.php');
        exit();
    }
    require_once('../../model/adminModel.php');
    $book       = getBookById($_GET['id']);
    $categories = getAllCategories();

    if(!$book){
        header('location: book_list.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">

    <?php if(isset($_SESSION['error'])){ ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>

    <h2>Edit Book</h2>

    <div class="form-wrap">
        <form method="post" action="../../controller/bookEdit.php" enctype="multipart/form-data" onsubmit="return validateBookForm();">

            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">

            <div class="form-group">
                <label>Book Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($book['title']); ?>"/>
                <span id="titleError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Author:</label>
                <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($book['author']); ?>"/>
                <span id="authorError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" id="description"><?php echo htmlspecialchars($book['description']); ?></textarea>
                <span id="descError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Price (৳):</label>
                <input type="number" name="price" id="price" value="<?php echo $book['price']; ?>" step="0.01" min="0.01"/>
                <span id="priceError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Category:</label>
                <select name="category_id" id="category_id">
                    <option value="">-- Select Category --</option>
                    <?php foreach($categories as $cat){ ?>
                    <option value="<?php echo $cat['id']; ?>"
                        <?php if($book['category_id'] == $cat['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                    <?php } ?>
                </select>
                <span id="catError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Stock Quantity:</label>
                <input type="number" name="stock" id="stock" value="<?php echo $book['stock']; ?>" min="0"/>
                <span id="stockError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Book Cover Image (JPEG/PNG, max 2MB):</label>
                <?php if($book['image_path']){ ?>
                    <br>
                    <img src="../../<?php echo htmlspecialchars($book['image_path']); ?>" class="preview" alt="Current Cover">
                   <p class="help-text">Upload new image to replace current one.</p>
                <?php } ?>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png"/>
                <span id="imageError" class="error-msg"></span>
            </div>

            <input type="submit" name="submit" value="Update Book" class="btn btn-success"/>
            &nbsp;&nbsp;
            <a href="book_list.php" class="btn btn-secondary">Cancel</a>

        </form>
    </div>

</div>

<script src="../../public/js/admin.js"></script>
</body>
</html>
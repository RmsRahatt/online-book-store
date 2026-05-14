<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../../index.php');
        exit();
    }
    require_once('../../model/adminModel.php');
    $categories = getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book</title>
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

    <h2>Add New Book</h2>

    <div class="form-wrap">
        <form method="post" action="../../controller/bookAdd.php" enctype="multipart/form-data" onsubmit="return validateBookForm();">

            <div class="form-group">
                <label>Book Title:</label>
                <input type="text" name="title" id="title" placeholder="e.g. Webtech Projects Story"/>
                <span id="titleError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Author:</label>
                <input type="text" name="author" id="author" placeholder="e.g. Md.Rahat Mostakim"/>
                <span id="authorError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" id="description" placeholder="Brief description..."></textarea>
                <span id="descError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Price (৳):</label>
                <input type="number" name="price" id="price" placeholder="e.g. 100" step="0.01" min="0.01"/>
                <span id="priceError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Category:</label>
                <select name="category_id" id="category_id">
                    <option value="">-- Select Category --</option>
                    <?php foreach($categories as $cat){ ?>
                    <option value="<?php echo $cat['id']; ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                    <?php } ?>
                </select>
                <span id="catError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Stock Quantity:</label>
                <input type="number" name="stock" id="stock" placeholder="e.g. 50" min="0"/>
                <span id="stockError" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label>Book Cover Image (JPEG/PNG, max 2MB):</label>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png"/>
                <span id="imageError" class="error-msg"></span>
            </div>

            <input type="submit" name="submit" value="Add Book" class="btn btn-success"/>
            &nbsp;&nbsp;
            <a href="book_list.php" class="btn btn-secondary">Cancel</a>

        </form>
    </div>

</div>

<script src="../../public/js/admin.js"></script>
</body>
</html>
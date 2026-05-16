<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../../index.php');
        exit();
    }
    require_once('../../model/adminModel.php');
    $categories = getAllCategories();

    $edit_cat = null;
    if(isset($_GET['edit_id'])){
        $edit_cat = getCategoryById($_GET['edit_id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
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

    <h2>Category Management</h2>
    <p id="flashMsg" class="flash-success-text"></p>

    <div class="form-wrap">
        <?php if($edit_cat){ ?>
            <h3>Edit Category</h3>
            <form method="post" action="../../controller/categoryEdit.php" onsubmit="return validateCategoryForm();">
                <input type="hidden" name="id" value="<?php echo $edit_cat['id']; ?>">
                <div class="form-group">
                    <label>Category Name:</label>
                    <input type="text" name="name" id="cat_name" value="<?php echo htmlspecialchars($edit_cat['name']); ?>"/>
                    <span id="catNameError" class="error-msg"></span>
                </div>
                <input type="submit" name="submit" value="Update Category" class="btn btn-primary"/>
                &nbsp;&nbsp;
                <a href="category_list.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php } else { ?>
            <h3>Add New Category</h3>
            <form method="post" action="../../controller/categoryAdd.php" onsubmit="return validateCategoryForm();">
                <div class="form-group">
                    <label>Category Name:</label>
                    <input type="text" name="name" id="cat_name" placeholder="e.g. Novel, Sci-Fi, Literature"/>
                    <span id="catNameError" class="error-msg"></span>
                </div>
                <input type="submit" name="submit" value="Add Category" class="btn btn-success"/>
            </form>
        <?php } ?>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php if(count($categories) == 0){ ?>
            <tr>
                <td colspan="4" class="empty-table-msg">No categories found.</td>
            </tr>
        <?php } ?>
        <?php $i = 1; foreach($categories as $cat){ ?>
        <tr id="cat_row_<?php echo $cat['id']; ?>">
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($cat['name']); ?></td>
            <td><?php echo $cat['created_at']; ?></td>
            <td>
                <a href="category_list.php?edit_id=<?php echo $cat['id']; ?>" class="btn btn-primary">Edit</a>
                <button class="btn btn-danger" onclick="deleteCategory(<?php echo $cat['id']; ?>)">Delete</button>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>

<script src="../../public/js/admin.js"></script>
</body>
</html>

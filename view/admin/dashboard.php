<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../../index.php');
        exit();
    }
    require_once('../../model/adminModel.php');
    $counts = getDashboardCounts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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

    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>

    <div class="cards">
        <div class="card">
            <h3><?php echo $counts['books']; ?></h3>
            <p>Total Books</p>
        </div>
        <div class="card blue">
            <h3><?php echo $counts['categories']; ?></h3>
            <p>Total Categories</p>
        </div>
        <div class="card green">
            <h3><?php echo $counts['customers']; ?></h3>
            <p>Total Customers</p>
        </div>
        <div class="card orange">
            <h3><?php echo $counts['pending']; ?></h3>
            <p>Pending Orders</p>
        </div>
        <div class="card purple">
            <h3><?php echo $counts['orders']; ?></h3>
            <p>Total Orders</p>
        </div>
        <div class="card red">
            <h3>৳<?php echo number_format($counts['revenue'], 0); ?></h3>
            <p>Total Revenue</p>
        </div>
    </div>

    <div class="quick-links">
        <h3>Quick Actions</h3>
        <a href="book_add.php" class="btn btn-success">+ Add New Book</a>
        <a href="category_list.php" class="btn btn-primary">Manage Categories</a>
        <a href="customer_list.php" class="btn btn-danger">Manage Customers</a>
        <a href="purchase_history.php" class="btn btn-secondary">View All Orders</a>
        <a href="user_list.php" class="btn btn-secondary">All Registered Users</a>
    </div>

</div>
</body>
</html>

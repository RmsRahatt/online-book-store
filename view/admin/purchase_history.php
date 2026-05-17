<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../../index.php');
        exit();
    }
    require_once('../../model/adminModel.php');

    $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
    $date_filter   = isset($_GET['date'])   ? $_GET['date']   : '';
    $orders        = getAllOrders($status_filter, $date_filter);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase History</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">

    <h2>All Purchase History</h2>
    <p id="flashMsg" class="flash-success-text"></p>

    <!-- Filter Bar -->
    <form method="get" action="purchase_history.php">
        <div class="filter-bar">
            <label class="filter-label">Filter by Status:</label>
            <select name="status" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending"   <?php if($status_filter=='pending')   echo 'selected'; ?>>Pending</option>
                <option value="confirmed" <?php if($status_filter=='confirmed') echo 'selected'; ?>>Confirmed</option>
                <option value="shipped"   <?php if($status_filter=='shipped')   echo 'selected'; ?>>Shipped</option>
                <option value="delivered" <?php if($status_filter=='delivered') echo 'selected'; ?>>Delivered</option>
            </select>

            <input type="date" name="date" value="<?php echo $date_filter; ?>" onchange="this.form.submit()"/>
            <a href="purchase_history.php" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    <?php if(count($orders) == 0){ ?>
        <p class="no-orders-msg">No orders found.</p>
    <?php } ?>

    <?php foreach($orders as $order){ ?>
    <div class="order-card">
        <div class="order-header">
            <div>
                <h4>Order #<?php echo $order['id']; ?> — <?php echo htmlspecialchars($order['customer_name']); ?></h4>
                <small>
                    📅 <?php echo $order['order_date']; ?> &nbsp;|&nbsp;
                    💳 <?php echo htmlspecialchars($order['payment_method']); ?>
                </small>
            </div>
            <div>
                <span class="badge badge-<?php echo $order['status']; ?>" id="badge_<?php echo $order['id']; ?>">
                    <?php echo ucfirst($order['status']); ?>
                </span>
                <br><br>
    
                <select id="select_<?php echo $order['id']; ?>"
                        onchange="updateOrderStatus(<?php echo $order['id']; ?>, this.value)"
                        class="status-dropdown">
                    <option value="pending"   <?php if($order['status']=='pending')   echo 'selected'; ?>>Pending</option>
                    <option value="confirmed" <?php if($order['status']=='confirmed') echo 'selected'; ?>>Confirmed</option>
                    <option value="shipped"   <?php if($order['status']=='shipped')   echo 'selected'; ?>>Shipped</option>
                    <option value="delivered" <?php if($order['status']=='delivered') echo 'selected'; ?>>Delivered</option>
                </select>
            </div>
        </div>

        <?php $items = getOrderItems($order['id']); ?>
        <table>
            <tr>
                <th>Book Title</th>
                <th>Qty</th>
                <th>Unit Price (৳)</th>
                <th>Subtotal (৳)</th>
            </tr>
            <?php foreach($items as $item){ ?>
            <tr>
                <td><?php echo htmlspecialchars($item['book_title']); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['unit_price'], 2); ?></td>
                <td><?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?></td>
            </tr>
            <?php } ?>
        </table>

        <p class="order-total">Total: ৳ <?php echo number_format($order['total_amount'], 2); ?></p>
    </div>
    <?php } ?>

</div>

<script src="../../public/js/admin.js"></script>
</body>
</html>

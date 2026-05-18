<?php
$conn = mysqli_connect('localhost', 'root', '', 'book_store');
if (isset($_POST['update_status'])) {
    $id = $_POST['order_id'];
    $st = $_POST['new_status'];
    mysqli_query($conn, "UPDATE orders SET status='$st' WHERE id='$id'");
}

$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Order Management</title>
</head>
<body style="display: flex; justify-content: center; padding: 50px; font-family: Arial; background-color: #f4f4f4;">

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(255, 0, 0, 0.1); width: 90%;">
        <h2 style="text-align: center;">Admin process</h2>
        
        <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead style="background: #333; color: white;">
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Current Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($orders)) { ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['total_amount']; ?> TK</td>
                    <td><?php echo strtoupper($row['payment_method']); ?></td>
                    <td><strong><?php echo strtoupper($row['status']); ?></strong></td>
                    <td>
                        <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <select name="new_status">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
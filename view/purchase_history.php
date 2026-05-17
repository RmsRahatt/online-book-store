<?php
$conn = mysqli_connect('localhost', 'root', '', 'book_store');

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

$user_id = 1; 
$sql = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase History</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; font-family: Arial, sans-serif; background-color: #ffffff;">

    <div style="text-align: center;">
        <a href="checkout.php" style="text-decoration: none; color: black; font-weight: bold; font-size: 14px;">← Back to Checkout</a>
        <h2 style="margin-top: 15px; margin-bottom: 20px;">My Purchase History</h2>
        
        <table border="1" cellpadding="12" style="border-collapse: collapse; margin: 0 auto;">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Payment Method</th>
                    <th>Total Amount</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) { 
                ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><?php echo strtoupper($row['payment_method']); ?></td>
                    <td><?php echo number_format($row['total_amount'], 2); ?> TK</td>
                    <td><?php echo strtoupper($row['status']); ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='5'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../../index.php');
        exit();
    }
    require_once('../../model/adminModel.php');
    $customers = getAllCustomers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Remove Customers</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">

    <h2>Remove Customers</h2>
    <p id="flashMsg" class="flash-success-text"></p>

    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Joined</th>
            <th>Action</th>
        </tr>
        <?php if(count($customers) == 0){ ?>
            <tr>
                <td colspan="7" class="empty-table-msg">No customers found.</td>
            </tr>
        <?php } ?>
        <?php $i = 1; foreach($customers as $c){ ?>
        <tr id="row_<?php echo $c['id']; ?>">
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($c['name']); ?></td>
            <td><?php echo htmlspecialchars($c['email']); ?></td>
            <td><?php echo htmlspecialchars($c['phone']); ?></td>
            <td><?php echo htmlspecialchars($c['address']); ?></td>
            <td><?php echo $c['created_at']; ?></td>
            <td>
                <button class="btn btn-danger" onclick="deleteCustomer(<?php echo $c['id']; ?>)">Delete</button>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>

<script src="../../public/js/admin.js"></script>
</body>
</html>
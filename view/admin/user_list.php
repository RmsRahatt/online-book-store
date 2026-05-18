<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../../index.php');
        exit();
    }
    require_once('../../model/adminModel.php');
    $users = getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Registered Users</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">

    <h2>All Registered Users</h2>

    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Joined</th>
        </tr>
        <?php if(count($users) == 0){ ?>
            <tr>
                <td colspan="5" class="empty-table-msg">No users found.</td>
            </tr>
        <?php } ?>
        <?php $i = 1; foreach($users as $u){ ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($u['name']); ?></td>
            <td><?php echo htmlspecialchars($u['email']); ?></td>
            <td>
                <?php if($u['role'] == 'admin'){ ?>
                    <span class="badge-admin">Admin</span>
                <?php } else { ?>
                    <span class="badge-customer">Customer</span>
                <?php } ?>
            </td>
            <td><?php echo $u['created_at']; ?></td>
        </tr>
        <?php } ?>
    </table>

</div>
</body>
</html>
<?php

session_start();

require_once "../model/userModel.php";

if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit();
}

$rows = getUserById($_SESSION['user_id']);
$user = $rows[0];

include "header.php";
?>

<h2>Profile</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>

<?php if (!empty($user['profile_picture'])): ?>
    <img src="../public/uploads/profiles/<?php echo htmlspecialchars($user['profile_picture']); ?>" width="100"><br><br>
<?php endif; ?>

<form method="POST" action="../controller/profileUpdate.php" enctype="multipart/form-data" onsubmit="return validateProfile()">

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <input type="text" name="name" id="profileName" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Name">
    <br><br>

    <input type="email" name="email" id="profileEmail" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Email">
    <br><br>

    <textarea name="address" id="profileAddress" placeholder="Address"><?php echo htmlspecialchars($user['address']); ?></textarea>
    <br><br>

    <input type="text" name="phone" id="profilePhone" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="Phone">
    <br><br>

    <label>Profile Picture:</label>
    <input type="file" name="picture">
    <br><br>

    <span id="profileError" class="error"></span>
    <br><br>

    <input type="submit" name="update" value="Update Profile">

</form>

<hr>

<h2>Change Password</h2>

<form method="POST" action="../controller/changePassword.php">

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <input type="password" name="current_password" id="currentPassword" placeholder="Current Password">
    <br><br>

    <input type="password" name="new_password" id="newPassword" placeholder="New Password (min 8 chars)">
    <br><br>

    <span id="passwordError" class="error"></span>
    <br><br>

    <input type="submit" value="Change Password">

</form>

<?php include "footer.php"; ?>

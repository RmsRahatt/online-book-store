<?php

session_start();

require_once "../model/userModel.php";

if(!isset($_SESSION['status'])){
    header("location: login.php");
    exit();
}

$result = getUserById($_SESSION['user_id']); // PDO array return করে
$user   = $result[0]; // ✅ PDO: first row

include "header.php";

?>

<h2>Profile</h2>

<?php
if(isset($_SESSION['success'])){
    echo "<p class='success'>" . htmlspecialchars($_SESSION['success']) . "</p>";
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    echo "<p class='error'>" . htmlspecialchars($_SESSION['error']) . "</p>";
    unset($_SESSION['error']);
}
?>

<?php if($user['profile_picture'] != ""){ ?>
<img src="../public/uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" width="100">
<br><br>
<?php } ?>

<form method="POST" action="../controller/profileUpdate.php" enctype="multipart/form-data" onsubmit="return validateProfile()">

<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

<input type="text" name="name" id="profileName" value="<?php echo htmlspecialchars($user['name']); ?>">
<br><br>

<input type="email" name="email" id="profileEmail" value="<?php echo htmlspecialchars($user['email']); ?>">
<br><br>

<textarea name="address" id="profileAddress"><?php echo htmlspecialchars($user['address']); ?></textarea>
<br><br>

<input type="text" name="phone" id="profilePhone" value="<?php echo htmlspecialchars($user['phone']); ?>">
<br><br>

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

<input type="password" name="new_password" id="newPassword" placeholder="New Password">
<br><br>

<span id="passwordError" class="error"></span>
<br><br>

<input type="submit" value="Change Password">

</form>

<?php include "footer.php"; ?>

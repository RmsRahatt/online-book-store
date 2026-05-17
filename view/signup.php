<?php include "header.php"; ?>

<h2>Signup</h2>

<?php
if(isset($_SESSION['error'])){

    echo "<p class='error'>".
    htmlspecialchars(
        $_SESSION['error']
    ).
    "</p>";

    unset($_SESSION['error']);
}
?>

<form
name="signupForm"
method="POST"
action="../controller/signupCheck.php"
onsubmit="return validateSignup()">

<input
type="hidden"
name="csrf_token"
value="<?php echo $_SESSION['csrf_token']; ?>">

<input
type="text"
name="name"
id="signupName"
placeholder="Name">

<br><br>

<input
type="email"
name="email"
id="signupEmail"
placeholder="Email">

<br><br>

<input
type="password"
name="password"
id="signupPassword"
placeholder="Password">

<br><br>

<select
name="role"
id="signupRole">

<option value="">
Select Role
</option>

<option value="admin">
Admin
</option>

<option value="customer">
Customer
</option>

</select>

<br><br>

<textarea
name="address"
id="signupAddress"
placeholder="Address"></textarea>

<br><br>

<input
type="text"
name="phone"
id="signupPhone"
placeholder="Phone">

<br><br>

<span
id="signupError"
class="error">
</span>

<br><br>

<input
type="submit"
name="signup"
value="Signup">

</form>

<?php include "footer.php"; ?>
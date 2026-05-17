<?php include "header.php"; ?>

<h2>Login</h2>

<?php
if(isset($_SESSION['error'])){

    echo "<p class='error'>".
    htmlspecialchars(
        $_SESSION['error']
    ).
    "</p>";

    unset($_SESSION['error']);
}

if(isset($_SESSION['success'])){

    echo "<p class='success'>".
    htmlspecialchars(
        $_SESSION['success']
    ).
    "</p>";

    unset($_SESSION['success']);
}
?>

<form
method="POST"
action="../controller/loginCheck.php"
onsubmit="return validateLogin()">

<input
type="hidden"
name="csrf_token"
value="<?php echo $_SESSION['csrf_token']; ?>">

<input
type="email"
name="email"
id="loginEmail"
placeholder="Email">

<br><br>

<input
type="password"
name="password"
id="loginPassword"
placeholder="Password">

<br><br>

<input
type="checkbox"
name="remember">
Remember Me

<br><br>

<span
id="loginError"
class="error">
</span>

<br><br>

<input
type="submit"
name="login"
value="Login">

</form>

<br>

<a href="signup.php">
Signup Here
</a>

<?php include "footer.php"; ?>
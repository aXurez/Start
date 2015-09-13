
<?php 
session_start();
include "config.php";

include "PasswordHash.php";
$hasher = new PasswordHash(8, false);

$email = $_POST['email'];
$password = $_POST['password'];
$rememberMe = $_POST['rememberMe'];

$email = mysqli_real_escape_string($con, $email);
$password = mysqli_real_escape_string($con, $password);
$rememberMe = mysqli_real_escape_string($con, $rememberMe);

// Passwords should never be longer than 72 characters to prevent DoS attacks
if (strlen($password) > 72) {
    die(header("Location: index"));
}

// Get all administrators with email as submittet in form 
$get_administrators = mysqli_query($con, "SELECT * FROM `administrators` WHERE `email`='$email'");
$user = mysqli_fetch_array($get_administrators);

// Set stored hash to something always is wrong, then apply an actual encrypted password
$stored_hash = "*";
$stored_hash = $user['password'];

// Check that the password is correct, returns a boolean
$check = $hasher->CheckPassword($password, $stored_hash);

if ($check) {
    if (isset($rememberMe)) {
        setcookie('rememberMe', $email, time() + 31536000);
    }
    $_SESSION['id'] = $user['id'];
    $_SESSION['email'] = $user['email'];

    mysqli_query($con, "UPDATE `administrators` SET `last_login`='$datetime', `reset_code`='' WHERE `email`='$email'");
    header("Location: index.php");
} else {
    header("Location: /index.php");
}
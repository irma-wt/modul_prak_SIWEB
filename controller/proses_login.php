<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if ($username == "irma" && $password == "123") {

    $_SESSION['login'] = true;
    $_SESSION['user']  = $username;

    if (isset($_POST['remember'])) {
        setcookie('username', $username, time() + 3600, "/");

        $key = hash('sha256', $username);
        setcookie('key', $key, time() + 3600, "/");
    } else {
        setcookie('username', '', time() - 3600, "/");
        setcookie('key', '', time() - 3600, "/");
    }

    header("Location: ../index.php");
    exit;

} else {
    header("Location: ../login.php?error=1");
    exit;
}
?>
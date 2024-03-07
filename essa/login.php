<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $query = "SELECT id FROM users WHERE username='$username' and password='$password'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $_SESSION['login_user'] = $username;
            header("location: profile.php");
        } else {
            $error = "Your Login Name or Password is invalid";
        }
    } elseif (isset($_POST['register'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        // Dodaj sprawdzenie istnienia użytkownika i bezpieczniejsze hashowanie haseł
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['login_user'] = $username;
            header("location: profile.php");
        } else {
            $error = "Error registering user";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="login">
    <h2>Login Form</h2>
    <form action="" method="post">
        <label>Username :</label>
        <input id="name" name="username" placeholder="username" type="text">
        <label>Password :</label>
        <input id="password" name="password" placeholder="**********" type="password">
        <input name="login" type="submit" value=" Login ">
        <input name="register" type="submit" value=" Register ">
    </form>
</div>
</body>
</html>

<?php
include 'db.php';
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
}

$username = $_SESSION['login_user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil użytkownika</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="profile">
        <button onclick="location.href='index.php'">Przejdź do strony głównej</button>
        <b id="welcome">Witaj : <i><?php echo $username; ?></i></b>
        <button onclick="location.href='logout.php'">Wyloguj</button>
    </div>
</body>
</html>

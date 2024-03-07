<?php
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // Hashowanie hasła przed zapisaniem do bazy danych
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Sprawdzenie, czy użytkownik już istnieje
    $userCheckQuery = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $userCheckQuery);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            $message = "Username already exists";
        }
    } else {
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$passwordHash')";
        if (mysqli_query($conn, $query)) {
            $message = "Registration successful. You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Error registering user";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="register">
    <h2>Rejestracja</h2>
    <form action="" method="post">
        <label>Nazwa użytkownika:</label>
        <input type="text" name="username" required><br>
        <label>Hasło:</label>
        <input type="password" name="password" required>
        <input type="submit" value="Zarejestruj się">
    </form>
    <?php if ($message) echo "<p>$message</p>"; ?>
</div>
</body>
</html>
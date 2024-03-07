<?php
include 'db.php';
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit;
}

$message = '';

// Obsługa dodawania nowego pomysłu na projekt
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_post'])) {
    $projectIdea = mysqli_real_escape_string($conn, $_POST['projectIdea']);
    $username = $_SESSION['login_user'];

    // Zakładając, że istnieje tabela 'posts' z kolumnami 'id', 'username', 'idea'
    $query = "INSERT INTO posts (username, idea) VALUES ('$username', '$projectIdea')";
    if (mysqli_query($conn, $query)) {
        $message = "Pomysł na projekt został dodany!";
    } else {
        $message = "Nie udało się dodać pomysłu na projekt.";
    }
}

// Pobieranie istniejących pomysłów na projekty
$query = "SELECT * FROM posts ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Strona główna</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="newProjectIdea">
        <h2>Dodaj nowy pomysł na projekt</h2>
        <form action="" method="post">
            <textarea name="projectIdea" placeholder="Opisz swój pomysł na projekt..." required></textarea>
            <input type="submit" name="submit_post" value="Opublikuj">
        </form>
        <?php if ($message) echo "<p>$message</p>"; ?>
    </div>
    <div id="projectIdeas">
        <h2>Pomysły na projekty</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div class='post'>";
                echo "<h3>" . htmlspecialchars($row['username']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['idea']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Brak pomysłów na projekty.</p>";
        }
        ?>
    </div>
</body>
</html>

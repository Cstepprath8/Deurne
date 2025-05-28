<?php
session_start();

// Als gebruiker al is ingelogd via cookies, stel sessie in
if (!isset($_SESSION['loggedin']) && isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === 'true') {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['role'] = $_COOKIE['role'];
    header("Location: index.php");
    exit();
}

// Simulatie van een database met gebruikers
$users = [
    'Daria'    => ['password' => 'Daria8888', 'role' => 'medewerker'],
    'Jan'      => ['password' => 'Jan8888', 'role' => 'medewerker'],
    'Colin'    => ['password' => 'Colin8888', 'role' => 'medewerker'],
    'Sharuyan'=> ['password' => 'Sharuyan8888', 'role' => 'medewerker'],
    'Asherah' => ['password' => 'Asherah8888', 'role' => 'medewerker'],
    'Raymond' => ['password' => 'Raymond8888', 'role' => 'afdelingshoofd'],
];

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check of gebruiker bestaat en wachtwoord klopt
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        // Zet sessievariabelen
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $users[$username]['role'];

        // Zet cookies voor 7 dagen
        $expireTime = time() + (86400 * 7); // 7 dagen
        setcookie('username', $username, $expireTime, "/");
        setcookie('role', $users[$username]['role'], $expireTime, "/");
        setcookie('loggedin', 'true', $expireTime, "/");

        // Ga naar dashboard
        header("Location: index.php");
        exit();
    } else {
        $error = "Onjuiste gebruikersnaam of wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Deurne</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h1>Welkom bij het login scherm van Deurne!</h1>
    <h2>Log in om door te gaan naar het dashboard</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" required>
        <br><br>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <br><br>

        <button type="submit">Inloggen</button>
    </form>
</body>
</html>

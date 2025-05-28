<?php
session_start();

// Sessies leegmaken
$_SESSION = array();

// Verwijder sessie-cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Cookies verwijderen
setcookie("loggedin", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");
setcookie("role", "", time() - 3600, "/");

// Sessie vernietigen
session_destroy();

// Redirect naar login
header("Location: login2.php");
exit();

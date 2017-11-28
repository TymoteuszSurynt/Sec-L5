<?php
session_start();
require_once('connection.php');
$username = $_POST["username"];
$password = $_POST["password"];
$ip = $_SERVER["REMOTE_ADDR"];

if (!($stmt = $mysqli->prepare("SELECT id,password,salt,first_name,last_name FROM users WHERE username like '$username'"))) {
    die ("1Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
}
if (!$stmt->execute()) {
    die ("2Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
}
if (!($res = $stmt->get_result())) {
    die ("3Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
}
if (!$result = $res->fetch_assoc()) {
    header("location:index.php?wronguser=1");
}
$password = $password . $result['salt'];
$hash = hash("sha256", $password);
if (strcmp($result["password"], $hash) !== 0) {
    header("location:index.php?wrongpassword=1");
} else {
    $_SESSION['userid'] = $result['id'];
    $_SESSION['ACTIVITY'] = time();
    header("location:panel.php");
}
$res->close();
?>
<?php
$servername = "127.0.0.1";
$usernamedb = "root";
$passworddb = "1234";
$db = "bankapp";

$mysqli = mysqli_connect($servername, $usernamedb, $passworddb, $db);
unset($passworddb);
if ($mysqli->connect_errno) {
    die ("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
?>

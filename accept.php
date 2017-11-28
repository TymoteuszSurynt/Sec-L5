<?php
session_start();
require_once('connection.php');
if (!$_SESSION['userid']) {
    header("location:index.php?wrongsession=1");
    die();
}

$userid = $_SESSION['userid'];
if (!($stmt = $mysqli->prepare("SELECT rank
FROM users where id like '$userid'"))
) {
	die ("Blad, prosze wróc na poprzednia strone i spróbuj ponownie. Jesli blad sie powtarza prosze sprawdzic polaczenie z internetem i powiadomic administratora");
}
if (!$stmt->execute()) {
	die ("Blad, prosze wróc na poprzednia strone i spróbuj ponownie. Jesli blad sie powtarza prosze sprawdzic polaczenie z internetem i powiadomic administratora");
}
if (!($res = $stmt->get_result())) {
	die ("Blad, prosze wróc na poprzednia strone i spróbuj ponownie. Jesli blad sie powtarza prosze sprawdzic polaczenie z internetem i powiadomic administratora");
}
if ($result = $res->fetch_assoc()) {
} else {
	die ("Blad, prosze wróc na poprzednia strone i spróbuj ponownie. Jesli blad sie powtarza prosze sprawdzic polaczenie z internetem i powiadomic administratora");
}
if($result['rank']!=='admin'){
	header("location:panel.php");
	die();
}

$accept = $_POST["accept"];
$id = $_POST["id"];

if (!($stmt = $mysqli->prepare("CALL accept($id,$accept)"))) {
    die ("Blad, prosze wróc na poprzednia strone i spróbuj ponownie. Jesli blad sie powtarza prosze sprawdzic polaczenie z internetem i powiadomic administratora");
}
if (!$stmt->execute()) {
    die ("Blad, prosze wróc na poprzednia strone i spróbuj ponownie. Jesli blad sie powtarza prosze sprawdzic polaczenie z internetem i powiadomic administratora");
}

header("location:panel.php");

die();
?>
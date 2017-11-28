<?php
session_start();
require_once('connection.php');
if (!$_SESSION['userid']) {
    header("location:index.php?wrongsession=1");
    die();
}
$userid = $_SESSION['userid'];
$name = $_POST["name"];
$address = $_POST["address"];
$accountNumber = $_POST["accountNumber"];
$amount = $_POST["amount"];
$title = $_POST["title"];
if(empty($_POST["name"])|| empty($_POST["accountNumber"]) || empty($_POST["amount"])){
    header("location:transfer.php?error=1");
    die();
}
if(strlen($accountNumber)!=26){
    header("location:transfer.php?error=2");
    die();
}
if(!is_numeric ($amount)){
    header("location:transfer.php?error=3");
    die();
}
if(empty($_POST["address"])){
    $address="";
}
if(empty($_POST["title"])){
    $title = "";
}
$_SESSION['name']=$name;
$_SESSION['address']=$address;
$_SESSION['accountNumber']=$accountNumber;
$_SESSION['amount']=$amount;
$_SESSION['title']=$title;
if (!($stmt = $mysqli->prepare("CALL add_transaction($userid,'$name','$address','$accountNumber',$amount,'$title')"))) {
    die ("1Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
}
if (!$stmt->execute()) {
    die ("2Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
}

header("location:ok.php");
?>
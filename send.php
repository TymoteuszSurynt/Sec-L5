<?php
session_start();
if (!$_SESSION['userid']) {
    header("location:index.php?wrongsession=1");
    die();
} else {
    $_SESSION['title']=null;
    $_SESSION['amount']=null;
    $_SESSION['accountNumber']=null;
    $_SESSION['address']=null;
    $_SESSION['name']=null;
    if (isset($_SESSION['ACTIVITY']) && (time() - $_SESSION['ACTIVITY'] > 1800)) {
        session_unset();
        session_destroy();
        header("location:index.php?sessionout=1");
    }
    if (isset($_SESSION['ACTIVITY']) && (time() - $_SESSION['ACTIVITY'] > 600)) {
        session_regenerate_id(true);
    }
    $_SESSION['ACTIVITY'] = time();
    require_once('connection.php');
    $userid = $_SESSION['userid'];
    if (!($stmt = $mysqli->prepare("SELECT first_name, last_name
	FROM users where id like '$userid'"))
    ) {
        die ("Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
    }
    if (!$stmt->execute()) {
        die ("Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
    }
    if (!($res = $stmt->get_result())) {
        die ("Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
    }
    if ($result = $res->fetch_assoc()) {
    } else {
        die ("Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
    }

}
if(empty($_POST["name"]) || empty($_POST["accountNumber"]) || empty($_POST["amount"])){
    header("location:transfer.php?wrong=1");
    die();
}
$name = $_POST["name"];
$address = $_POST["address"];
$accountNumber = $_POST["accountNumber"];
$amount = $_POST["amount"];
$title = $_POST["title"];
?>
<!DOCTYPE html>
<html>
<head>

    <title>Panel Trustworthy Bank</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script type="text/javascript" src="js/jquery-2.2.4.js"></script>
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="https://zagorski.im.pwr.wroc.pl/courses/sec2017/labor4.pdf">TB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href='transfer.php'>Przelew</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href='logout.php'>Wyloguj</a>
                </li>
            </ul>
            <span class="navbar-text">
                Witaj, <?php echo $result['first_name'] . " " . $result['last_name'] ?>
            </span>
        </div>
    </nav>
    <div class="jumbotron">
        <form name="form1" action='transaction.php' method='POST' id="transactionForm">
            <div class="row" style="margin-top: 10px">
                <div class="col"><label>Nazwa/ Imię i nazwisko:</label></div>
                <div class="col"><input name="name" value="<?php echo $name ?>" class="form-control" readonly></div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col"><label>Adres:</label></div>
                <div class="col"><input name="address"  value="<?php echo $address ?>"class="form-control" readonly></div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col"><label>Numer rachunku odbiorcy:</label></div>
                <div class="col"><input name="accountNumber" value="<?php echo $accountNumber ?>" class="form-control" readonly id="accountNumField2"></div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col"><label>Kwota:</label></div>
                <div class="col"><input class="form-control" name="amount" value="<?php echo $amount ?>"  readonly></div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col"><label>Tytu płatności:</label></div>
                <div class="col"><input name="title" class="form-control" value="<?php echo $title ?>" readonly/>
                </div>
            </div>
            <label>Proszę sprawdzić poprawność danych</label>
            <input type="submit" id="button" class="btn btn-primary offset-md-10" value="Podpisz" style="margin-top: 50px">
        </form>
    </div>


</div>
</body>
</html>
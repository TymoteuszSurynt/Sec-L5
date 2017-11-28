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
    if (!($stmt = $mysqli->prepare("SELECT first_name, last_name, rank FROM users where id like '$userid'"))
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
	if(!isset($_GET['search'])){
	if($result['rank']==='admin'){
		$a="SELECT * FROM user_transfer_view Order by TIMESTAMP DESC";
	}else{
		$a="SELECT *
	FROM user_transfer_view where id like '$userid' Order by TIMESTAMP DESC";
	}
	}else{
		if($result['rank']==='admin'){
		$a="SELECT * FROM user_transfer_view where receiver_name like'%".$_GET['search']."%' Order by TIMESTAMP DESC";
	}else{
		$a="SELECT *
	FROM user_transfer_view where id like '$userid' and receiver_name like'%".$_GET['search']."%' Order by TIMESTAMP DESC";
	}
	echo $a;
	}
    if (!($stmt1 = $mysqli->prepare($a))
    ) {
        die ("Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
    }
    if (!$stmt1->execute()) {
        die ("Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
    }
    if (!($res1 = $stmt1->get_result())) {
        die ("Błąd, proszę wróć na poprzednią stronę i spróbuj ponownie. Jeśli błąd się powtarza proszę sprawdzić połączenie z internetem i powiadomić administratora");
    }

}

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
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href='transfer.php'>Przelew</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href='logout.php'>Wyloguj</a>
                </li>
            </ul>
            <span class="navbar-text" style="margin-right: 20px">
                Witaj <?php 
				if($result['rank']==='admin')
				{
					echo "Panie i Władco ";
				}
				echo ", ".$result['first_name'] . " " . $result['last_name'] ?>
            </span>
			<form class="form-inline my-2 my-lg-0" action="panel.php" method="GET">
			  <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
			  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
        </div>
    </nav>
    <div class="jumbotron">
        <?php
        while ($result1 = $res1->fetch_assoc()) {
            echo "<div class=\"card\">
            <div class=\"card-header\" role=\"tab\" id=\$result1['timestamp']\">
                <h5 class=\"mb-0\">
                    <a data-toggle=\"collapse\" href=\"#" . $result1['tid'] . "\" aria-expanded=\"true\" aria-controls=\"" . $result1['tid'] . "\">
                        Przelew na rzecz: " . $result1['receiver_name'] . " z dnia " . $result1['timestamp'] . ":
                    </a>
                </h5>
            </div>
            <div id=\"" . $result1['tid'] . "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne\" data-parent=\"#accordion\">
                <div class=\"card-body\">
                Data: " . $result1['timestamp'] . "<br><br>
                Dane wysyłającego:<br>
                Numer konta: " . $result1['account_number'] . "<br>
                Imię i nazwisko:" . $result1['first_name'] . " " . $result1['last_name'] . "<br><br>
                Dane odbiorcy:<br>
                Numer konta: " . $result1['receiver_account_number'] . "<br>
                Nazwa/imię i nazwisko: " . $result1['receiver_name'] . "<br>
                Adres: " . $result1['receiver_address'] . "<br><br>
                Tytuł przelewu: " . $result1['title'] . "<br>
                Kwota: " . $result1['amount'] . " zł<br>
				Stan: ";
				if($result1['accepted']==0)
				{
					echo "oczekujący";
				}else{
					echo "zaakceptowany";
				}
			echo "<br>";
				if($result['rank']==='admin'){
					echo "<form action='accept.php' method='POST' id='tForm'>
							<select name='accept' class='custom-select'>
							  <option value='0'" ;
							  if($result1['accepted']==0)
								{
									echo "selected";
								}
							  echo ">Oczekujący</option>
							  <option value='1'";
							  if($result1['accepted']==1)
								{
									echo "selected";
								}
							  echo ">Zatwierdzony</option>
							  
							</select>
							<input hidden name='id' value='" .$result1['tid']."'>
							<input class='btn btn-primary' type='submit' value='Zatwierdź'>
						</form>";
				}
                
            echo "</div>
            </div>
        </div>";
        }
        ?>

    </div>


</div>
</body>
</html>
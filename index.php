<?php
session_start();
if (isset($_SESSION['userid'])) {
    header("location:panel.php");
}
?>
<!DOCTYPE html>
<html>
<head>

    <title>Trustworthy Bank</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script type="text/javascript" src="js/jquery-2.2.4.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</head>
<body>
<div class="center col-xs-12 col-sm-12 col-lg-12 col-xl-12">
    <form action="login.php" method="POST" onsubmit="return checkData();"
          class="center1 well well-lg col-xs-offset-0 col-sm-offset-3 col-md-offset-4 col-lg-offset-4 col-xl-offset-5 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2">
        <h2>Logowanie</h2><br>
        <?php if (isset($_GET['logout'])) {
            echo "<div id='logoutLabel' class='form-group has-success panel panel-success' style='padding: 10px'><label class='control-label panel-title'>Wylogowano poprawnie</label> </div>";
        }
		if (isset($_GET['change'])) {
            echo "<div id='logoutLabel' class='form-group has-success panel panel-success' style='padding: 10px'><label class='control-label panel-title'>Poprawnie zmieniono hasło</label> </div>";
        }
        if (isset($_GET['wrongsession'])) {
            echo "<div class='form-group has-error panel panel-error' style='padding: 10px'><label class='control-label panel-title' id='usernameLabel'>Błąd sesji, proszę zalogować się ponownie</label> </div>";
        }
		if (isset($_GET['num'])) {
            echo "<div class='form-group has-error panel panel-error' style='padding: 10px'><label class='control-label panel-title' id='usernameLabel'>Za dużo prób zalogowania, proszę spróbować za 10 min</label> </div>";
        }
        if (isset($_GET['wrongemail'])) {
            echo "<div class='form-group has-error panel panel-error' style='padding: 10px'><label class='control-label panel-title' id='usernameLabel'>Podano zły lub pusty E-mail</label> </div>";
        }
        if (isset($_GET['sessionout'])) {
            echo "<div class='form-group has-warning panel panel-warning' style='padding: 10px'><label class='control-label panel-title' id='usernameLabel'>Sesja wygasła, proszę zalogować się ponownie</label> </div>";
        }
		if (isset($_GET['time'])) {
            echo "<div class='form-group has-warning panel panel-warning' style='padding: 10px'><label class='control-label panel-title' id='usernameLabel'>Resetowanie hasła wygasło, proszę spróbować ponownie</label> </div>";
        }
        ?>
        <div style='margin:0' class="form-group <?php if (isset($_GET['wronguser'])) {
            echo " has-error";
        } ?>" id="usernameDiv">
            <label class="control-label" id="usernameLabel"><?php if (isset($_GET['wronguser'])) {
                    echo "Zła nazwa użytkownika";
                } ?></label>
            <input type="text" name="username" placeholder="Nazwa użytkownika" class="form-control" id="usernameField">
        </div>
        <div class="form-group <?php if (isset($_GET['wrongpassword'])) {
            echo " has-error";
        } ?>" id="passwordDiv">
            <label class="control-label" id="passwordLabel"><?php if (isset($_GET['wrongpassword'])) {
                    echo "Złe hasło";
                } ?></label>
            <input type="password" name="password" placeholder="Hasło" class="form-control" id="passwordField">
        </div>

        <input type="submit" class="btn btn-primary" value="Zaloguj" style="font-size:120%">
    </form>
</div>
<footer>
    <div>
        <a>©2017 Made by Tymoteusz Surynt.</a>
        <a href="http://glyphicons.com">Created using Glyphicons</a>
        <div>
</footer>
</body>
</html>
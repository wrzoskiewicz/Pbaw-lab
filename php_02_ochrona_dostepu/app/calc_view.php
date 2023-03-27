<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>
<div style="width:90%; margin: 2em ;">
	<a href="<?php print(_APP_ROOT); ?>/app/security/wyloguj.php" class="pure-button pure-button-active">Wyloguj</a>
</div>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
	<label for="id_x">Kwota kredytu: </label>
	<input id="id_x" type="text" name="kwota"/><br />
	<label for="id_x">Procent: </label>
	<input id="id_x" type="text" name="procent"/><br />
	<label for="id_y">Lata: </label>
	<input id="id_y" type="text" name="lata"/><br />
	<input type="submit" value="Oblicz" />
</form>	

<?php
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($wynik)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Wynik: '.$wynik; ?>
</div>
<?php } ?>

</body>
</html>
<?php

include 'Product.php';
include 'functions.php';

session_start();

$selectedProductIds = (array)explode(',', $_GET['ids']);
$multipleProductData = getMultipleSearchedDataFromFile($selectedProductIds, '../data/produkte.csv');
$products = [];
foreach ($multipleProductData as $productData) {
	$products[] = new Product(
		$productData[4],
		$productData[3],
		$productData[0],
		$productData[1],
		$productData[5]
	);
}
$_SESSION['products'] = $products;
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Mieten</title>
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
	<div class="header">
		<div class="logo">
		</div>
		<div class="login">
			<form action="anmeldung.php" method="post" id="login">
				<input name="email" type="text">
				<input name="password" type="text">
				<input type="submit" value="Login">
			</form>
			<div id="session">
				You are logged in.
				<button onclick="window.location.href = '../php/logout.php';">Logout</button>
			</div>
		</div>
		<div class="navigation">
			<a href="../html/index.html">Startseite</a>
			<a href="bildergallery.php">Bildergallerie</a>
			<a href="../html/registrierung.html">Registrierung</a>
		</div>
		<script>
			if (document.cookie.includes('e-go-mobility=loggedIn')) {
				document.getElementById('login').className = 'display-none';
			} else {
				document.getElementById('session').className = 'display-none';
			}
		</script>
	</div>
		<div class='container box-shadow formular'>
			<form action='../php/bestaetigen.php' method='POST' autocomplete="off">
					Folgende Artikel sind ausgewählt:
					<?php foreach ($products as $product): ?>
					<fieldset style="width: 40%; margin: auto">
						<span><?= 'Name: ' . $product->getName() ?></span>
						<span style="width: 50%; display: inline-block">
							<input type="date" name="von<?=$product->getId()?>" placeholder="Von">
						</span><br>
						<span><?= 'Modell: ' . $product->getModel() ?></span>
						<span style="width: 50%; display: inline-block">
							<input type="date" name="bis<?=$product->getId()?>" placeholder="Bis">
						</span><br>
						<span><?= 'Preis: ' . $product->getPrice() . '€' ?></span>
						<span style="width: 50%; display: inline-block">
							<input type="text" name="sz<?=$product->getId()?>" placeholder="Stückzahl">
						</span>
					</fieldset>
					<?php endforeach; ?>
				<fieldset style="width: 70%">
				<div class="feld">
					<input type='text' name="nachname" id='nachname' value="" required>
					<label for='nachname'>Nachname</label>
				</div>
				<div class="feld">
					<input type='text' name="vorname" id='vorname' value="" required>
					<label for='vorname'>Vorname</label>
				</div>
				<div class="feld">
					<input type='email' name='email' id='email' value="" required>
					<label for='email'>Email</label>
				</div>
				<div class="feld">
					<input type='password' name='psw' id='psw' value="" required>
					<label for='psw'>Passwort</label>
				</div>
				<div class="feld">
					<input type='text' name='age' id='age' value="" required>
					<label for='age'>Alter</label>
				</div>
				<div class="row">
					<div class="feld medium">
						<input type='text' name='street' id='street' value="" required>
						<label for='street'>Straße</label>
					</div>
					<div class="feld small">
						<input type='text' name='hausnr' id='hausnr' value="" required>
						<label for='hausnr'>Hausnummer</label>
					</div>
				</div>
				<div class="row">
					<div class="feld medium">
						<input type='text' name='ort' id='ort' value="" required>
						<label for='ort'>Ort</label>
					</div>
					<div class="feld small">
						<input type='text' name='plz' id='plz' value="" required>
						<label for='plz'>Postleitzahl</label>
					</div>
				</div>
				</fieldset>
				<div>
					<button type="submit">mieten</button>
				</div>
			</form>
		</div>
	</body>
</html>

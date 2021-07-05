<?php

include 'Product.php';

var_dump($_POST);
if (!empty($_POST)) {
	die();
}
$selectedProductId = $_GET['id'];
$customerFile = file('../data/produkte.csv');
$products = [];
foreach ($customerFile as $index => $line) {
	if ($index !== 0) {
		$dataArray = (array)explode('|', $line);
		$products[] = new Product(
			$dataArray[4],
			$dataArray[3],
			$dataArray[0],
			$dataArray[1],
			$dataArray[5]
		);
	}
}
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
			<form action='../php/mieten.php' method='POST' autocomplete="off">
				<div>
					<!-- <select name="escooter"> -->
						<?php foreach ($products as $product): ?>
							<p>
							<?php if ($selectedProductId === $product->getId()){
								echo "Ausgewältes Produkt: " . $product->getName();
							} ?>
							</p>
						<?php endforeach; ?>
					<!-- </select> -->
				</div>
				<div>
					<input type='text' name="nachname" id='nachname' value="" required>
					<label for='nachname'>Nachname</label>
				</div>
				<div>
					<input type='text' name="vorname" id='vorname' value="" required>
					<label for='vorname'>Vorname</label>
				</div>
				<div>
					<input type='email' name='email' id='email' value="" required>
					<label for='email'>Email</label>
				</div>
				<div>
					<input type='password' name='psw' id='psw' value="" required>
					<label for='psw'>Passwort</label>
				</div>
				<div>
					<input type='text' name='age' id='age' value="" required>
					<label for='age'>Alter</label>
				</div>
				<div>
					<input type='text' name='street' id='street' value="" required>
					<label for='street'>Straße</label>
				</div>
				<div>
					<input type='text' name='hausnr' id='hausnr' value="" required>
					<label for='hausnr'>Hausnummer</label>
				</div>
				<div>
					<input type='text' name='plz' id='plz' value="" required>
					<label for='plz'>Postleitzahl</label>
				</div>
				<div>
					<input type='text' name='ort' id='ort' value="" required>
					<label for='ort'>Ort</label>
				</div>
				<div>
					<button type="submit">mieten</button>
				</div>
			</form>
		</div>
	</body>
</html>


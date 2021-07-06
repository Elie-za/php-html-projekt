<?php

include 'Product.php';
include 'Customer.php';
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
if (isset($_SESSION['customer']) && isset($_SESSION['password'])) {
	/** @var Customer $customer */
	$customer = $_SESSION['customer'];
}
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Mieten</title>
		<link rel="stylesheet" href="../css/style.css">
		<link rel="icon" href="../images/logo_200x200.png" type="image/gif" sizes="16x16">
	</head>
	<body>
		<div class="header">
			<div class="logo"></div>
			<div class="login">
				<form action="anmeldung.php" method="post" id="login">
					<input placeholder="E-Mail" name="email" type="text">
					<input placeholder="Passwort" name="password" type="password">
					<input type="submit" value="Login">
				</form>
				<div id="session">
					You are logged in.
					<button onclick="window.location.href = '../php/logout.php';">Logout</button>
				</div>
			</div>
			<div class="navigation">
				<a href="../html/index.html">Startseite</a>
				<a href="bildergallery.php">Produkte</a>
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
				<h2>Folgende Artikel sind ausgewählt:</h2>
				<?php foreach ($products as $product): ?>
						<p><?= 'Name: ' . $product->getName() ?></p>
						<p><?= 'Modell: ' . $product->getModel() ?></p>
						<p><?= 'Preis: ' . $product->getPrice() . '€/Tag' ?></p>
						<div class="feld">
							<input type="date" value="" name="von<?=$product->getId()?>" >
							<label>von</label>
						</div>
						<div class="feld">
							<input type="date" value="" name="bis<?=$product->getId()?>" >
							<label>bis</label>
						</div>
						<div class="feld">
							<input pattern="[0-9]+" type="text" value="" name="sz<?=$product->getId()?>" placeholder=" ">
							<label>Stückzahl</label>
						</div>
						<hr/>
				<?php endforeach; ?>
				<h2>Geben Sie die folgenden Daten ein</h2>
				<p>um die Reservierung abzuschließen</p>
					<div class="feld">
						<input type='text' name="nachname" id='nachname' value="<?= empty($customer) ? '' : $customer->getNachname() ?>" placeholder=" " required>
						<label for='nachname'>Nachname</label>
					</div>
					<div class="feld">
						<input type='text' name="vorname" id='vorname' value="<?= empty($customer) ? '' : $customer->getVorname() ?>" placeholder=" " required>
						<label for='vorname'>Vorname</label>
					</div>
					<div class="feld">
						<input type='email' name='email' id='email' value="<?= empty($customer) ? '' : $customer->getEmail() ?>" placeholder=" " required>
						<label for='email'>Email</label>
					</div>
					<div class="feld">
						<input type='password' name='psw' id='psw' value="<?= empty($customer) ? '' : $_SESSION['password'] ?>" placeholder=" " required>
						<label for='psw'>Passwort</label>
					</div>
					<div class="feld">
						<input placeholder=" " type='text' name='age' id='age' value="<?= empty($customer) ? '' : $customer->getAge() ?>" placeholder=" " required>
						<label for='age'>Alter</label>
					</div>
					<div class="row">
						<div class="feld medium">
							<input type='text' name='street' id='street' value="<?= empty($customer) ? '' : $customer->getStreet() ?>" placeholder=" " required>
							<label for='street'>Straße</label>
						</div>
						<div class="feld small">
							<input type='text' name='hausnr' id='hausnr' value="<?= empty($customer) ? '' : $customer->getHouseNumber() ?>" placeholder=" " required>
							<label for='hausnr'>Hausnummer</label>
						</div>
					</div>
					<div class="row">
						<div class="feld medium">
							<input type='text' name='ort' id='ort' value="<?= empty($customer) ? '' : $customer->getPlace() ?>" placeholder=" " required>
							<label for='ort'>Ort</label>
						</div>
						<div class="feld small">
							<input type='text' name='plz' id='plz' value="<?= empty($customer) ? '' : $customer->getZipCode() ?>" placeholder=" " required>
							<label for='plz'>Postleitzahl</label>
						</div>
					</div>
				<div>
					<button type="submit">mieten</button>
				</div>
			</form>
		</div>
		<div class="footer">
			<div>
				E-Go Mobility<br>
				Dudweilerstraße 17<br>
				66111 Saarbrücken<br>
				Deutschland<br>
				Tel.: +49 723 69420
			</div>
			<div>
				<span>Registergericht</span>
				<span>Saarbrücken<br></span>
				<span>Umsatzsteuer-ID:</span>
				<span>DE31415926<br></span>
				<span id="imprint-ceo">Geschäftsführer:</span>
				<span id="imprint-ceo-names">Dr. Acula Graf,<br>Dr. Vivien Agina</span>
			</div>
		</div>
	</body>
</html>

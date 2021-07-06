<?php

include 'Product.php';
include 'Customer.php';
include 'functions.php';

session_start();

if (empty($_POST)) {
	header('Location: /php-html-projekt/html/registrierung.html');
}
$sanitizedData = sanitizeUserInput($_POST, ['email']);

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Rechnungsbestätigung</title>
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
		<div class="box-shadow result">
			<h2>Danke, dass Sie sich für uns entschieden haben!</h2>
			<h4>Bestätigung</h4>
			<div>
				<?php
					$gesamtKosten = 0;
					/** @var Product $product */
					foreach ($_SESSION['products'] as $product):
				?>
					<div>
						<?php
							$fromDate = new DateTime($sanitizedData['von' . $product->getId()]);
							$toDate = new DateTime($sanitizedData['bis' . $product->getId()]);
							$clonedFromDate = clone $fromDate;
							$i = 1;
							while ($clonedFromDate < $toDate) {
								$clonedFromDate->modify('+1 day');
								$i++;
							}
							$kosten = (int)$product->getPrice() * (int)$sanitizedData['sz' . $product->getId()] * $i;
							$gesamtKosten += $kosten;
						?>
						<span>Scootername: </span><span><?= $product->getName() . " " . $product->getModel() ?></span><br/>
						<span>Geliehene Tage: </span><span><?= $i ?></span><br/>
						<span>Von: </span><span><b><?= $fromDate->format('d.m.Y') ?></b></span>
						<span>Bis: </span><span><b><?= $toDate->format('d.m.Y') ?></b></span><br>
						<span>Stückzahl: </span><span><?= (int)$sanitizedData['sz' . $product->getId()] ?></span><br/>
						<span>Mietkosten: </span><b><span><?= $kosten ?> €</b></span><br/><br/>
					</div>
				<?php endforeach; ?>
				<hr/>
				<h4>Gesamtkosten: <?= $gesamtKosten ?> €</h4>
			</div>
			<div>
				<?php if (!empty($_SESSION['customer']) && empty($sanitizedData['email'])): ?>
					<?php
						/** @var Customer $customer */
						$customer = $_SESSION['customer'];
					?>
					<span><b>Ihre Rechnungsadresse:</b></span>
					<span><?= $customer->getVorname() . ' ' . $customer->getNachname() ?></span><br>
					<span><?= $customer->getStreet() . ' ' . $customer->getHouseNumber() ?></span><br>
					<span><?= $customer->getZipCode() . ' ' .  $customer->getPlace() ?></span>
				<?php elseif (empty($_SESSION['consumer']) && !empty($sanitizedData['email'])): ?>
					<?php
						$existingCustomer = getSearchedDataFromFile($sanitizedData['email'], '../data/customer_data.txt');
						if (empty($existingCustomer)) {
							$customer = new Customer(
								$sanitizedData['nachname'],
								$sanitizedData['vorname'],
								['notHashed' => $sanitizedData['psw']],
								$sanitizedData['email'],
								$sanitizedData['street'],
								$sanitizedData['hausnr'],
								$sanitizedData['plz'],
								$sanitizedData['ort'],
								$sanitizedData['age']
							);
							$customer->writeDataIntoFile();
						} else {
							$customer = new Customer(
								$existingCustomer[0],
								$existingCustomer[1],
								['hashed' => $existingCustomer[2]],
								$existingCustomer[3],
								$existingCustomer[4],
								$existingCustomer[5],
								$existingCustomer[6],
								$existingCustomer[7],
								$existingCustomer[8]
							);
						}
						if ($customer->getAge() < 18):
					?>
						<div>
							Es tut uns leid, aber Sie sind leider noch nicht volljährig!<br>
							Sie müssen mindestens 18 Jahre alt sein um einen E-Scooter mieten zu dürfen!
						</div>
					<?php elseif (!$customer->verifyPassword($sanitizedData['psw'])): ?>
						<div>
							Ihr Passwort stimmt nicht mit dem bereits hinterlegten Passwort überein!<br>
							Falls Sie Hilfe benötigen, können Sie uns unter folgender Nummer erreichen +49 723 69420!
						</div>
					<?php else: ?>
						<span><b>Ihre Rechnungsadresse:</b></span><br/>
						<span><?= $customer->getVorname() . ' ' . $customer->getNachname() ?></span><br>
						<span><?= $customer->getStreet() . ' ' . $customer->getHouseNumber() ?></span><br>
						<span><?= $customer->getZipCode() . ' ' .  $customer->getPlace() ?></span>
					<?php endif; ?>
				<?php endif; ?>
			</div>
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

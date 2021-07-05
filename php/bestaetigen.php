<?php

include 'Product.php';
include 'Customer.php';
include 'functions.php';

session_start();

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
		<div class="navigation">
			<a href="../html/index.html">Startseite</a>
			<a href="bildergallery.php">Bildergallerie</a>
			<a href="../html/registrierung.html">Registrierung</a>
		</div>
		<div>
			<div>
				<?php
					$gesamtKosten = 0;
					/** @var Product $product */
					foreach ($_SESSION['products'] as $product):
				?>
					<div style="width: 40%; margin: 10px 0">
						<?php
							$fromDate = new DateTime($_POST['von' . $product->getId()]);
							$toDate = new DateTime($_POST['bis' . $product->getId()]);
							$clonedFromDate = clone $fromDate;
							$i = 1;
							while ($clonedFromDate < $toDate) {
								$clonedFromDate->modify('+1 day');
								$i++;
							}
							$kosten = $product->getPrice() * $_POST['sz' . $product->getId()] * $i;
							$gesamtKosten += $kosten;
						?>
						<span>Name: </span><span><?= $product->getName() ?></span>
						<span>Von: </span><span><?= $fromDate->format('d.m.Y') ?></span><br>
						<span>Modell: </span><span><?= $product->getModel() ?></span>
						<span>Bis: </span><span><?= $toDate->format('d.m.Y') ?></span><br>
						<span>Stückzahl: </span><span><?= $_POST['sz' . $product->getId()] ?></span>
						<span>Geliehene Tage: </span><span><?= $i ?></span><br>
						<span>Preis: </span>
						<span><?= $kosten ?> €</span>
					</div>
				<?php endforeach; ?>
				<div style="width: 40%; border-top: 1px solid black">Gesamtkosten: <?= $gesamtKosten ?> €</div>
			</div>
			<div style="float: right">
				<?php if (!empty($_SESSION['customer']) && empty($_POST['email'])): ?>
					<?php
						/** @var Customer $customer */
						$customer = $_SESSION['customer'];
					?>
					<span>Ihre Rechnungsadresse:</span><br>
					<span><?= $customer->getVorname() . ' ' . $customer->getNachname() ?></span><br>
					<span><?= $customer->getStreet() . ' ' . $customer->getHouseNumber() ?></span><br>
					<span><?= $customer->getZipCode() . ' ' .  $customer->getPlace() ?></span>
				<?php elseif (empty($_SESSION['consumer']) && !empty($_POST['email'])): ?>
					<?php
						$existingCustomer = getSearchedDataFromFile($_POST['email'], '../data/customer_data.txt');
						if (empty($existingCustomer)) {
							$customer = new Customer(
								$_POST['nachname'],
								$_POST['vorname'],
								['notHashed' => $_POST['psw']],
								$_POST['email'],
								$_POST['street'],
								$_POST['hausnr'],
								$_POST['plz'],
								$_POST['ort'],
								$_POST['age']
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
						<?php elseif (!$customer->verifyPassword($_POST['psw'])): ?>
							<div>
								Ihr Passwort stimmt nicht mit dem bereits hinterlegten Passwort überein!<br>
								Falls Sie Hilfe benötigen, können Sie uns unter folgender Nummer erreichen +49 723 69420!
							</div>
						<?php else: ?>
							<span>Ihre Rechnungsadresse:</span><br>
							<span><?= $_POST['vorname'] . ' ' . $_POST['nachname'] ?></span><br>
							<span><?= $_POST['street'] . ' ' . $_POST['hausnr'] ?></span><br>
							<span><?= $_POST['plz'] . ' ' .  $_POST['ort'] ?></span>
						<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>

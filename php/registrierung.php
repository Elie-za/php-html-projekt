<?php

include 'Customer.php';
include 'functions.php';

$customerData = sanitizeUserInput($_POST, ['email']);

$customer = new Customer(
	$customerData['nachname'],
	$customerData['vorname'],
	['notHashed' => $customerData['psw']],
	$customerData['email'],
	$customerData['street'],
	$customerData['hausnr'],
	$customerData['plz'],
	$customerData['ort'],
	$customerData['age']
);

$customerWrittenIntoFile = $customer->writeDataIntoFile();
?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Registrierung <?php if ($customerWrittenIntoFile) { echo 'abgeschlossen'; } else { echo 'fehlgeschlagen'; }?></title>
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
		<div class="header">
			<div class="logo"></div>
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
		<div>
			<?php if ($customerWrittenIntoFile): ?>
				Sie haben sich mit folgenden Daten erfolgreich registriert:<br>
				<?= $customer->getNachname() . ' ' . $customer->getVorname() . '<br>' ?>
				<?= $customer->getEmail() . '<br>' ?>
				<?= $customer->getStreet() . ' ' . $customer->getHouseNumber() . '<br>' ?>
				<?= $customer->getZipCode() . ' ' . $customer->getPlace() . '<br>' ?>
				Vielen Dank für Ihre Unterstützung!
			<?php else: ?>
				<div>
					Leider konnten wir Sie nicht registrieren.<br>
					Prüfen Sie bitte Ihre Anmeldedaten auf Richtigkeit.<br>
				</div>
				<div>
					Bei Fragen können Sie uns unter folgender Mail Adresse erreichen: support@ego.com
				</div>
			<?php endif; ?>
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

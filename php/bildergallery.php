<?php

include 'functions.php';
include 'Product.php';

?>
<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
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
	<div class="container">
		<?php
		$products = [];
		$productImagesDir = new DirectoryIterator('../images/products');
		foreach ($productImagesDir as $directoryContents) {
			if ($directoryContents->isFile()) {
				$productData = getSearchedDataFromFile($directoryContents->getFilename(), '../data/produkte.csv');
				$products[] = new Product(
					$productData[4],
					$productData[3],
					$productData[0],
					$productData[1],
					$productData[5],
					$directoryContents->getPathname()
				);
			}
		}
		?>
		<div class='slide-show'>
			<div class='left box-shadow' onclick='prevDiv()'>&#10094;</div>
			<div class='bilder box-shadow'>
				<?php
				foreach ($products as $product) {
					echo "<div class='beschreibung'>". " Produktname: " . $product->getName() . " ". $product->getModel() . "</div>";
					echo "<div class='mySlides'><label>Dieser Scooter auswählen</label><input class='scooter-checkbox' type='checkbox' id='". $product->getId() ."'><img src='" . $product->getCurrentRelativePath() . "' id='" . $product->getId() . "'/></div>";
					echo "<div class='preis'>". " Mietpreis: <br/>" . $product->getPrice() . " €/Tag" . "</div>";
				}
				?>
			</div>
			<div class='right box-shadow' onclick='nextDiv()'>&#10095;</div>
			<?php

			?>
		</div>
		<div>
			<?php
			for ($i = 0; $i < count($products); $i++) {
				echo "<span class='badge demo' onclick='showDivs($i + 1)'></span>";
			}
			?>
		</div>
		<!-- Eine Javascript Funktion, balbalbal -->
		<button onclick="mieten()">Scooter mieten</button>
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
	<script>
		var slideIndex = 1;
		var x = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("demo");
		var beschreibung = document.getElementsByClassName("beschreibung");
		var preis = document.getElementsByClassName("preis");
		showDivs(slideIndex);

		function hideDivs() {
			for (var i = 0; i < x.length; i++) {
				x[i].className = x[i].className.replace(" animate-left", "").replace(" animate-right", "")
					.replace(" block", "");
				beschreibung[i].className = beschreibung[i].className.replace(" block", "");
				preis[i].className = preis[i].className.replace(" block", "");
			}
			for (var i = 0; i < dots.length; i++) {
				dots[i].className = dots[i].className.replace(" white", "");
			}
		}

		function prevDiv() {
			hideDivs();
			slideIndex -= 1;
			if (slideIndex < 1) {
				slideIndex = x.length
			}
			x[slideIndex - 1].className += " animate-left";
			beschreibung[slideIndex - 1].className += " block";
			preis[slideIndex - 1].className += " block";
			dots[slideIndex - 1].className += " white";
		}

		function nextDiv() {
			hideDivs();
			slideIndex += 1;
			if (slideIndex > x.length) {
				slideIndex = 1
			}
			x[slideIndex - 1].className += " animate-right";
			beschreibung[slideIndex - 1].className += " block";
			preis[slideIndex - 1].className += " block";
			dots[slideIndex - 1].className += " white";
		}

		function showDivs(n) {
			hideDivs();
			if (n > slideIndex) {
				x[n - 1].className += " animate-right";
				beschreibung[n - 1].className += " block";
				preis[n - 1].className += " block";
			}
			if (n === slideIndex) {
				x[n - 1].className += " block";
				beschreibung[n - 1].className += " block";
				preis[n - 1].className += " block";
			}
			if (n < slideIndex) {
				x[n - 1].className += " animate-left";
				beschreibung[n - 1].className += " block";
				preis[n - 1].className += " block";
			}
			dots[n - 1].className += " white";
			slideIndex = n;
		}

		function mieten() {
			let checkboxes = document.getElementsByClassName('scooter-checkbox');
			let checkedIds = [];
			for (let i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].checked === true) {
					checkedIds.push(checkboxes[i].id);
				}
			}
			if (checkedIds.length > 0) {
				window.location.href = '../php/mieten.php?ids=' + checkedIds;
			} else {
				window.location.href = '../php/mieten.php?ids=' + x[slideIndex - 1].getElementsByTagName('IMG')[0].id;
			}
		}
	</script>
</body>

</html>
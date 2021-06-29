<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
		<div class="navigation">
			<a href="../html/index.html">Startseite</a>
			<a href="bildergallery.php">Bildergallerie</a>
			<a href="../html/registrierung.html">Registrierung</a>
		</div>
		<div class="container">
			<?php
				include '../php/functions.php';
		
				$fileName = '../data/produkte.csv';
				$tableArray = csv_to_array($fileName);
		
				echo "<div class='slide-show'>";
				echo    "<div class='left box-shadow' onclick='prevDiv()'>&#10094;</div>";
				echo    "<div class='bilder box-shadow'>";
		
				foreach ($tableArray as $produkt) {
					if($produkt['verfuegbar'] == true){
						echo "<img class='mySlides' src='../images/" . $produkt['picName'].".jpg'/>";
		
					}else{
						echo "<img class='mySlides disabled' src='../images/" . $produkt['picName'].".jpg'/>";
		
					}
				}
				echo     "</div>";
				echo     "<div class='right box-shadow' onclick='nextDiv()'>&#10095;</div>";
				echo "</div>";
				echo "<div class=''>";
		
				foreach ($tableArray as $key => $produkt){
					echo     "<span class='badge demo' onclick='showDivs($key + 1)'></span>";
				}
		
				echo "</div>";
			?>
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
			showDivs(slideIndex);

			function hideDivs() {
				for (var i = 0; i < x.length; i++) {
					x[i].className = x[i].className.replace(" animate-left", "").replace(" animate-right", "")
						.replace(" block", "")
					;
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
				dots[slideIndex - 1].className += " white";
			}

			function nextDiv() {
				hideDivs();
				slideIndex += 1;
				if (slideIndex > x.length) {
					slideIndex = 1
				}
				x[slideIndex - 1].className += " animate-right";
				dots[slideIndex - 1].className += " white";
			}
	
			function showDivs(n) {
				hideDivs();
				if (n > slideIndex) {
					x[n - 1].className += " animate-right";
				}
				if (n === slideIndex) {
					x[n - 1].className += " block"
				}
				if (n < slideIndex) {
					x[n - 1].className += " animate-left";
				}
				dots[n - 1].className += " white";
				slideIndex = n;
			}
		</script>
	</body>
</html>
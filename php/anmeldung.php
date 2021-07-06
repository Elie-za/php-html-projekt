<?php

include 'Customer.php';
include 'functions.php';

session_start();

$customerData = getSearchedDataFromFile($_POST['email'], '../data/customer_data.txt');
if (empty($customerData)) {
	header('Location: /php-html-projekt/html/index.html');
}
$customer = new Customer(
	$customerData[0],
	$customerData[1],
	['hashed' => $customerData[2]],
	$customerData[3],
	$customerData[4],
	$customerData[5],
	$customerData[6],
	$customerData[7],
	$customerData[8]
);
if ($customer->verifyPassword($_POST['password'])) {
	$_SESSION['customer'] = $customer;
	/**
	 * Extra für das Mietformular damit das Passwortfeld ausgefüllt werden kann. Gibt auch
	 * andere Methoden (ausblenden des Feldes, zusätzliches Feld des Customer-Objekts).
	 */
	$_SESSION['password'] = $_POST['password'];
	if (empty($_COOKIE['loggedIn'])) {
		setcookie('e-go-mobility', 'loggedIn', time() + (86400 * 30), '/');
	}
}
redirectToLastPage();

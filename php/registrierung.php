<?php

include 'Customer.php';
include 'functions.php';

$customerData = sanitizeUserInput($_POST, ['email']);

$customer = new Customer(
	$customerData['username'],
	$customerData['psw'],
	$customerData['email'],
	$customerData['street'],
	$customerData['hausnr'],
	$customerData['plz'],
	$customerData['ort'],
	$customerData['age']
);

$customer->writeDataIntoFile();

<?php

include 'Customer.php';
include 'functions.php';

$customerData = sanitizeUserInput($_POST, ['email']);

$customer = new Customer(
	$customerData['username'],
	$customerData['password'],
	$customerData['email'],
	$customerData['street'],
	$customerData['hausnummer'],
	$customerData['postleitzahl'],
	$customerData['ort'],
	$customerData['age']
);

$customer->writeDataIntoFile();

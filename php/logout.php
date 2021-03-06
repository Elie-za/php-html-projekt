<?php

include 'functions.php';

session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}
setcookie("e-go-mobility", 'loggedIn', time() - 3600, '/');
session_destroy();

redirectToLastPage();

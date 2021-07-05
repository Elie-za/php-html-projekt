<?php

include 'functions.php';

session_start();
setcookie("e-go-mobility", 'loggedIn', time() - 3600, '/');
session_destroy();

redirectToLastPage();

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Registration</title>
</head>
<body>
<h1>Registration tests</h1>

<?php
include_once("../models/Messages.class.php");
include_once("../views/MasterView.class.php");
include_once("../views/registrationView.class.php");
include_once("../models/UserData.class.php");
include_once("../models/User.class.php");
?>

<h2>It should show the registration page with valid data</h2>
<?php 
$validUser = array("userName" => "testuser");
$s1 = new User($validUser);
$validUserData = array("firstName" => "Carolyn",
                   "lastName" => "Sanders",
	               "email" => "test@gmail.com"
                   //"gender" => "female",
				   //"birthDate" => "2015-06-05",
				   //"phoneNumber" => "1234567890"
);
$s2 = new UserData($validUserData);
$_SESSION['user'] = $s1;
$_SESSION['userData'] = $s2;
$_SESSION['base'] = null;
registrationView::show();
?>

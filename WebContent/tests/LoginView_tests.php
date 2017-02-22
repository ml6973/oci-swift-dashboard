<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Login View</title>
</head>
<body>
<h1>Login view tests</h1>

<?php
include_once("../views/MasterView.class.php");
include_once("../views/loginView.class.php");
include_once("../models/User.class.php");
include_once("../models/Messages.class.php");
?>

<h2>It should call show when $user has an input</h2>
<?php 
$validTest = array("userName" => "testuser");
$s1 = new User($validTest);
$_SESSION['user'] = $s1;
$_SESSION['base'] = null;
LoginView::show();
?>
</body>
</html>

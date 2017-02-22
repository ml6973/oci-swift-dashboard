<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Home View</title>
</head>
<body>
<h1>Home view tests</h1>

<?php
include_once("../views/homeView.class.php");
include_once("../views/MasterView.class.php");
include_once("../models/User.class.php");
include_once("../models/Messages.class.php");
?>

<h2>It should call show to show the homepage, regardless is $user has input</h2>
<?php 
$validTest = array("userName" => "ghooks", "password" => "test");
$s1 = new User($validTest);
homeView::show($s1);
?>
</body>
</html>

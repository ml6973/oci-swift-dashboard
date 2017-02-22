<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for UserDataDB</title>
</head>
<body>
<h1>UserDataDB tests</h1>


<?php
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/User.class.php");
include_once("../models/UserData.class.php");
include_once("../models/UsersDB.class.php");
include_once("../models/UserDataDB.class.php");
include_once("./makeDB.php");
?>

<h2>It should get all userdata from a test database</h2>
<?php
makeDB('ptest_swift'); 
Database::clearDB();
$db = Database::getDB('ptest_swift');
$userdatas = UserDataDB::getUserDataBy();
$userdataCount = count($userdatas);
echo "Number of userdatas in db is: $userdataCount <br>";
foreach ($userdatas as $userdata) 
	echo "$userdata <br>";
?>	
	

<h2>It should allow a userdata to be added</h2>
<?php 
echo "Number of userdata in db before added is: ". count(UserDataDB::getUserDataBy()) ."<br>";
$validTest = array("userName" => "blahuser", "password" => "123");
$user = new User($validTest);
$validTest = array("email" => "test@gdail.com");
$userdata = new UserData($validTest);
$userId = UsersDB::addUser($user);
$user->setUserId($userId);
UserDataDB::addUserData($user, $userdata);
echo "Number of users in db after added is: ". count(UserDataDB::getUserDataBy()) ."<br>";
echo "User ID of new user is: $userId<br>";
?>

<h2>It should not add invalid userdata</h2>
<?php 
echo "Number of userdata in db before added is: ". count(UserDataDB::getUserDataBy()) ."<br>";
$user = new User($validTest);
$validTest = array("email" => "test@gdail.com");
$invalidUserData = new UserData(array("email" => "test"));
$userId = UserDataDB::addUserData($user, $invalidUserData);
echo "Number of users in db after added is: ". count(UserDataDB::getUserDataBy()) ."<br>";
echo "User ID of new user is: $userId<br>";
?>

<h2>It should get a Userdata by userId</h2>
<?php 
$userdata = UserDataDB::getUserDataBy('userId', '5');
echo "The value of UserData 5 is:<br>$userdata[0]<br>";
?>

<h2>It should not get a Userdata not in Userdata</h2>
<?php 
$userdata = UserDataDB::getUserDataBy('userId', '30');
if (empty($userdata))
	echo "No UserData 30";
else echo "The value of UserData is:<br>$userdata[0]<br>";
?>

<h2>It should allow a userdata to be updated</h2>
<?php 
$userdata = UserDataDB::getUserDataBy('userId', '5');
echo "The value of UserData 5 is:<br>$userdata[0]<br>";
$user = UsersDB::getUsersBy('userId', '5')[0];
$user->setUserId('5');
$validTest = array("email" => "fixedemail@gdail.com");
$userdata = new UserData($validTest);
UserDataDB::updateUserData($user, $userdata);
$userdata = UserDataDB::getUserDataBy('userId', '5');
echo "The value of UserData 5 after change is:<br>$userdata[0]<br>";
?>

</body>
</html>
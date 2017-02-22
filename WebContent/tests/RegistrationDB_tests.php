<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for UsersDB</title>
</head>
<body>
<h1>UsersDB tests</h1>


<?php
include_once("../models/Database.class.php");
include_once("../models/RegistrationDB.class.php");
include_once("./makeDB.php");
?>


<h2>It should get a true registration value from the database</h2>
<?php
makeDB('ptest'); 
Database::clearDB();
$db = Database::getDB('ptest');
$value = RegistrationDB::getRegistrationRowSetsBy('userId', 4);
print_r($value);
?>	

<h2>It should get a false registration value from the database</h2>
<?php
makeDB('ptest'); 
Database::clearDB();
$db = Database::getDB('ptest');
$value = RegistrationDB::getRegistrationRowSetsBy('userId', 3);
print_r($value);
?>	

<h2>It should return false for a non-existant userId</h2>
<?php
makeDB('ptest'); 
Database::clearDB();
$db = Database::getDB('ptest');
$value = RegistrationDB::getRegistrationRowSetsBy('userId', 30);
print_r($value);
?>	

</body>
</html>
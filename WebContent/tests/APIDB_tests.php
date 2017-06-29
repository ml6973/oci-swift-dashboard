<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for APIDB</title>
</head>
<body>
<h1>API DB tests</h1>


<?php
include_once("../models/Database.class.php");
include_once("../models/APIDB.class.php");
include_once("./makeDB.php");
?>


<h2>It should get a true registration value from the database</h2>
<?php
makeDB('ptest_swift_dashboard'); 
Database::clearDB();
$db = Database::getDB('ptest_swift_dashboard');
$value = APIDB::getAPIBy('apiId', 1);
print_r($value);
echo "<br><br><br>";
$value2 = APIDB::getAPIBy('description', $value);
print_r($value2);
echo "<br><br><br>";
$value3 = APIDB::getAPIBy();
print_r($value3);
?>

</body>
</html>
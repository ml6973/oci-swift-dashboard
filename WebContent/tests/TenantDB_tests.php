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
include_once("../models/TenantDB.class.php");
include_once("./makeDB.php");
?>


<h2>It should get a true registration value from the database</h2>
<?php
makeDB('ptest_swift_dashboard'); 
Database::clearDB();
$db = Database::getDB('ptest_swift_dashboard');
$value = TenantDB::getTenantsBy('userId', 4);
print_r($value);
echo "<br><br><br>";
$value2 = TenantDB::getTenantListBy('tenantId', $value);
print_r($value2);
echo "<br><br><br>";
$value2 = TenantDB::getTenantListBy('tenantId', $value, 0);
print_r($value2);
?>

</body>
</html>
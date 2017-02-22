<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>OCI SWIFT tests</h1>

<?php
include_once("../models/OCI_SWIFT.class.php");
include_once("../models/User.class.php");
include_once("../models/UserData.class.php");
include_once("../models/Messages.class.php");

set_time_limit(120);
?>

<h2>It should retrieve a list of containers for a user</h2>
<?php 

$containers = OCI_SWIFT::getContainers("");
foreach ($containers as $container) {
	echo $container['name'];
	echo '<br>';
}

?>

<h2>It should retrieve a list of objects in a container</h2>
<?php 

$containers = OCI_SWIFT::getContainers("");
$container = $containers[0];
$objects = OCI_SWIFT::getObjects("CH-818640", $container['name']);
foreach ($objects as $object){
	echo $object['name'];
	echo '<br>';
}

?>

<h2>It should throw an error for an incorrect tenant</h2>
<?php 

$containers = OCI_SWIFT::getContainers("garbageTenant");
if (is_null($containers))
	echo "Auth Failure";

?>

</body>
</html>


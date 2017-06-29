<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>API GET tests</h1>

<?php
include_once("../models/API_GET.class.php");
include_once("../models/APIDB.class.php");
include_once("../models/Database.class.php");
include_once("../models/User.class.php");
include_once("../models/UserData.class.php");
include_once("../models/Messages.class.php");

set_time_limit(120);
?>

<h2>It should retrieve a list of all apis</h2>
<?php 

$apis = API_GET::getAPIs();
foreach ($apis as $api) {
	print_r($api);
	echo '<br>';
}

?>

<h2>It should retrieve a single api</h2>
<?php 

$apis = API_GET::getAPIs("1");
foreach ($apis as $api) {
	print_r($api);
	echo '<br>';
}

?>

<h2>It should get an image from an api</h2>
<?php 

$test = file_get_contents("../resources/siteImages/classRoom.jpg", "r");
$response = API_GET::getImage("1", $test);
$response = base64_encode($response);
echo "<img src='data:image/jpeg;base64, $response' />";

?>

</body>
</html>


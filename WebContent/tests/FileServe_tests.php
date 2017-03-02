<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>OCI SWIFT tests</h1>

<?php
include_once("../models/OCI_SWIFT.class.php");
include_once("../models/FileServe.class.php");
include_once("../models/User.class.php");
include_once("../models/UserData.class.php");
include_once("../models/Messages.class.php");

set_time_limit(120);
?>

<h2>The following link should download something</h2>
<?php 

$tenentId = base64_encode("CH-818640");
$objectPath = base64_encode("test-container/processed/Untitles.txt");
echo 'http://localhost/oci-swift-dashboard/fileserve?'.$tenentId."&".$objectPath;
//FileServe::run($tenentId, $objectPath);

echo '<a></a>';

?>

</body>
</html>


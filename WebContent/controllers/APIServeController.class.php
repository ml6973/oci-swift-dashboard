<?php
class APIServeController {
	public static function run() {
		if (!is_null((array_key_exists('authenticatedUser', $_SESSION))?
		$_SESSION['authenticatedUser']:null)) {
			if (!is_null((array_key_exists('registered', $_SESSION))?
			$_SESSION['registered']:null) && $_SESSION['registered'] == 1){
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if (isset($_POST['apiId']) && isset($_POST['file'])) {
						$apiId = $_POST['apiId'];
						$file = $_POST['file'];
						$apis = API_GET::getAPIs($apiId);
						if (!is_null($apis) && (count($apis) == 1)) {
							$apiType = $apis[0]['apiType'];
							$file = base64_decode($file);
							APIServe::run($apiId, $apiType, $file);
						} else {
							return null;
						}
					}
				}
			}else{
				header('Location: /'.$_SESSION['base'].'/registrationComplete');
			}
		} else {
			header('Location: /'.$_SESSION['base'].'/login');
		}
	}
}
?>
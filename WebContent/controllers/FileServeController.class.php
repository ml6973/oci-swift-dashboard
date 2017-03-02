<?php
class FileServeController {
	public static function run() {
		if (!is_null((array_key_exists('authenticatedUser', $_SESSION))?
		$_SESSION['authenticatedUser']:null)) {
			if (!is_null((array_key_exists('registered', $_SESSION))?
			$_SESSION['registered']:null) && $_SESSION['registered'] == 1){
				$parsed = parse_url($_SERVER['REQUEST_URI']);
				if (is_null((array_key_exists('query', $parsed))?$parsed['query']:null)) {
					header('Location: /'.$_SESSION['base'].'/viewfiles');
				}
				$parsed = explode('&', $parsed["query"]);
				if (count($parsed) != 2) {
					header('Location: /'.$_SESSION['base'].'/viewfiles');
				}else{
					$tenant = $parsed[0];
					$objectPath = $parsed[1];
				}
				$tenants = TenantDB::getTenantsBy('userId', $_SESSION['authenticatedUser']->getUserId());
				if (in_array(base64_decode($tenant), $tenants)) {
					FileServe::run($tenant, $objectPath);
				}else {
					header('Location: /'.$_SESSION['base'].'/viewfiles');
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
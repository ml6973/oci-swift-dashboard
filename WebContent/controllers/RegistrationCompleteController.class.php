<?php
class RegistrationCompleteController {

	public static function run() {
		
		if (!is_null((array_key_exists('authenticatedUser', $_SESSION))?
		$_SESSION['authenticatedUser']:null)){
			$_SESSION['registered'] = RegistrationDB::getRegistrationRowSetsBy('userId', $_SESSION['authenticatedUser']->getUserId());
			if (!is_null((array_key_exists('registered', $_SESSION))?
			$_SESSION['registered']:null) && $_SESSION['registered'] == 1){
				header('Location: /'.$_SESSION['base'].'/viewfiles');
			}else{
				registrationCompleteView::show();
			}
		}else{
			header('Location: /'.$_SESSION['base'].'/login');
		}
	}
}
?>
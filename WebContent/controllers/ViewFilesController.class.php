<?php
class ViewFilesController {
	public static function run() {
		if (!is_null((array_key_exists('authenticatedUser', $_SESSION))?
		$_SESSION['authenticatedUser']:null)) {
			if (!is_null((array_key_exists('registered', $_SESSION))?
			$_SESSION['registered']:null) && $_SESSION['registered'] == 1){
				ViewFilesView::show();
			}else{
				header('Location: /'.$_SESSION['base'].'/registrationComplete');
			}
		} else {
			header('Location: /'.$_SESSION['base'].'/login');
		}
	}
}
?>
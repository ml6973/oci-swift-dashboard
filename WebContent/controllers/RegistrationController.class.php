<?php
class RegistrationController {

	public static function run() {
		if (!is_null((array_key_exists('authenticatedUser', $_SESSION))?
		$_SESSION['authenticatedUser']:null)){
			if (!is_null((array_key_exists('registered', $_SESSION))?
			$_SESSION['registered']:null) && $_SESSION['registered'] == 1){
				header('Location: /'.$_SESSION['base'].'/viewfiles');
			}else{
				header('Location: /'.$_SESSION['base'].'/registrationComplete');
			}
		}
		$user = null;
		$userData = null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$user = new User($_POST);
			$userData = new UserData($_POST);
			$users = UsersDB::getUsersBy('userName', $user->getUserName());
			if (!empty($users))
				$user->setError('userName', 'USER_NAME_ALREADY_EXISTS');
			
			if (strcmp(RegistrationController::extractForm($_POST, "password"), RegistrationController::extractForm($_POST, "password_confirm")))
				$user->setError('password', 'PASSWORD_MISMATCH');
			
			
			
			$_SESSION['user'] = $user;
			$_SESSION['userData'] = $userData;
			
			if ($user->getErrorCount() == 0 && $userData->getErrorCount() == 0) {
				$userId = UsersDB::addUser($user);
				$user->setUserId($userId);
				UserDataDB::addUserData($user, $userData);
				$_SESSION['authenticatedUserData'] = $userData;
				$_SESSION['authenticatedUser'] = $user;
				RegistrationDB::addRegistration($user);
				header('Location: /'.$_SESSION['base'].'/viewfiles');
			} else  
				registrationView::show($user, $userData);
		} else {  // Initial link
			$_SESSION['user'] = null;
			$_SESSION['userData'] = null;
			registrationView::show();
		}
	}
	
	protected function extractForm($formInput, $valueName) {
		// Extract a stripped value from the form array
		$value = "";
		if (isset($formInput[$valueName])) {
			$value = trim($formInput[$valueName]);
			$value = stripslashes ($value);
			$value = htmlspecialchars ($value);
			return $value;
		}
	}
}
?>
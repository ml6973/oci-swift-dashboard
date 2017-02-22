<?php
class FinishRegistrationController {

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
			$userPost = null;
			$userDataPost = null;
			if ((!is_null((array_key_exists('user', $_SESSION))?
					$_SESSION['user']:null)) && (!is_null((array_key_exists('userData', $_SESSION))?
					$_SESSION['userData']:null))){
				$userPost = $_POST;
				$userDataPost = $_POST;
				$userPost['userName'] = $_SESSION['user']->getUserName();
				$userDataPost['email'] = $_SESSION['userData']->getEmail();
			}else{
				header('Location: /'.$_SESSION['base'].'/login');
			}
			$user = new User($userPost);
			$userData = new UserData($userDataPost);
			$users = UsersDB::getUsersBy('userName', $user->getUserName());
			if (empty($users))
				header('Location: /'.$_SESSION['base'].'/login');
			
			$formUser = $user;
			$user = $users[0];
			$formUser->setUserId($user->getUserId());
			$user->resetErrors();
			$_SESSION['user'] = $formUser;
			$_SESSION['userData'] = $userData;
			
			if (strcmp(FinishRegistrationController::extractForm($_POST, "password"), FinishRegistrationController::extractForm($_POST, "password_confirm")))
				$formUser->setError('password', 'PASSWORD_MISMATCH');
			
			if ($user->getErrorCount() == 0 && $formUser->getErrorCount() == 0 && $userData->getErrorCount() == 0) {
				UsersDB::updateUser($formUser);
				UserDataDB::updateUserData($user, $userData);
				$_SESSION['authenticatedUserData'] = $userData;
				$_SESSION['authenticatedUser'] = $user;
				RegistrationDB::addRegistration($users[0]);
				header('Location: /'.$_SESSION['base'].'/viewfiles');
			} else  
				RegistrationFinishView::show($user, $userData);
		} else {  // Initial link
			$_SESSION['user']->resetErrors();
			$_SESSION['userData']->resetErrors();
			RegistrationFinishView::show();
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
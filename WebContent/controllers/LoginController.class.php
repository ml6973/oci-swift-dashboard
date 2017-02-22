<?php
class LoginController {

	public static function run() {
		if (!is_null((array_key_exists('authenticatedUser', $_SESSION))?
		$_SESSION['authenticatedUser']:null)){
			$_SESSION['registered'] = RegistrationDB::getRegistrationRowSetsBy('userId', $_SESSION['authenticatedUser']->getUserId());
			if (!is_null((array_key_exists('registered', $_SESSION))?
			$_SESSION['registered']:null) && $_SESSION['registered'] == 1){
				header('Location: /'.$_SESSION['base'].'/viewfiles');
			}else{
				header('Location: /'.$_SESSION['base'].'/registrationComplete');
			}
		}
		$user = null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			print_r(" "); //fixes connection reset on login?
			$user = new User($_POST);  
			$users = UsersDB::getUsersBy('userName', $user->getUserName());
			if (empty($users))
				$user->setError('userName', 'USER_NAME_DOES_NOT_EXIST');
			else {
				if (strcmp($user->getPasswordHash(), $users[0]->getPasswordHash()) != 0)
				if (!$user->verifyPassword($users[0]->getPasswordHash()))
					$user->setError('password', 'PASSWORD_INCORRECT');
				else
					$user = $users[0];
			}
		}
		$_SESSION['user'] = $user;
		if (is_null($user) || $user->getErrorCount() != 0) {
			loginView::show($user);
		} else {
			$userData = UserDataDB::getUserDataBy('userId', $user->getUserId());
			$userData[0]->resetErrors();
			/*if (is_null($userData[0]->getVMPassword())) {
				$_SESSION['user'] = $users[0];
				$_SESSION['userData'] = $userData[0];
				$_SESSION['authenticatedUserData'] = null;
				$_SESSION['authenticatedUser'] = null;
				header('Location: /'.$_SESSION['base'].'/finishRegistration');
			}else{*/
				$_SESSION['authenticatedUserData'] = $userData[0];
				$_SESSION['authenticatedUser'] = $user;
	    		header('Location: /'.$_SESSION['base'].'/viewfiles');
			//}
	    }
	}
}
?>
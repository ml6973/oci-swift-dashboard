<?php
class User {
	private $errorCount;
	private $errors;
	private $formInput;
	private $userName;
	private $password;
	private $passwordHash;
	private $userId;
	
	public function __construct($formInput = null) {
		$this->formInput = $formInput;
		Messages::reset();
		$this->initialize();
	}

	public function getError($errorName) {
		if (isset($this->errors[$errorName]))
			return $this->errors[$errorName];
		else
			return "";
	}

	public function setError($errorName, $errorValue) {
		// Sets a particular error value and increments error count
		$this->errors[$errorName] =  Messages::getError($errorValue);
		$this->errorCount ++;
	}

	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}
	
	public function getPasswordHash() {
		return $this->passwordHash;
	}

	public function getUserName() {
		return $this->userName;
	}
	
	public function getUserId() {
		return $this->userId;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("userName" => $this->userName, "passwordHash" => $this->passwordHash); 
		return $paramArray;
	}
	
	public function setUserId($id) {
		// Set the value of the userId to $id
		$this->userId = $id;
	}

	public function __toString() {
		$str = "User name: ".$this->userName." PasswordHash: ".$this->passwordHash;
		return $str;
	}
	
	public function verifyPassword($hash) {
		// Set the value of passwordHash to hash
		return password_verify($this->password, $hash);
	}
	
	private function extractForm($valueName) {
		// Extract a stripped value from the form array
		$value = "";
		if (isset($this->formInput[$valueName])) {
			$value = trim($this->formInput[$valueName]);
			$value = stripslashes ($value);
			$value = htmlspecialchars ($value);
			return $value;
		}
	}
	
	private function initialize() {
		$this->errorCount = 0;
		$errors = array();
		if (is_null($this->formInput))
			$this->initializeEmpty();
		else  	 
		   $this->validateUserName();
		   $this->validatePassword();
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
	 	$this->userName = "";
	 	$this->password = "";
	 	$this->passwordHash = "";
	}
	
	public function resetErrors() {
		$this->errorCount = 0;
		$this->errors = array();
	}

	private function validateUserName() {
		// Username should only contain letters, numbers, dashes and underscore
		$this->userName = $this->extractForm('userName');
		if (empty($this->userName))
			$this->setError('userName', 'USER_NAME_EMPTY');
		elseif (!filter_var($this->userName, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^([a-zA-Z0-9\-\_])+$/i")) )) {
			$this->setError('userName', 'USER_NAME_HAS_INVALID_CHARS');
			$this->errorCount ++;
		}
	}
	
	private function validatePassword() {
		// Password should not be blank
		if (isset($this->formInput['password'])) {
			$this->password = $this->extractForm('password');
			$this->passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
			if (empty($this->password))
				$this->setError('password', 'PASSWORD_EMPTY');
			 
		} elseif (isset($this->formInput['passwordHash'])) {
			$this->passwordHash =  $this->formInput['passwordHash'];
		} else
			$this->setError('password', 'USER_PASSWORD_INCORRECT');
	}
}
?>
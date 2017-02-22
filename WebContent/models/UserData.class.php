<?php
class UserData {
	private $errorCount;
	private $errors;
	private $formInput;
	private $email;
	
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
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("email" => $this->email
		); 
		return $paramArray;
	}

	public function __toString() {
		$str = "email:[" .$this->email ."] ";
		return $str;
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
		else  {	 
	      $this->validateEmail();
		}	
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
		$errors = array();
		$this->email = "";
	}

	public function resetErrors() {
		$this->errorCount = 0;
		$this->errors = array();
	}

	
	private function validateEmail() {
		// Email should not have quoted characters
		$this->email = $this->extractForm('email');
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$this->setError('email', 'EMAIL_INVALID');
		}
	}
}
?>
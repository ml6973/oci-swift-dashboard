<?php
class UserDataDB {
	
	public static function addUserData($user, $userdata) {
		// Inserts the User object $userdata into the Users table and returns userId
		$query = "INSERT INTO UserData (userId, email)
		                      VALUES(:userId, :email)";
		$returnId = 0;
		try {
			if (is_null($userdata) || $userdata->getErrorCount() > 0 || is_null($user) || $user->getErrorCount() > 0)
				throw new PDOException("Invalid Userdata object can't be inserted");
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":userId", $user->getUserId());
			$statement->bindValue(":email", $userdata->getEmail());
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error adding userdata to UserData ".$e->getMessage()."</p>";
		}
		$returnId = $user->getUserId();
		return $returnId;
	}
	
	public static function updateUserData($user, $userdata) {
		// Removes userData by 
		$query = "UPDATE UserData SET email= :email WHERE userId = :userId";
		$returnId = 0;
		try {
			if (is_null($userdata) || $userdata->getErrorCount() > 0 || is_null($user) || $user->getErrorCount() > 0)
				throw new PDOException("Invalid Userdata object can't be inserted");
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":userId", $user->getUserId());
			$statement->bindValue(":email", $userdata->getEmail());
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error adding userdata to UserData ".$e->getMessage()."</p>";
		}
		$returnId = $user->getUserId();
		return $returnId;
	}

	public static function getUserDataRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["userId"];
		$userdataRowSets = NULL;
		try {
			$db = Database::getDB ();
			$query = "SELECT userId, email FROM UserData";
			if (!is_null($type)) {
			    if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Userdata");
			    $query = $query. " WHERE ($type = :$type)";
			    $statement = $db->prepare($query);
			    $statement->bindParam(":$type", $value);
			} else 
				$statement = $db->prepare($query);
			$statement->execute ();
			$userdataRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting user rows by $type: " . $e->getMessage () . "</p>";
		}
		return $userdataRowSets;
	}
	
	public static function getUserDataArray($rowSets) {
		// Returns an array of User objects extracted from $rowSets
		$userdatas = array();
	 	if (!empty($rowSets)) {
			foreach ($rowSets as $userdataRow ) {
				$userdata = new UserData($userdataRow);
				//$userdata->setUserId($userdataRow['userId']);
				array_push ($userdatas, $userdata );
			}
	 	}
		return $userdatas;
	}
	
	public static function getUserDataBy($type=null, $value=null) {
		// Returns User objects whose $type field has value $value
		$userdataRows = UserDataDB::getUserDataRowSetsBy($type, $value);
		return UserDataDB::getUserDataArray($userdataRows);
	}
	
	public static function getUserDataValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$userdataValues = array();
		foreach ($rowSets as $userdataRow )  {
			$userdataValue = $userdataRow[$column];
			array_push ($userdataValues, $userdataValue);
		}
		return $userdataValues;
	}
	
	public static function getUserDataValuesBy($column, $type=null, $value=null) {
		// Returns the $column of Users whose $type field has value $value
		$userdataRows = UserDataDB::getUserDataRowSetsBy($type, $value);
		return UserDataDB::getUserDataValues($userdataRows, $column);
	}
}
?>
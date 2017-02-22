<?php
class RegistrationDB {
	
	public static function addRegistration($user) {
		// Inserts the User object $userdata into the Users table and returns userId
		$query = "INSERT INTO Registration (userId, complete)
		                      VALUES(:userId, :complete)";
		$returnId = 0;
		try {
			if (is_null($user) || $user->getErrorCount() > 0)
				throw new PDOException("Invalid User object can't be inserted");
			$db = Database::getDB ();
			$statement = $db->prepare ($query);
			$statement->bindValue(":userId", $user->getUserId());
			$statement->bindValue(":complete", false);
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error adding registration to Registration ".$e->getMessage()."</p>";
		}
		$returnId = $user->getUserId();
		return $returnId;
	}

	public static function getRegistrationRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["userId"];
		$registrationRowsets = NULL;
		try {
			$db = Database::getDB ();
			$query = "SELECT complete FROM Registration";
			if (!is_null($type)) {
			    if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Registration");
			    $query = $query. " WHERE ($type = :$type)";
			    $statement = $db->prepare($query);
			    $statement->bindParam(":$type", $value);
			} else 
				$statement = $db->prepare($query);
			$statement->execute ();
			$registrationRowsets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting registration rows by $type: " . $e->getMessage () . "</p>";
		}
		if (array_key_exists(0, $registrationRowsets) && array_key_exists('complete', $registrationRowsets[0]))
			return (int) $registrationRowsets[0]['complete'];
		else
			return (int) 0;
	}
}
?>
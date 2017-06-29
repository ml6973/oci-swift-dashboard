<?php
class APIDB {
	
	public static function getAPIRowSetsBy($type = null, $value = null) {
		// Returns the rows of APIs whose $type field has value $value
		$allowedTypes = ["apiId", "apiName", "apiType", "apiUrl"];
		$apiRowsets = NULL;
		try {
			$db = Database::getDB ();
			$query = "SELECT apiId, apiName, apiType, apiUrl, apiUser, apiPass, description FROM APIs";
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for API");
					$query = $query. " WHERE ($type = :$type)";
					$statement = $db->prepare($query);
					$statement->bindParam(":$type", $value);
			} else
				$statement = $db->prepare($query);
				$statement->execute ();
				$apiRowsets = $statement->fetchAll(PDO::FETCH_ASSOC);
				$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting tenant rows by $type: " . $e->getMessage () . "</p>";
		}
		return $apiRowsets;
	}
	
	public static function getAPIArray($rowSets) {
		// Returns an array of APIs extracted from $rowSets
		$apis = array();
		if (!empty($rowSets)) {
			foreach ($rowSets as $apiRow ) {
				array_push ($apis, array("apiId" => $apiRow['apiId'], "apiName" => $apiRow['apiName'], "apiType" => $apiRow['apiType'], "apiUrl" => $apiRow['apiUrl'], "apiUser" => $apiRow['apiUser'], "apiPass" => $apiRow['apiPass'], "description" => $apiRow['description']));
			}
		}
		return $apis;
	}
	
	public static function getAPIBy($type=null, $value=null) {
		// Returns APIs whose $type field has value $value
		$apiRows = APIDB::getAPIRowSetsBy($type, $value);
		return APIDB::getAPIArray($apiRows);
	}
}
?>
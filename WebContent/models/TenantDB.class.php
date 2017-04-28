<?php
class TenantDB {
	
	public static function getTenantRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["userId"];
		$tenantRowsets = NULL;
		try {
			$db = Database::getDB ();
			$query = "SELECT tenantId FROM Tenants";
			if (!is_null($type)) {
			    if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Tenant");
			    $query = $query. " WHERE ($type = :$type)";
			    $statement = $db->prepare($query);
			    $statement->bindParam(":$type", $value);
			} else 
				$statement = $db->prepare($query);
			$statement->execute ();
			$tenantRowsets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting tenant rows by $type: " . $e->getMessage () . "</p>";
		}
		return $tenantRowsets;
	}
	
	public static function getTenantsArray($rowSets) {
		// Returns an array of Tenants extracted from $rowSets
		$tenants = array();
		if (!empty($rowSets)) {
			foreach ($rowSets as $tenantRow ) {
				array_push ($tenants, $tenantRow['tenantId'] );
			}
		}
		return $tenants;
	}
	
	public static function getTenantsBy($type=null, $value=null) {
		// Returns Tenants whose $type field has value $value
		$tenantRows = TenantDB::getTenantRowSetsBy($type, $value);
		return TenantDB::getTenantsArray($tenantRows);
	}
	
	public static function getTenantListRowSetsBy($type = null, $value = null) {
		// Returns the rows of Users whose $type field has value $value
		$allowedTypes = ["tenantId"];
		$tenantRowsets = NULL;
		try {
			$db = Database::getDB ();
			$query = "SELECT tenant, name, description FROM TenantList";
			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Tenant");
					$query = $query. " WHERE ($type = :$type)";
					$statement = $db->prepare($query);
					$statement->bindParam(":$type", $value);
			} else
				$statement = $db->prepare($query);
				$statement->execute ();
				$tenantRowsets = $statement->fetchAll(PDO::FETCH_ASSOC);
				$statement->closeCursor ();
		} catch (Exception $e) { // Not permanent error handling
			echo "<p>Error getting tenant rows by $type: " . $e->getMessage () . "</p>";
		}
		return $tenantRowsets[0];
	}
	
	public static function getTenantListArray($rowSets, $idOnly) {
		// Returns an array of Tenants extracted from $rowSets
		$tenants = array();
		if (!empty($rowSets)) {
			foreach ($rowSets as $tenantRow ) {
				if ($idOnly)
					array_push ($tenants, $tenantRow['tenant'] );
				else
					array_push ($tenants, array("tenantId" => $tenantRow['tenant'], "name" => $tenantRow['name'], "description" => $tenantRow['description']));
			}
		}
		return $tenants;
	}
	
	public static function getTenantListBy($type=null, $value=null, $idOnly=1) {
		// Returns Tenants whose $type field has value $value
		$tenantRows = array();
		foreach ($value as $valueItem) {
			array_push($tenantRows, TenantDB::getTenantListRowSetsBy($type, $valueItem));
		}
		return TenantDB::getTenantListArray($tenantRows, $idOnly);
	}
}
?>
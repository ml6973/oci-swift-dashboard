<?php
class OCI_SWIFT {
	
	protected static $swiftURL;
	protected static $swiftAuthURL;
	protected static $swiftUser;
	protected static $swiftPass;
	protected static $swiftToken;
	
	protected static function getAuthToken($tenantID) {
		$configFile = self::getConfig();
		self::$swiftAuthURL = $configFile["swiftAuthURL"];
		self::$swiftUser = $configFile["swiftUsername"];
		self::$swiftPass = $configFile["swiftPassword"];
		
		//Initialize the json object to be used for the body
		$json = array(
				"auth" => array(
				          "tenantName" => $tenantID,
				          "passwordCredentials" => array(
				                                   "username" => self::$swiftUser,
				          		                   "password" => self::$swiftPass
   			          		                       )
				          )
				);
		$json = json_encode($json);
		
		//Initialize the curl operation and set the parameters
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, self::$swiftAuthURL."/tokens");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($json))
				);
	
		$response = curl_exec($ch);
		
		if ($response === FALSE)
			return null;
		
		if (!curl_errno($ch)) {
		  switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
		    case 200:  # OK
		      break;
		    default: {
		      self::$swiftToken = null;
		      return null;
		    }
		  }
		}
		
		curl_close($ch);
		
		$response = json_decode($response, true);
		
		self::$swiftToken = $response['access']['token']['id'];
	}
	
	public static function getContainers($tenantID) {
		$configFile = self::getConfig();
		self::$swiftURL = $configFile["swiftURL"];
		self::getAuthToken($tenantID);
		
		//Return null if authentication had a failure
		if (is_null(self::$swiftToken))
			return null;
		
		//Initialize the curl operation and set the parameters
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, self::$swiftURL."?format=json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Auth-Token: ' . self::$swiftToken)
				);
		
		$response = curl_exec($ch);
		
		if ($response === FALSE)
			return null;
		
		curl_close($ch);
	
		$response = json_decode($response, true);
		
		return $response;
	}
	
	public static function getObjects($tenantID, $containerName) {
		$configFile = self::getConfig();
		self::$swiftURL = $configFile["swiftURL"];
		self::getAuthToken($tenantID);
		
		//Return null if authentication had a failure
		if (is_null(self::$swiftToken))
			return null;
	
		//Initialize the curl operation and set the parameters
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, self::$swiftURL."/".$containerName."?format=json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Auth-Token: ' . self::$swiftToken)
				);
	
		$response = curl_exec($ch);
	
		if ($response === FALSE)
			return null;
	
		curl_close($ch);

		$response = json_decode($response, true);

		return $response;
	}
	
	protected static function getConfig() {
		$configPath = dirname(__FILE__).DIRECTORY_SEPARATOR."..".
		DIRECTORY_SEPARATOR. ".." . DIRECTORY_SEPARATOR.
		".." . DIRECTORY_SEPARATOR . "myConfig.ini";
		$configFile = parse_ini_file($configPath);
		return $configFile;
	}
}

?>
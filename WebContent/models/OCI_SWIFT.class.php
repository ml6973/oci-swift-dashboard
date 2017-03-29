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
		
		//Encode the container name as a URL
		$containerNameEncode = rawurlencode($containerName);
	
		//Initialize the curl operation and set the parameters
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, self::$swiftURL."/".$containerNameEncode."?format=json");
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
	
	//To be called via FileServe
	public static function downloadObject($tenantID, $objectPath) {
		$configFile = self::getConfig();
		self::$swiftURL = $configFile["swiftURL"];
		self::getAuthToken($tenantID);
	
		//Return null if authentication had a failure
		if (is_null(self::$swiftToken))
			return null;
	
		$objectPathParts = explode('/', $objectPath);
		$objectPath = "";
		foreach ($objectPathParts as $part){
			if ($part === end($objectPathParts)){
			   $objectPath = $objectPath.$part;
			}else{
			   $objectPath = $objectPath.rawurlencode($part)."/";
			}
		}
		$objectPath = self::$swiftURL.'/'.$objectPath;
		$fileSize = OCI_SWIFT::get_size($objectPath);
		$fileName = end($objectPathParts);
		$fileName = rawurldecode($fileName);
		if (is_null($fileSize))
			return null;
		
		$opts = array(
				'http'=>array(
						'method'=>"GET",
						'header'=>"X-Auth-Token: ".self::$swiftToken
				)
		);
		$context = stream_context_create($opts);
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . $fileSize);
		
		self::readfile_chunked($objectPath, $context);
	}
	
	protected static function getConfig() {
		$configPath = dirname(__FILE__).DIRECTORY_SEPARATOR."..".
		DIRECTORY_SEPARATOR. ".." . DIRECTORY_SEPARATOR.
		".." . DIRECTORY_SEPARATOR . "myConfig.ini";
		$configFile = parse_ini_file($configPath);
		return $configFile;
	}
	
	protected static function get_size($url) {
		$my_ch = curl_init();
		curl_setopt($my_ch, CURLOPT_URL, $url);
		curl_setopt($my_ch, CURLOPT_HEADER, true);
		curl_setopt($my_ch, CURLOPT_NOBODY, true);
		curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($my_ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($my_ch, CURLOPT_HTTPHEADER, array('X-Auth-Token: ' . self::$swiftToken));
		$r = curl_exec($my_ch);
		if (!curl_errno($my_ch)) {
		  switch ($http_code = curl_getinfo($my_ch, CURLINFO_HTTP_CODE)) {
		    case 200:  # OK
		      break;
		    default: {
		      return null;
		    }
		  }
		}
		foreach(explode("\n", $r) as $header) {
			if(strpos($header, 'Content-Length:') === 0) {
				return trim(substr($header,16));
			}
		}
		return null;
	}
	
	// Read a file and display its content chunk by chunk
	protected static function readfile_chunked($filename, $context, $retbytes = TRUE) {
		define('CHUNK_SIZE', 1024*1024); // Size (in bytes) of tiles chunk
		$buffer = '';
		$cnt    = 0;
		$handle = fopen($filename, 'rb', false, $context);
	
		if ($handle === false) {
			return false;
		}
	
		while (!feof($handle)) {
			$buffer = fread($handle, CHUNK_SIZE);
			echo $buffer;
			ob_flush();
			flush();
	
			if ($retbytes) {
				$cnt += strlen($buffer);
			}
		}
	
		$status = fclose($handle);
	
		if ($retbytes && $status) {
			return $cnt; // return num. bytes delivered like readfile() does.
		}
	
		return $status;
	}
}

?>
<?php
class API_GET {
	
	protected static $apiId;
	protected static $apiName;
	protected static $apiType;
	protected static $apiUrl;
	protected static $apiUser;
	protected static $apiPass;
	protected static $description;
	
	public static function getAPIs($api_ID = null) {
		$apis = null;
		if (is_null($api_ID)){
			$apis = APIDB::getAPIBy();
		} else {
			$apis = APIDB::getAPIBy('apiId', $api_ID);
		}
		return $apis;
	}
	
	//  !!! API USER and PASS will be part of the header!  !!!
	
	public static function getImage($apiID, $image) {
		$api = self::getAPIs($apiID)[0];
		if (is_null($api)){
			return null;
		}

		self::$apiId = $api["apiId"];
		self::$apiName = $api["apiName"];
		self::$apiType = $api["apiType"];
		self::$apiUrl = $api["apiUrl"];
		self::$apiUser = $api["apiUser"];
		self::$apiPass = $api["apiPass"];
		self::$description = $api["description"];
		
		
		if (strcmp(self::$apiType, "image") != 0){
			return null;
		}
		
		//Save string into temp file
		$file = tempnam(sys_get_temp_dir(), 'POST');
		file_put_contents($file, $image);
		
		//Post file
		$post = array(
			'image' => new CurlFile($file)
		);
	
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, self::$apiUrl);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: multipart/form-data',
				'api-uname: '.self::$apiUser,
				'api-pass: '.self::$apiPass)
				);
	
		$response = curl_exec($ch);
		
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
		curl_close($ch);
		
		//Remove the file
		unlink($file);
		
		if ($httpcode != 200){
			return null;
		}
	
		return($response);
	}
}

?>
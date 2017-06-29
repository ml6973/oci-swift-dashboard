<?php
class APIServe {
	public function run($apiId, $apiType, $file) {
		if (strcmp($apiType, "image") == 0) {
			echo API_GET::getImage($apiId, $file);
		} else {
			return null;
		}
	}
}
?>
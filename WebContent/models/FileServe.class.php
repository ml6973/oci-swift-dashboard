<?php
class FileServe {
	public function run($tenantId, $objectPath) {
		$tenant = base64_decode($tenantId);
		$object = base64_decode($objectPath);
		OCI_SWIFT::downloadObject($tenant, $object);
	}
}
?>
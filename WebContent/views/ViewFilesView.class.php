<?php
class ViewFilesView {
  public static function show() { 
	  MasterView::showHeader();
	  MasterView::showNavBar();
	  ViewFilesView::showDetails();
	  MasterView::showFooter();
  }

  public static function showDetails() {
  	$base = $_SESSION['base'];
  	$pathDir = dirname(__FILE__);  //Initialize the path directory
  	
  	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />';
  	echo '<link rel="stylesheet" href="css/viewFiles_style.css">';
  	echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>';
  	echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>';
  	echo '<style>#greeting{text-align:center;}</style>';
  	echo '
	<!--Banner-->
	<div class="jumbotron">
	   	<div id="greeting" class="container">
	       	<h1 id="welcome">Welcome to the Secure Multi-Tenant Cloud Storage Dashboard!</h1>
	       	<p>This will provide an easy to use dashboard to view your files.</p>
	       <!--	<p><a class="btn btn-primary btn-md" href="/#/about" role="button">Learn more &raquo;</a></p> -->
	    </div>
	</div>';
  	
  	//Retrieve all assigned tenants
  	$tenantIDs = TenantDB::getTenantsBy('userId', $_SESSION['authenticatedUser']->getUserId());
  	$tenants = TenantDB::getTenantListBy('tenantId', $tenantIDs, 0);
  	$title = null;
  	
  	//Sort tenants naturally
  	foreach ($tenants as $key => $row) {
  		$title[$key] = $row['name'];
  	}
  	if (!is_null($title))
  	   array_multisort($title , SORT_NATURAL, $tenants);
  	
  	if (!is_null($tenants) && !empty($tenants)){
  		echo '<div class="container" style="width:100%;">';
  		echo '<div class="row">';
  		echo '<div class="col-sm-5">';
  		foreach ($tenants as $tenant){
		  	//Get all containers
		  	$containers = OCI_SWIFT::getContainers($tenant['tenantId']);
		  	
		  	//If authentication as a tenant failed, initialize containers to false
		  	if (is_null($containers) || empty($containers))
		  		continue;
		  	
	  		echo '<div class="tenantcontainer">';
	  		echo '
	  				<div class="row">
						<h2 class="text-left pull-left" style="padding-left: 20px;">'.$tenant['name'].'</h2>
	  				</div>';
	  		if (!is_null($tenant['description'])) {
	  			echo '<p style="padding-left:2em; font-size:17px;">'.$tenant['description'].'</p>';
	  		}
	  		$objectPaths = array();
		 	foreach($containers as $container){
		  			if ($container != false)
			  			$objects = OCI_SWIFT::getObjects($tenant['tenantId'], $container['name']);
			  		else
			  			$objects = null;
					
			  		if (!is_null($objects) && ($container['count'] > 0)) {
						foreach($objects as $object) {
							if (!preg_match('/\/$/', $object['name'])) {
								array_push($objectPaths, $container['name'].'/'.$object['name']);
							}
						}
			  		}
		 		}
		 	echo '<div id='.$tenant['tenantId'].'>';
		 	$tree = build_tree($objectPaths);
		 	$treeJSON = array();
		 	buildTreeJSON($tree, '', $treeJSON);
		 	$treeJSON = json_encode($treeJSON);
		 	echo '</div>';
		 	echo '</div>';
		 	echo '<script>$(\'#'.$tenant['tenantId'].'\').jstree({core: {data: '.$treeJSON.'}, plugins: [\'dnd\']} );</script>';
		 	echo '<script>$("#'.$tenant['tenantId'].'").on("select_node.jstree",
     					function(evt, data){
		 			        if(data.instance.is_leaf(data.node)){
		 			           window.location.assign(\'http://\' + window.location.hostname + \'/'.$base.'/fileserve?'.base64_encode($tenant['tenantId']).'&\' + data.node.id + \'\');
		 			        }
     					}
			);</script>';
	 	}
	 	echo '</div>';
	 	
	 	echo '<div class="col-sm-7">';

	 	ViewPanel::show();
	 	
	 	echo '</div>';
	 	echo '</div>';
	 	echo '</div>';
  	}else{
  		echo '<div class="container">';
  		echo '
				           <h3><ul>
					        	<div>';
  		echo ' '."No Files Present".'';
  		echo '</div>
				          </ul></h3>';
  		echo '</div>';
  	}
  }
}

function build_tree($paths){
	$array = array();
	foreach ($paths as $path) {
	  $path = trim($path, '/');
	  $list = explode('/', $path);
	  $n = count($list);
	
	  $arrayRef = &$array; // start from the root
	  for ($i = 0; $i < $n; $i++) {
	    $key = $list[$i];
	    $arrayRef = &$arrayRef[$key]; // index into the next level
	  }
	}
	return $array;
}

function buildTreeJSON($array, $prefix, & $output) {
	foreach ($array as $key => $value) {
		//File type icons
		if (preg_match('/\.png$/', $key)){
			$jsonPiece = array("id" => base64_encode($prefix.rawurlencode($key)),"text" => $key, "icon" => "glyphicon glyphicon-picture");
			array_push($output, $jsonPiece);
		} elseif (preg_match('/\.jpg$/', $key)) {
			$jsonPiece = array("id" => base64_encode($prefix.rawurlencode($key)),"text" => $key, "icon" => "glyphicon glyphicon-picture");
			array_push($output, $jsonPiece);

		//default icon for files not listed above
		} elseif (!is_array($value)) {
			$jsonPiece = array("id" => base64_encode($prefix.rawurlencode($key)),"text" => $key, "icon" => "glyphicon glyphicon-file");
			array_push($output, $jsonPiece);
		}

		// if the value is another array, recursively build the list
		if (is_array($value)){
			$jsonPiece = array("text" => $key, "children" => array());
			buildTreeJSON($value, "$prefix$key/", $jsonPiece["children"]);
			array_push($output, $jsonPiece);
		}
	}
}
?>
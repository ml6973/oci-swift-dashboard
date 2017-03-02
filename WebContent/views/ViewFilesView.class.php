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
  	$tenants = TenantDB::getTenantsBy('userId', $_SESSION['authenticatedUser']->getUserId());
  	
  	if (!is_null($tenants) && !empty($tenants)){
  		foreach ($tenants as $tenant){
		  	//Get all containers
		  	$containers = OCI_SWIFT::getContainers($tenant);
		  	
		  	//If authentication as a tenant failed, initialize containers to false
		  	if (is_null($containers) || empty($containers))
		  		continue;
		  	
	  		echo '<div class="container">';
	  		echo '
	  				<div class="row">
						<h2 class="text-left pull-left" style="padding-left: 20px;">'.$tenant.'</h2>
	  				</div>';
	  		$objectPaths = array();
		 	foreach($containers as $container){
		  			if ($container != false)
			  			$objects = OCI_SWIFT::getObjects($tenant, $container['name']);
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
		 	echo '<div id='.$tenant.'>';
		 	$tree = build_tree($objectPaths);
		 	buildUL($tree, '');
		 	echo '</div>';
		 	echo '</div>';
		 	echo '<script>$(\'#'.$tenant.'\').jstree();</script>';
		 	echo '<script>$("#'.$tenant.'").on("select_node.jstree",
     					function(evt, data){
		 			        if(data.instance.is_leaf(data.node)){
          					   var newWindow = window.open();
		 			           newWindow.location.replace(\'http://\' + window.location.hostname + \'/'.$base.'/fileserve?'.base64_encode($tenant).'&\' + data.node.id + \'\');
		 			        }
     					}
			);</script>';
	 	}
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

function buildUL($array, $prefix) {
	echo "\n<ul>\n";
	foreach ($array as $key => $value) {
		//File type icons
		if (preg_match('/\.png$/', $key))
			echo "<li id=".base64_encode($prefix.rawurlencode($key))." data-jstree='{\"icon\":\"glyphicon glyphicon-picture\"}'>";
		elseif (preg_match('/\.jpg$/', $key))
			echo "<li id=".base64_encode($prefix.rawurlencode($key))." data-jstree='{\"icon\":\"glyphicon glyphicon-picture\"}'>";
		//default icon for files not listed above
		elseif (!is_array($value))
			echo "<li id=".base64_encode($prefix.rawurlencode($key))." data-jstree='{\"icon\":\"glyphicon glyphicon-file\"}'>";
		else
			echo "<li>";
		echo "$key";
		// if the value is another array, recursively build the list
		if (is_array($value))
			buildUL($value, "$prefix$key/");
			echo "</li>\n";
	}
	echo "</ul>\n";
}
?>
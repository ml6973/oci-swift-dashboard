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
  	
  	echo '<style>#greeting{text-align:center;}</style>';
  	echo '
	<!--Banner-->
	<div class="jumbotron">
	   	<div id="greeting" class="container">
	       	<h1 id="welcome">Welcome to the OCI Swift Dashboard!</h1>
	       	<p>This will provide an easy to use dashboard to view your files.</p>
	       <!--	<p><a class="btn btn-primary btn-md" href="/#/about" role="button">Learn more &raquo;</a></p> -->
	    </div>
	</div>';
  	
  	//Retrieve all assigned tenants
  	$tenants = TenantDB::getTenantsBy('userId', $_SESSION['authenticatedUser']->getUserId());
  	
  	//Get all containers
  	if (array_key_exists(0, $tenants))
  		$containers = OCI_SWIFT::getContainers($tenants[0]);
  	else
  		$containers = array(false);
  	
  	//If authentication as a tenant failed, initialize containers to false
  	if (is_null($containers))
  		$containers = array(false);
  	
 	foreach($containers as $container){
  			echo '<div class="container">';
  			echo '
  				<div class="row">
					<h2 class="text-left pull-left" style="padding-left: 20px;">'.$container['name'].'</h2>
  				</div>';
	  		
	  		if ($container != false)
	  			$objects = OCI_SWIFT::getObjects($tenants[0], $container['name']);
	  		else
	  			$objects = null;
			
	  		if (!is_null($objects) && ($container['count'] > 0)) {
				foreach($objects as $object) {
					if (!preg_match('/\/$/', $object['name'])) {
						echo '
			           <h3><ul>
				        	<div>';
						echo ' '.$object["name"].'';
					    echo '</div>
			          </ul></h3>';
					}
				}
	  		}else{
	  			echo '
		           <h3><ul>
			        	<div>';
	  			echo ' '."No Files Present".'';
	  			echo '</div>
		          </ul></h3>';
	  		}
			echo '
	    	<br><br>';
			echo '</div>';
	  }
  }
}
?>
<?php
class MasterView {
	public static function showHeader() {
		echo '
		<!DOCTYPE html>
		<html>
		<head>
			<title>OCI Swift Dashboard</title>
			<!--Vendor CSS-->
			<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
				<!--bootstrap-->
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">

			<link href="css/bootstrap.min.css" rel="stylesheet">
			<link href="css/custom.css" rel="stylesheet">

			<!--
			<link rel="stylesheet" href="https://bootswatch.com/cerulean/bootstrap.css" media="screen">
		    <link rel="stylesheet" href="https://bootswatch.com/assets/css/custom.min.css">
		    -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
				<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
			<link href="http://getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
				<!-- Modified local css-->
			<link href="css/jumbotron.css" rel="stylesheet">
				<!-- Font awesome-->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

			<!--Vendor javascripts-->
				<!--AngularJS-->
			<script src="js/angularJS/angular.min.js"></script>
			<script src="js/angularJS/angular-route.js"></script>
			<script src="js/angularJS/angular-route.min.js"></script>
			<script src="js/angularJS/angular-cookie.js"></script>
				<!--Jquery-->
			<script src="http://code.jquery.com/jquery-latest.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
			<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
		    	<!--bootstrap-->
		    		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
			<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>


		</head>';
    }

    public static function showNavBar() {
    	// Show the navbar
    	$base = (array_key_exists('base', $_SESSION))? $_SESSION['base']: "";
    	$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?
    	$_SESSION['authenticatedUser']:null;
    	$authenticatedUserData = (array_key_exists('authenticatedUserData', $_SESSION))?
    	$_SESSION['authenticatedUserData']:null;
    	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
    	echo '
    	<!--Navigation bar-->
    	<style>
    	#webname {
    	font-size: 25px;
    	font-family: museo-slab, Georgia, "Times New Roman", Times, serif;
    	font-weight: 300;
    	}
    	#login-btn {
    	font-size: 20px;
    	}
    	#logout-btn {
    	font-size: 20px;
    	}
    	</style>

    	<div ng-controller=\'headController\'>';
    	echo '<style>.navbar-inverse{background-color: white;} .logo{margin-top: 0px; margin-right: 10px;} .navbar-inverse .navbar-brand{color: rgb(17, 43, 79);} .navbar-inverse .navbar-brand:hover{color: rgb(241, 89, 37);}
    			.navbar-inverse .navbar-nav > li > a{color: rgb(17, 43, 79);} .navbar-inverse .navbar-nav > li > a:hover{color: rgb(241, 89, 37);}</style>';
    	echo '<nav class="navbar navbar-inverse navbar-fixed-top">
    	<div class="container">
    	<div class="navbar-header">
    	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
    	<span class="sr-only">Toggle navigation</span>
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>
    	<span class="icon-bar"></span>
    	</button>';
    	if (!is_null($authenticatedUser)){
    		echo '<img class="logo" src="/'.$base."/resources/siteImages/logo.png".'" alt="Logo" height="50" width="75">';
    		echo '<a id="webname" class="navbar-brand pull-right" href="/'.$base.'/viewfiles"> OCI Swift Dashboard</a>';
    	}
    	else {
    		echo '<img class="logo" src="/'.$base."/resources/siteImages/logo.png".'" alt="Logo" height="50" width="75">';
    		echo '<a id="webname" class="navbar-brand pull-right" href="/'.$base.'/login"> OCI Swift Dashboard</a>';
    	}

    	echo '</div>
    	<div id="navbar" class="navbar-collapse collapse">
    	<ul id="login" class="nav navbar-nav navbar-right">';

    	echo '<style>.alignName{line-height: 50px;}</style>';

    	if (!is_null($authenticatedUser)){
    		echo '<li class="pull-right"><a href="/'.$base.'/logout" id="logout-btn" ng-click=\'/'.$base.'/logout\' ng-hide=[[buttonShow]]>Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a></li>';
    		echo '<li class="pull-right"><a href="/'.$base.'/viewfiles" id="courses-btn" ng-click=\'/'.$base.'/viewfiles\' ng-hide=[[buttonShow]]>My Files <i class="fa" aria-hidden="true"></i></a></li>';
    		echo '<li> <span class="label label-default alignName">Welcome '.
    				$authenticatedUser->getUserName().'</span></li>';
    	}
		else {
    		echo '<li><a href="/'.$base.'/login" id="logout-btn" ng-click=\'/'.$base.'/login\' ng-hide=[[buttonShow]]>Login <i class="fa fa-sign-in" aria-hidden="true"></i></a></li>';
			echo '<li><a href="/'.$base.'/registration" id="logout-btn" ng-click=\'/'.$base.'/registration\' ng-hide=[[buttonShow]]>Register <i class="fa fa-sign-in" aria-hidden="true"></i></a></li>';
		}

    	echo '
    	</ul>
    	</div><!--/.navbar-collapse -->
    	</div>
    	</nav>
    	</div>';
    }

   	public static function showFooter() {
   		echo '<link rel="stylesheet" href="css/foot_style.css">
			<footer id=\'foot\' class=\'footer-distributed\'>
			<div class="container">

			    <div class="row">
		            <div class="footer-bottom-left">
		                <br><br>
		                <div>
		                	<p class="footer-company-name text-muted">2016 © OCI Swift Dashboard. All rights reserved. <br>Site built by Gregory Hooks.</p>
		                </div>
		            </div>
		        </div>

		    </div>
		</footer>';
   	}
}
?>

<?php  
class LoginView {
	
	public static function show() {
		MasterView::showHeader();
		MasterView::showNavBar();
		CarouselView::showCarousel();
		LoginView::showDetails();
	}
	
	public static function showDetails() {
		$base = $_SESSION['base'];
		$user = (array_key_exists('user', $_SESSION))?
		$_SESSION['user']:null;
		
		echo 
		'<div>
		<!-- CSS -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<link rel="stylesheet" href="css/login_form-elements.css">
		<link rel="stylesheet" href="css/login_style.css">

		<div class="top-content">
		 
	<!--	<div class="inner-bg"> -->
	<!--	<div class="container"> -->
	<!--	<div class="jumbotron"> -->
		<div class="row">
<!--		<div class="col-sm-8 col-sm-offset-2 text">
		<h1><strong>Secure Multi-Tenant Cloud Storage Dashboard</strong><br> Login Panel</h1>
		<div class="description">
		<!-- <p>We offer more valuable courses to registered users.<br>If you have any question, feel free to <a href="/#/about"><strong>contact us</strong></a>!</p> -->
		</div> -->
		</div>
		</div>
<!--	    </div> -->
		<div class="row">
		<div class="col-sm-6 col-sm-offset-3 form-box">
		<div class="form-top">
		<div class="form-top-left">
		<h1><strong>Secure Multi-Tenant Cloud Storage Dashboard</strong><br> Login Panel</h1>
		<p>View your files at a glance.</p>
		</div>
	<!--	<div class="form-top-right">
		<i class="fa fa-lock"></i>
		</div> -->
		</div>
		<div class="form-bottom">
		<form role="form" action="" method="post" class="login-form">';
		
		if (!is_null($user)) {
			echo '<p><div class="errorBox" id="errorBox"><p>
			<span class="errors" id="loginError">';
			echo '<p>'.$user->getError('userName').'</p>';
			echo '<p>'.$user->getError('password').'</p>';
			echo '</span></p>
			</div></p>';
		}
		echo '<div class="form-group">
		<label class="sr-only" for="form-username">Username</label>
		<input type="text" name="userName" placeholder="Username..." class="form-username form-control" id="userName" ng-model=\'username\' tabindex="1" ';
		if (!is_null($user)) { echo 'value = "'.$user->getUserName().'"'; }
		echo ' required>
		</div>
		<div class="form-group">
		<label class="sr-only" for="form-password">Password</label>
		<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="password" ng-model=\'password\' tabindex="2" required>
		</div>';
		echo '<button type="submit" class="btn login-button" ng-click=\'submit()\' tabindex="3">Sign in!</button>
		</form>
		</div>
		</div>
		</div>
		<br><br>
		</div>
		</div>
		</div>
		</div>';
	}
}
?>
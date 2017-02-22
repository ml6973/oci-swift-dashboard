<?php  
class RegistrationFinishView {
	
	public static function show() {
		MasterView::showHeader();
		RegistrationFinishView::showDetails();
	}
	
	public static function showDetails() {
		$base = $_SESSION['base'];
		$user = (array_key_exists('user', $_SESSION))?
		$_SESSION['user']:null;
		$userData = (array_key_exists('userData', $_SESSION))?
		$_SESSION['userData']:null;
		echo '
		<div>
			<!-- CSS -->
		        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
				<link rel="stylesheet" href="css/register_form-elements.css">
		        <link rel="stylesheet" href="css/register_style.css">
		
		
		     <div class="top-content">
		        	
		            <div class="inner-bg">
		                <div class="container">
		                    <div class="row">
		               <!--         <div class="col-sm-8 col-sm-offset-2 text">
		                            <h1><strong>OCI Swift Dashboard</strong> First Time Login</h1>
		                            <div class="description">
		                            	<p>Start accessing your files with ease!</p>
		                            </div>
		                        </div> -->
		                    </div>
		                    <div class="row">
		                        <div class="col-sm-6 col-sm-offset-3 form-box">
		                        	<div class="form-top">
		                        		<div class="form-top-left">
		                        			<h1><strong>OCI Swift Dashboard</strong> First Time Login</h1>
		                            		<p>Start accessing your files with ease!</p>
		                        		</div>
		                  <!--      		<div class="form-top-right">
		                        			<i class="fa fa-lock"></i>
		                        		</div> -->
		                            </div>
		                            <div class="form-bottom">
					                    <form role="form" action="" method="post" class="register-form">';
								if ((!is_null($user) || !is_null($userData)) && (($user->getErrorCount() > 0) || $userData->getErrorCount() > 0)) {
									echo '<p><div class="errorBox" id="errorBox">
									<span class="errors" id="usernameError">';
									if (!is_null($user)) {echo '<p>'.$user->getError('password').'</p>';}
									echo '</span>
									</div></p>';
								}
								echo '
					                    	<div class="form-group">
					                    		<label class="sr-only" for="form-password">Password</label>
					                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password" ng-model=\'password\' tabindex="1" ';
					                        	echo ' required>
					                        </div>
					                        <div class="form-group">
					                    		<label class="sr-only" for="form-password-confirm">Confirm Password</label>
					                        	<input type="password" name="password_confirm" placeholder="Confirm Password..." class="form-password-confirm form-control" id="form-password-confirm" ng-model=\'password\' tabindex="2" ';
					                        	echo ' required>
					                        </div>
					                        <button type="submit" class="btn" ng-click=\'submit()\' tabindex="3">Complete Registration!</button>
					                    </form>
				                    </div>
		                        </div>
		                    </div>
		                </div>
		            </div>        
		    </div>

			<div class="social-login-buttons">
				<a class="btn btn-link-2" href="/'.$base.'">Home Page</a>
			</div>
		
		</div>';		
	}
}
?>
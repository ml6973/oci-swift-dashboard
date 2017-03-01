<?php  
class registrationCompleteView {
	
	public static function show() {
		MasterView::showHeader();
		MasterView::showNavBar();
		registrationCompleteView::showDetails();
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
		        <link rel="stylesheet" href="css/register_complete_style.css">
		
		
		     <div class="top-content">
		        	
		            <div class="inner-bg">
		                <div class="container">
		                    <div class="row">
		               <!--         <div class="col-sm-8 col-sm-offset-2 text">
		                            <h1><strong>Secure Multi-Tenant Cloud Storage Dashboard</strong> Registration Panel</h1>
		                            <div class="description">
		                            	<p>Start accessing your files with ease!</p>
		                            </div>
		                        </div> -->
		                    </div>
		                    <div class="row">
		                        <div class="col-sm-6 col-sm-offset-3 form-box">
		                        	<div class="form-top">
										<i class="fa fa-check"></i>
		                        		<div class="form-top-left">
		                        			<h1><strong>Secure Multi-Tenant Cloud Storage Dashboard</strong> Registration Accepted!</h1>
		                            		<p>We will notify you via email when your account is ready.</p>
		                        		</div>
		                  	     		<!--<div class="form-top-right">
		                        			<i class="fa fa-check"></i>
		                        		</div>-->
		                            </div>
		                            <div class="form-bottom">
					                    
				                    </div>
		                        </div>
		                    </div>
		                </div>
		            </div>        
		    </div>
		
		

		
		</div>';		
	}
}
?>
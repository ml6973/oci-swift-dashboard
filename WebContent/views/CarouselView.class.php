<?php 

class CarouselView {
	public static function showCarousel(){
		$base = $_SESSION['base'];
		$pathDir = dirname(__FILE__);  //Initialize the path directory
		$fullPath = $pathDir . DIRECTORY_SEPARATOR . "../resources/carouselData/images/";
		if (file_exists($fullPath) && is_dir($fullPath)) {
			$files = scandir($fullPath);
			$files = array_diff($files, array('.', '..'));
			sort($files, SORT_REGULAR | SORT_NATURAL);
		}else{
			return null;
		}
		
		if (count($files) == 0)
			return null;
		
		echo '<style>
  			.carousel-inner > .item > img,
  			.carousel-inner > .item > a > img {
      			width: 135px;
				height: 135px;
      			margin: auto;
				border-radius: 100%;
				-moz-border-radius: 100%;
				-webkit-border-radius: 100%;
				-o-border-radius: 100%;
  			}
			.carousel-inner {
				top: 20px;
				right: 275px;
				height: 150px;
			}
			.carousel-indicators {
  				bottom: 10px;
				position: relative;
			}
			.carousel-control {
				bottom: 25px;
				height: 175px;
				z-index: 999;
				top: 50px;
			}
			.carousel-caption {
				right:-350px;
				height: 100%;
				margin-bottom: 70px;
			}
			.carousel {
				width: 100%;
				height: 175px;
				position: initial;
				background: #333;
				background-color: rgba(0,0,0,0.1);
				margin-top: 0px;
			}
			.quote {
				position: relative;
				height: 150px;
				width: 550px;
				top: 70px;
				left: 50px;
				margin: auto;
				text-shadow: 0 1px 2px rgba(0,0,0,1);
			}
				
			.carousel-fade .carousel-inner .item {
			  -webkit-transition-property: opacity;
			  transition-property: opacity;
			}
			.carousel-fade .carousel-inner .item,
			.carousel-fade .carousel-inner .active.left,
			.carousel-fade .carousel-inner .active.right {
			  opacity: 0;
			}
			.carousel-fade .carousel-inner .active,
			.carousel-fade .carousel-inner .next.left,
			.carousel-fade .carousel-inner .prev.right {
			  opacity: 1;
			}
			.carousel-fade .carousel-inner .next,
			.carousel-fade .carousel-inner .prev,
			.carousel-fade .carousel-inner .active.left,
			.carousel-fade .carousel-inner .active.right {
			  left: 0;
			  -webkit-transform: translate3d(0, 0, 0);
			          transform: translate3d(0, 0, 0);
			}
			.carousel-fade .carousel-control {
			  z-index: 999;
			}

  			</style>';
		
		echo '<div id="ociCarousel" class="carousel slide carousel-fade" data-ride="carousel">';
		$activeFlag = true;
		
		echo '<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">';
				
		foreach($files as $file) {
			$fileName = explode(".", $file)[0];
			if ($activeFlag) {
				echo '<div class="item active">';
				$activeFlag = false;
			}else{
				echo '<div class="item">';
			}
			echo'	<img class="pic" src="/'.$base."/resources/carouselData/images/".$file.'" alt="Happy Person" height="150" width="150">';
				
			if (file_exists($fullPath."../text/".$fileName.".txt")) {
				$text = file_get_contents($fullPath."../text/".$fileName.".txt");
				echo '<div class="carousel-caption">
        			<p class="quote">'.$text.'</p>
      			</div>';
			}
      			
			echo '</div>';
		}
		echo '</div>';
		
		$counter = 0;
		$activeFlag = true;
		if (count($files) > 1) {
			echo '<!-- Indicators -->
			<ol class="carousel-indicators">';
			foreach ($files as $file) {
				if ($activeFlag) {
					echo '<li data-target="#ociCarousel" data-slide-to="0" class="active"></li>';
					$activeFlag = false;
				}else{
					echo '<li data-target="#ociCarousel" data-slide-to="'.$counter.'"></li>';
				}
				$counter++;
			}
			echo '</ol>';
			echo '<!-- Left and right controls -->
			<a class="left carousel-control" href="#ociCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#ociCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
			</a>
			</div>';
		}
	}
}

?>
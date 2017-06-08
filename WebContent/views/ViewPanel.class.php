<?php

class ViewPanel {
	public static function show() {
		$base = $_SESSION['base'];
		
		echo '<div class="ViewPanel" data-spy="affix" data-offset-top="310" data-offset-bottom="150">';
		echo '<div class="row">';
		echo '<div class="col-lg-6">
				<div class="drop" style="background:black;">
				<div class="Viewer1 embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">
				Drag Files Here To View
				</div></div></div></div>';
		echo '<div class="col-lg-6">
				<div class="drop2" style="background:black;">
				<div class="Viewer2 embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">
				Drag Files Here To View
				</div></div></div></div>';
		echo '</div>';
		
		echo '<div class="row">';
		echo '<div class="col-lg-6">
		        <div class="drop3" style="background:black;">
				<div class="Viewer3 embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">
				Drag Files Here To View
				</div></div></div></div>';
		echo '<div class="col-lg-6">
		        <div class="drop4" style="background:black;">
				<div class="Viewer4 embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">
				Drag Files Here To View
				</div></div></div></div>';
		echo '</div>';
		
		echo '</div>';
		
		echo '<script src="js/prettyPhoto/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>';
		/*echo '<script type="text/javascript" charset="utf-8">
				  $(document).ready(function(){
				    $("a[rel^=\'prettyPhoto\']").prettyPhoto();
				  });
			  </script>';*/
		
		echo '<script src=\'js/jwplayer/jwplayer.js\'></script>';
		echo '<script src=\'js/helpers/helpers.js\'></script>';
		echo '<script>jwplayer.key=\'/WD5x7pXTcwyNA2ZWkPLeKEJ9VPM4/Rwk/ZDmw==\';</script>';
		echo "<script>
	 			$(function() {
	 			   $(document)
			            .on('dnd_move.vakata', function (e, data) {
				            var node = data.data.origin.get_node(data.element);
			                var t = $(data.event.target);
			                if(!t.closest('.jstree').length && node.children.length == 0) {
			                    if(t.closest('.drop').length) {
			                        data.helper.find('.jstree-icon').removeClass('jstree-er').addClass('jstree-ok');
			                    }
				                else if(t.closest('.drop2').length) {
			                        data.helper.find('.jstree-icon').removeClass('jstree-er').addClass('jstree-ok');
			                    }
								else if(t.closest('.drop3').length) {
			                        data.helper.find('.jstree-icon').removeClass('jstree-er').addClass('jstree-ok');
			                    }
								else if(t.closest('.drop4').length) {
			                        data.helper.find('.jstree-icon').removeClass('jstree-er').addClass('jstree-ok');
			                    }
			                    else {
			                        data.helper.find('.jstree-icon').removeClass('jstree-ok').addClass('jstree-er');
			                    }
			                }
		            	})
			            .on('dnd_stop.vakata', function (e, data) {
				            //Get the filetype
			                var t = $(data.event.target);
							var node = data.data.origin.get_node(data.element);
				            var filetype = node.text.substr((node.text.lastIndexOf('.') +1));
				
			                if(!t.closest('.jstree').length  && node.children.length == 0) {
			                    if(t.closest('.drop').length) {
				                    fileUrl = getFileUrl(node, data);
				                    replaceContent(filetype, fileUrl, 1);
			                    }
								else if(t.closest('.drop2').length) {
				                    fileUrl = getFileUrl(node, data);
				                    replaceContent(filetype, fileUrl, 2);
			                    }
				
								else if(t.closest('.drop3').length) {
				                    fileUrl = getFileUrl(node, data);
				                    replaceContent(filetype, fileUrl, 3);
			                    }
								else if(t.closest('.drop4').length) {
				                    fileUrl = getFileUrl(node, data);
				                    replaceContent(filetype, fileUrl, 4);
			                    }
			                }
			            });
	           });
 			</script>";
	}
}
?>
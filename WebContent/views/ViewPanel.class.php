<?php

class ViewPanel {
	public static function show() {
		$base = $_SESSION['base'];
		
		echo '<div class="ViewPanel" data-spy="affix" data-offset-top="310" data-offset-bottom="150">';
		echo '<div class="row">';
		echo '<div class="col-lg-6">
				<div class="drop" style="background:black; border-radius:10px;">
				<div class="Viewer embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">
				Drag Files Here To View
				</div></div></div></div>';
		echo '<div class="col-lg-6">
				<div class="drop2" style="background:black; border-radius:10px;">
				<div class="Viewer2 embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">
				Drag Files Here To View
				</div></div></div></div>';
		echo '</div>';
		
		//To possibly readd later, 4 video grid
/*		echo '<div class="row">';
		echo '<div class="col-lg-6">
		        <div class="drop3" style="background:black; border-radius:10px;">
				<div class="Viewer3 embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">
				Drag Files Here To View
				</div></div></div></div>';
		echo '<div class="col-lg-6">
		        <div class="drop4" style="background:black; border-radius:10px;">
				<div class="Viewer4 embed-responsive embed-responsive-16by9">
				<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">
				Drag Files Here To View
				</div></div></div></div>';
		echo '</div>';  */
		
		echo '</div>';
		
		echo '<script src=\'js/jwplayer/jwplayer.js\'></script>';
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
				
						/*		else if(t.closest('.drop3').length) {
			                        data.helper.find('.jstree-icon').removeClass('jstree-er').addClass('jstree-ok');
			                    }
								else if(t.closest('.drop4').length) {
			                        data.helper.find('.jstree-icon').removeClass('jstree-er').addClass('jstree-ok');
			                    }  */
				
			                    else {
			                        data.helper.find('.jstree-icon').removeClass('jstree-ok').addClass('jstree-er');
			                    }
			                }
		            	})
			            .on('dnd_stop.vakata', function (e, data) {
			                var t = $(data.event.target);
							var node = data.data.origin.get_node(data.element);
			                if(!t.closest('.jstree').length  && node.children.length == 0) {
			                    if(t.closest('.drop').length) {
				                    var base = location.href.split( '/' );
				                    base = base[3];
			                        var vidUrl = 'http://' + window.location.hostname + '/' + base + '/fileserve?';
			                        vidUrl += window.btoa($(data.element).closest('div').attr('id'));
			                        vidUrl += '&';
					                vidUrl += node.id;
					
					                //REPLACE with video player
					                $('.Viewer').replaceWith('<div id=\"player\">Loading the player...</div>');
					
					                //Setup the player
					                const player = jwplayer('player').setup({
								      file: vidUrl,
									  type: 'mp4',
								      volume: 100,
						 			  autostart: true,
									  width: '100%',
									  aspectratio: '16:9'
								    });
			                    }
								else if(t.closest('.drop2').length) {
				                    var base = location.href.split( '/' );
				                    base = base[3];
			                        var vidUrl = 'http://' + window.location.hostname + '/' + base + '/fileserve?';
			                        vidUrl += window.btoa($(data.element).closest('div').attr('id'));
			                        vidUrl += '&';
					                vidUrl += node.id;
					
					                //REPLACE with video player
					                $('.Viewer2').replaceWith('<div id=\"player2\">Loading the player...</div>');
					
					                //Setup the player
					                const player2 = jwplayer('player2').setup({
								      file: vidUrl,
									  type: 'mp4',
								      volume: 100,
						 			  autostart: true,
									  width: '100%',
									  aspectratio: '16:9'
								    });
			                    }
				
							/*	else if(t.closest('.drop3').length) {
				                    var base = location.href.split( '/' );
				                    base = base[3];
			                        var vidUrl = 'http://' + window.location.hostname + '/' + base + '/fileserve?';
			                        vidUrl += window.btoa($(data.element).closest('div').attr('id'));
			                        vidUrl += '&';
					                vidUrl += node.id;
					
					                //REPLACE with video player
					                $('.Viewer3').replaceWith('<div id=\"player3\">Loading the player...</div>');
					
					                //Setup the player
					                const player3 = jwplayer('player3').setup({
								      file: vidUrl,
									  type: 'mp4',
								      volume: 100,
						 			  autostart: true,
									  width: '100%',
									  aspectratio: '16:9'
								    });
			                    }
								else if(t.closest('.drop4').length) {
				                    var base = location.href.split( '/' );
				                    base = base[3];
			                        var vidUrl = 'http://' + window.location.hostname + '/' + base + '/fileserve?';
			                        vidUrl += window.btoa($(data.element).closest('div').attr('id'));
			                        vidUrl += '&';
					                vidUrl += node.id;
					
					                //REPLACE with video player
					                $('.Viewer4').replaceWith('<div id=\"player4\">Loading the player...</div>');
					
					                //Setup the player
					                const player4 = jwplayer('player4').setup({
								      file: vidUrl,
									  type: 'mp4',
								      volume: 100,
						 			  autostart: true,
									  width: '100%',
									  aspectratio: '16:9'
								    });
			                    } */
				
			                }
			            });
	           });
 			</script>";
	}
}
?>
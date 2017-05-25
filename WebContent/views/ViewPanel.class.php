<?php

class ViewPanel {
	public static function show() {
		$base = $_SESSION['base'];
		echo '<div class="ViewPanel" data-spy="affix" data-offset-top="310" data-offset-bottom="150"><div class="drop" 
				style="background:black; border-radius:10px;">
				<div class="Viewer embed-responsive embed-responsive-16by9"><div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">Drag Files Here To View</div></div></div></div>';
		echo '<script src=\'https://content.jwplatform.com/libraries/L7fM8L0h.js\'></script>';
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
						 			  autostart: true
								    });
			                    }
			                }
			            });
	           });
 			</script>";
	}
}
?>
function getFileUrl(node, data){
	//Craft the URL to access the object
	var base = location.href.split( '/' );
    base = base[3];
    var fileUrl = 'http://' + window.location.hostname + '/' + base + '/fileserve?';
    fileUrl += window.btoa($(data.element).closest('div').attr('id'));
    fileUrl += '&';
    fileUrl += node.id;
    return fileUrl;
}

function makeVideoPlayer(fileUrl, position) {
	//REPLACE with video player
	var playerName = "player" + position;
    $('.Viewer' + position).html('<div id="' + playerName + '">Loading the player...</div>');

    //Setup the player
    var tempPlayer = jwplayer(playerName).setup({
    		      file: fileUrl,
    			  type: 'mp4',
    		      volume: 100,
    			  autostart: true,
    			  width: '100%',
    			  aspectratio: '16:9'
    		    });
    eval("const " + playerName + " = tempPlayer")
}

function makeImageViewer(fileUrl, position) {
	var imageName = "image" + position;
	$('.Viewer' + position).html('<div class="embed-responsive-item" style="background-color: white; text-align: center;"><a href="' + fileUrl + '" rel="gallery[mygallery]" title="" style="height: 100%; width: 100%;"><img src="' + fileUrl + '" style="height: inherit;" alt="" /></a></div>');
}

function updateImageGallery () {
	$("a[rel^='gallery']").prettyPhoto({
		theme: 'light_rounded',
		overlay_gallery: false,
		social_tools: false
	});
}

function replaceContent(filetype, fileUrl, position) {
	if (/(mp4)$/ig.test(filetype)) {
        makeVideoPlayer(fileUrl, position);
        updateImageGallery();
	}else if (/(gif|jpg|png)$/ig.test(filetype)) {
		makeImageViewer(fileUrl, position);
		updateImageGallery();
	}else{
		alert("Unsupported file type.  You must download this file and view it locally.");
	}
}
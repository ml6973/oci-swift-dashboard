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
    $('.Viewer' + position).replaceWith('<div id="' + playerName + '">Loading the player...</div>');

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

function replaceContent(filetype, fileUrl, position) {
	if (/(mp4)$/ig.test(filetype)) {
        makeVideoPlayer(fileUrl, position);
	}else if (/(jpg|png)$/ig.test(filetype)) {
	    alert("Nice image, but I can't display that quite yet");
	}else{
		alert("Unsupported file type.  You must download this file and view it locally.");
	}
}
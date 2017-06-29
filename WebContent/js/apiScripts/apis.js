$(function(){
	$("#select1").change(function() {
		if ($("#photoviewer1").length) {
			var apiId = $(this).val();
			var source = $('#photoviewer1').attr('src');
			callImageAPI(apiId, source, 3);
		}
	});
	$("#select2").change(function() {
		if ($("#photoviewer2").length) {
			var apiId = $(this).val();
			var source = $('#photoviewer2').attr('src');
			callImageAPI(apiId, source, 4);
		}
	});
});

function callImageAPI (apiId, source, position) {
	
	//Craft the URL to access the object
	var base = location.href.split( '/' );
    base = base[3];
    var baseUrl = 'http://' + window.location.hostname + '/' + base;
    var fileUrl = baseUrl + '/apiserve';
    var loadUrl = baseUrl + '/resources/siteImages/ajax-loader.gif';
    
    fetchBlob(source, function(OriginalImage) {
    	  // Array buffer to Base64:
    	  var data = "apiId=" + apiId + "&" + "file=" + encodeURIComponent(btoa(getStringFromChunkedArray(new Uint8Array(OriginalImage))));

    	  fetchBlobPost(fileUrl, data, function(NewImage) {
    		  var newimage = btoa(getStringFromChunkedArray(new Uint8Array(NewImage)));
    		  
    		  if (newimage.length == 0){
    			  $('.Viewer' + position).html('<div class="embed-responsive-item" style="color:white; text-align: center; font-size: 30px; padding-top: 25%;">Select API To View</div>');
    			  return
    		  }
    		  
    		  var imageName = "image" + position;
			  $('.Viewer' + position).html('<div class="embed-responsive-item" style="background-color: white; text-align: center;"><a href="data:image/jpeg;base64, ' + newimage + '" rel="gallery[mygallery]" title="" style="height: 100%; width: 100%;"><img src="data:image/jpeg;base64, ' + newimage + '" style="height: inherit;" alt="" /></a></div>');
			  updateImageGallery();
    	  });

    });
    
    $('.Viewer' + position).html('<div class="embed-responsive-item" style="background-color: white; text-align: center; border: 2px solid gray;"><img src="' + loadUrl + '" style="padding-top: 18%;" alt="Loading..." /></div>');
    
};

function fetchBlob(uri, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', uri, true);
  xhr.responseType = 'arraybuffer';

  xhr.onload = function(e) {
    if (this.status == 200) {
      var blob = this.response;
      if (callback) {
        callback(blob);
      }
    }
  };
  xhr.send();
};

function fetchBlobPost(uri, data, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', uri, true);
  xhr.responseType = 'arraybuffer';
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(e) {
    if (this.status == 200) {
      var blob = this.response;
      if (callback) {
        callback(blob);
      }
    }
  };
  xhr.send(data);
};

function getStringFromChunkedArray(array) {
	var CHUNK_SIZE = 0x8000;
	var index = 0;
	var length = array.length;
	var result = '';
	var slice;
	while (index < length) {
		slice = array.slice(index, Math.min(index + CHUNK_SIZE, length));
		result += String.fromCharCode.apply(null, slice);
		index += CHUNK_SIZE;
	}
	return result;
};
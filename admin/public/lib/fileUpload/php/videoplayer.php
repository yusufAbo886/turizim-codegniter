<html>
<head>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.1/modernizr.min.js"></script>
</head>
<body>
<?php
	require_once('hashing.php');
	$showing = false;
	$ext = 'fds';
	$fullfile = '';
	if(isset($_GET['user_id'])) {
		$user_id = do_decrypt('player',$_GET['user_id']);
		$video_id = do_encrypt('upload',$user_id);
		$file = 'invalid';
		$d = dir("files");
		while (false !== ($entry = $d->read())) {
			$ext = pathinfo($entry, PATHINFO_EXTENSION);
			if($entry == $video_id.'.'.$ext) {
				$file = $entry;
				break;
			}
		}
		$date = date('Y-m-d-h-i-s');
		$d->close();
		
		if(file_exists('files/'.$file)) {
			echo '<div id="videoplayer"><video width="100%" controls>';
				echo '<source src="files/'.$file.'?rand='.$date.'" type="video/mp4">';
				$fullfile = 'files/'.$file.'?rand='.$date.'';
				echo 'Your browser does not support the <code>video</code> element.';
			echo '</video></div>';
			$showing = true;
		}
	}	
	if(!$showing) {
		echo '<div id="videoplayer"><div class="alert alert-warning">No video uploaded</div></div>';
	}
?>
<?php
if($showing) {
?>
<script type='text/javascript'>
var vidtype = '<?php echo $ext; ?>';
var vidfile = '<?php echo $fullfile; ?>';
var supported = false;
var nosupport = false;
var video = false;
var image = false;
var pdf = false;
var vidtypes = ['webm','ogg','ogv','mp4','m4v','mov','wmv','avi'];
var imgtypes = ['jpg','png','jpeg','gif'];
if (Modernizr.video) {
	console.log("PREVIEW TYPE: "+vidtype);
	if (Modernizr.video.webm) {
		if(vidtype == 'webm') {
	    	supported = true;
    	}
	}
	if (Modernizr.video.ogg) {
		if(vidtype == 'ogg' || vidtype == 'ogv') {
	    	supported = true;
    	}
	}
	if (Modernizr.video.h264){
    	if(vidtype == 'mp4' || vidtype == 'm4v' || vidtype == 'mov') {
	    	supported = true;
    	}
	}
	if(vidtype == 'wmv' || vidtype == 'avi') {
		nosupport = true;
	}
	
	if($.inArray(vidtype, vidtypes) != -1) {
		console.log("IS A VIDEO");
		video = true;
	}
	if($.inArray(vidtype, imgtypes) != -1) {
		console.log("IS AN IMAGE");
		image = true;
	}
	if(vidtype == 'pdf') {
		console.log("IS A PDF");
		pdf = true;
	}
}
if(!supported) {
	if(video) {
		var message = '<h4>You cannot preview your uploaded video in this browser</h4><p>To preview your video, use a web browser which supports '+vidtype+'.</p>';
		if(nosupport) {
			var message = '<h4>You cannot preview your uploaded video in this browser</h4><p>Your web browser is unable to preview video files of this type ('+vidtype+').</p>';
		}
		$('#videoplayer').html('<div class="alert alert-danger">'+message+'</div>');
	} else if (image) {
		$('#videoplayer').html('<img src="'+vidfile+'" />');
	} else if (pdf) {
		$('#videoplayer').html('<iframe src="'+vidfile+'" width="100%" height="400"></iframe>');
	} else {
		var message = '<h4>Preview does not support this file type</h4><p>The preview does not support the '+vidtype+' file type.</p><p>To check the file, please <a href="'+vidfile+'">click here</a>.';
		$('#videoplayer').html('<div class="alert alert-danger">'+message+'</div>');
	}
}
</script>
<?php
}
?>
</body>
</html>
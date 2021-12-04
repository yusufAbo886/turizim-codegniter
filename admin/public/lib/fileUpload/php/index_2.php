<!DOCTYPE HTML>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	require_once('lti.php');
	require_once('hashing.php');
	$lti = new Lti();
	$lti->requirevalid();
	$hasheduploaduser_id = do_encrypt('upload',$lti->user_id());
	$hashedplayer_id = do_encrypt('player',$lti->user_id());
	
	$selecttext = 'Select video file';
	if(file_exists('files/'.$hasheduploaduser_id.'.mp4')) {
		$selecttext = 'Overwrite uploaded file';
	}
	$title = 'Video Uploader';
	if(isset($_POST['custom_title'])) {
		$title = $_POST['custom_title'];
	}
?>
<html lang="en">
	<head>
		<!-- Force latest IE rendering engine or ChromeFrame if installed -->
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery.fileupload.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
			<!-- The fileinput-button span is used to style the file input field as button -->
			<span class="filelimit"><?php echo 'Maximum file size is '.(ini_get('post_max_size')/1024/1024).' MB'; ?></span>
			<span class="btn btn-success fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span id="uploadtext"><?php echo $selecttext; ?></span>
				<!-- The file input field used as target for the file upload widget -->
				<input id="fileupload" type="file" name="videofile">
			</span>
			<br>
			<br>
			<!-- The global progress bar -->
			<div id="progress" class="progress">
				<div class="progress-bar progress-bar-success"></div>
			</div>
			<!-- The container for the uploaded files -->
			<div id="errors" class="error"></div>
		    <div class="panel panel-default">
		    	<div class="panel-heading">
		            <h3 class="panel-title">Preview</h3>
		        </div>
		        <div class="panel-body">
			    	<iframe id='player' src='videoplayer.php?user_id=<?php echo $hashedplayer_id; ?>' width='100%' style="border:0;"></iframe>
		        </div>
		    </div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
		<script src="js/vendor/jquery.ui.widget.js"></script>
		<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
		<script src="js/jquery.iframe-transport.js"></script>
		<!-- The basic File Upload plugin -->
		<script src="js/jquery.fileupload.js"></script>
		<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script>
			/*jslint unparam: true */
			/*global window, $ */
			$(function () {
			    'use strict';
			    // Change this to the location of your server-side upload handler:
			    var url = 'upload.php?user_id=<?php echo $hasheduploaduser_id; ?>';
			    $('#fileupload').fileupload({
			        url: url,
			        dataType: 'json',
			        done: function (e, data) {
			        	console.log(data.result.videofile);
			            $.each(data.result.videofile, function (index, file) {
			            	if(file.error) {
				            	$('#errors').html('<p>Error: '+file.error+'</p>');
			            	} else {
			            		$('#errors').html('');
				            	$('#player').attr('src','videoplayer.php?user_id=<?php echo $hashedplayer_id; ?>');
				            	//$('#player').height('400');
				            	fixload();
				            	$('#uploadtext').text('Overwrite uploaded video');
			            	}
			            });
			        },
			        progressall: function (e, data) {
			            var progress = parseInt(data.loaded / data.total * 100, 10);
			            $('#progress .progress-bar').css(
			                'width',
			                progress + '%'
			            );
			        }
			    }).prop('disabled', !$.support.fileInput)
			        .parent().addClass($.support.fileInput ? undefined : 'disabled');
			});
			function fixload() {
				$('iframe').load(function() {
					$('#player').height(''+(this.contentWindow.document.body.offsetHeight));
				});
			}
			fixload();
		</script>
	</body> 
</html>
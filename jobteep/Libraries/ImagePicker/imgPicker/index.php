<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="assets/img/favicon.png">
	<title>ImagePicker Demo</title>
	
	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/imgpicker.css">
	
	<!-- JavaScript -->
	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<script src="assets/js/jquery.Jcrop.min.js"></script>
	<script src="assets/js/jquery.imgpicker.js"></script>

</head>
<body>
	<div class="navbar clearfix"><div class="container"><a class="navbar-brand" href="index.html">ImagePicker</a><button class="navbar-toggle" type="button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><ul class="navbar-nav"><li><a href="http://codecanyon.net/item/imagepicker-uploader-webcam-cropper/6722532?ref=HazzardWeb">Buy Now</a></li><li><a href="http://demo.hazzardweb.net/imgPicker/docs">Documentation</a></li><li><a href="http://hazzardweb.net">© HazzardWeb</a></li></ul></div></div>

	<div class="main">
		<div class="container"><div class="box">
			<div class="header" style="background-image: url('assets/img/default-header.jpg');">
				<div class="avatar-container">
					<!-- This button opens the avatar modal ( data-ip-modal="#avatarModal" ) -->
					<button type="button" class="btn btn-default edit-avatar" data-ip-modal="#avatarModal" title="Edit avatar"><i class="icon-edit"></i></button>

					<img src="assets/img/default-avatar.png" id="avatar">
				</div>

				<!-- This button opens the header modal ( data-ip-modal="#headerModal" ) -->
				<button type="button" class="btn btn-default edit-header" data-ip-modal="#headerModal" title="Edit header"><i class="icon-edit"></i></button>
			</div>
			<div class="content clearfix">

				<!-- This button opens the background modal ( data-ip-modal="#bgModal" ) -->
				<button type="button" class="btn btn-default edit-bg" data-ip-modal="#bgModal">Edit background</button>
				
				<form>
					<input type = "text" name = "profile" value = "" id = "perfil">
				</form>

				<h1 class="title">Image<span>Picker</span></h1><h2 class="subtitle">Uploader - Webcam - Cropper</h2><h2>Features:</h2><ul><li>Upload images</li><li>Take pictures with webcam or phone camera</li><li>Crop, resize, rotate, edit</li><li>Save images to database and autoload them</li><li>Options like aspect ratio, min/max width/height and more</li><li>Works in all the major browsers, including IE8+ and mobile</li><li>Upload progress bar</li><li>Touchescreen compatible</li><li>Works with modal &amp; inline</li><li>Easy to configure &amp; customize</li></ul><h2>Examples:</h2><ul><li class="active"><a href="index.html">Main Demo</a></li><li><a href="example-modal.html">Modal basic</a></li><li><a href="example-inline.html">Inline basic</a></li><li><a href="example-autoload.html">Autoload image</a></li><li><a href="example-multi.html">Multiple images</a></li><li><a href="example-zero-interface.html">Zero interface</a></li></ul>

			</div>
		</div></div>
	</div>

	<!-- Avatar Modal -->
	<div class="ip-modal" id="avatarModal">
		<div class="ip-modal-dialog">
			<div class="ip-modal-content">
				<div class="ip-modal-header">
					<a class="ip-close" title="Close">&times;</a>
					<h4 class="ip-modal-title">Change avatar</h4>
				</div>
				<div class="ip-modal-body">
					<div class="btn btn-primary ip-upload">Upload <input type="file" name="file" class="ip-file"></div>
					<button class="btn btn-primary ip-webcam">Webcam</button>
					<button type="button" class="btn btn-info ip-edit">Edit</button>
					<button type="button" class="btn btn-danger ip-delete">Delete</button>
					
					<div class="alert ip-alert"></div>
					<div class="ip-info">To crop this image, drag a region below and then click "Save Image"</div>
					<div class="ip-preview"></div>
					<div class="ip-rotate">
						<button type="button" class="btn btn-default ip-rotate-ccw" title="Rotate counter-clockwise"><i class="icon-ccw"></i></button>
						<button type="button" class="btn btn-default ip-rotate-cw" title="Rotate clockwise"><i class="icon-cw"></i></button>
					</div>
					<div class="ip-progress">
						<div class="text">Uploading</div>
						<div class="progress progress-striped active"><div class="progress-bar"></div></div>
					</div>
				</div>
				<div class="ip-modal-footer">
					<div class="ip-actions">
						<button class="btn btn-success ip-save">Save Image</button>
						<button class="btn btn-primary ip-capture">Capture</button>
						<button class="btn btn-default ip-cancel">Cancel</button>
					</div>
					<button class="btn btn-default ip-close">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end Modal -->

	<!-- Header Modal -->
	<div class="ip-modal" id="headerModal">
		<div class="ip-modal-dialog">
			<div class="ip-modal-content">
				<div class="ip-modal-header">
					<a class="ip-close" title="Close">&times;</a>
					<h4 class="ip-modal-title">Change header</h4>
				</div>
				<div class="ip-modal-body">
					<div class="btn btn-primary ip-upload">Upload <input type="file" name="file" class="ip-file"></div>
					<!-- <button class="btn btn-primary ip-webcam">Webcam</button> -->
					<button type="button" class="btn btn-info ip-edit">Edit</button>
					<button type="button" class="btn btn-danger ip-delete">Delete</button>
					
					<div class="alert ip-alert"></div>
					<div class="ip-info">To crop this image, drag a region below and then click "Save Image"</div>
					<div class="ip-preview"></div>
					<div class="ip-rotate">
						<button type="button" class="btn btn-default ip-rotate-ccw" title="Rotate counter-clockwise"><i class="icon-ccw"></i></button>
						<button type="button" class="btn btn-default ip-rotate-cw" title="Rotate clockwise"><i class="icon-cw"></i></button>
					</div>
					<div class="ip-progress">
						<div class="text">Uploading</div>
						<div class="progress progress-striped active"><div class="progress-bar"></div></div>
					</div>
				</div>
				<div class="ip-modal-footer">
					<div class="ip-actions">
						<button class="btn btn-success ip-save">Save Image</button>
						<button class="btn btn-primary ip-capture">Capture</button>
						<button class="btn btn-default ip-cancel">Cancel</button>
					</div>
					<button class="btn btn-default ip-close">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end Modal -->

	<!-- Header Modal -->
	<div class="ip-modal" id="bgModal">
		<div class="ip-modal-dialog">
			<div class="ip-modal-content">
				<div class="ip-modal-header">
					<a class="ip-close" title="Close">&times;</a>
					<h4 class="ip-modal-title">Change background</h4>
				</div>
				<div class="ip-modal-body">
					<div class="btn btn-primary ip-upload">Upload <input type="file" name="file" class="ip-file"></div>
					<!-- <button class="btn btn-primary ip-webcam">Webcam</button> -->
					<button type="button" class="btn btn-info ip-edit">Edit</button>
					<button type="button" class="btn btn-danger ip-delete">Delete</button>
					
					<div class="alert ip-alert"></div>
					<div class="ip-info">To crop this image, drag a region below and then click "Save Image"</div>
					<div class="ip-preview"></div>
					<div class="ip-rotate">
						<button type="button" class="btn btn-default ip-rotate-ccw" title="Rotate counter-clockwise"><i class="icon-ccw"></i></button>
						<button type="button" class="btn btn-default ip-rotate-cw" title="Rotate clockwise"><i class="icon-cw"></i></button>
					</div>
					<div class="ip-progress">
						<div class="text">Uploading</div>
						<div class="progress progress-striped active"><div class="progress-bar"></div></div>
					</div>
				</div>
				<div class="ip-modal-footer">
					<div class="ip-actions">
						<button class="btn btn-success ip-save">Save Image</button>
						<button class="btn btn-primary ip-capture">Capture</button>
						<button class="btn btn-default ip-cancel">Cancel</button>
					</div>
					<button class="btn btn-default ip-close">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end Modal -->

	<script> 
		$(function() {
			var time = function(){return'?'+new Date().getTime()};
			
			// Avatar setup
			$('#avatarModal').imgPicker({
				url: 'server/upload_avatar.php',
				aspectRatio: 1, // Crop aspect ratio
				// Delete callback
				deleteComplete: function() {
					$('#avatar').attr('src', 'assets/img/default-avatar.png');
					$('#perfil').attr('value', '');
					this.modal('hide');
				},
				// Crop success callback
				cropSuccess: function(image) {
					console.log(image);
					$('#avatar').attr('src', image.versions.avatar.url + time());
					$('#perfil').attr('value', image.versions.avatar.name);
					this.modal('hide');
				},
				// Send some custom data to server
				data: {
					key: 'education',
				}
			});

			// Header setup
			$('#headerModal').imgPicker({
				url: 'server/upload_header.php',
				aspectRatio: 32/7,
				deleteComplete: function() {
					$('.header').css('background-image', 'url(assets/img/default-header.jpg)');
					this.modal('hide');
				},
				cropSuccess: function(image) {
					$('.header').css('background-image', 'url(' + image.versions.header.url + time() + ')');
					this.modal('hide');
				}
			});

			// Background setup
			$('#bgModal').imgPicker({
				url: 'server/upload_bg.php',
				aspectRatio: 16/9,
				deleteComplete: function() {
					$('body').css('background-image', 'none');
					this.modal('hide');
				},
				cropSuccess: function(image) {
					$('body').css('background-image', 'url(' + image.versions.bg.url + time() + ')');
					this.modal('hide');
				}
			});

			// Demo only
			$('.navbar-toggle').on('click',function(){$('.navbar-nav').toggleClass('navbar-collapse')});
			$(window).resize(function(e){if($(document).width()>=430)$('.navbar-nav').removeClass('navbar-collapse')});
		}); 
	</script>
</body>
</html>
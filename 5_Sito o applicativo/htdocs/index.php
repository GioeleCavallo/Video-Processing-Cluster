<!doctype html>
<html>
    <head>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/css.css" rel="stylesheet" type="text/css">
        <link href="dropzone.css" rel="stylesheet" type="text/css">
    </head>
    <body>
		<h1 class="title">UPLOAD</h1>
		<hr class="title_divisor">

		<div class="container" >
		<form method="POST" action="upload.php" enctype="multipart/form-data" class="dropzone" id="dropzonewidget" >
			<input max type="file" name="file" accept="video/mp4" >
	               	<input type="submit" name="submit">
                 </form>
        	</div> 
	</body>
</html>

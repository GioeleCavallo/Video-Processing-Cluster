<?php 
$servers = explode(",", ini_get("session.save_path"));
$c = count($servers);
for ($i = 0; $i < $c; ++$i) {
    $servers[$i] = explode(":", $servers[$i]);
}
$mem = new Memcached();
$mem->addServers($servers);
?>
<!doctype html>
<html>
<head>
	<link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/css.css" rel="stylesheet" type="text/css">
</head>
<body>
	<h1>SERVER 1</h1>
	<h1 class="title">UPLOAD</h1>
	<hr class="title_divisor">
	<form action="upload.php" method="POST">
		<p>insert token:</p>
		<input type="number" name="id">
		<input type="submit" name="submitToken">
	</form>
	<div class="container" >
		<form method="POST" action="upload.php" enctype="multipart/form-data" class="dropzone" id="dropzonewidget" >
			<input max type="file" name="file" accept="video/mp4" >
	      		<input type="submit" name="submit">
        	</form>
        </div>
</body>
</html>

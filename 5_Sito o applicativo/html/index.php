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
</head>
<body>
	<h1 style="margin: 0px;">SERVER 1</h1>
	<div class="main">
		<div>
			<h1 class="title">UPLOAD</h1><hr class="title_divisor"><br>
			<form action="upload.php" method="POST" class="subContainer">
				<input type="number" name="id" placeholder="Inserire un token:" min="0" max="9999999999" class="other">
				<input type="submit" name="submitToken" value="Mostra" id="show">
			</form>
		</div>
		<br>
		<div>
			<form method="POST" action="upload.php" class="subContainer">
				<input type="file" name="file" accept="video/mp4" class="other">
	     		<input type="submit" name="submit" value="Invia" id="send">
        	</form>
        </div>
	</div>
</body>
</html>
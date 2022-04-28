<?php
if(!isset($_SESSION["FILE_PATH"])){
    session_start();
}
echo isset($_SESSION) ? "true": "false";
echo "<br><br>";
var_dump($_SESSION["FILE_PATH"]);
if(isset($_POST["in"])){
	session_destroy();
}
?>
<html>
<body>
<form action="session.php" method="POST">
<input type="submit" id="in" name="in">
</form>
</body>
</html>

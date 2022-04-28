<?php
global $token;
$servers = explode(",", ini_get("session.save_path"));
$c = count($servers);
for ($i = 0; $i < $c; ++$i) {
    $servers[$i] = explode(":", $servers[$i]);
}
$mem = new Memcached();
$mem->addServers($servers);

$handlerInfo = fopen("/var/www/log/info.log","a");
$handlerError = fopen("/var/www/log/error.log","a");
$txt = "";

if (isset($_POST["submit"])) {
    $time = time();
    $target_dir = "upload/";
    $filename = str_replace(" ", "_", $time . '_' . basename($_FILES["file"]["name"]));
    $target_file = $target_dir . $time . "/" . $filename;
    $uploadOk = 1;
    $maxSize = 50000000;
    if ((strtolower(pathinfo($target_file, PATHINFO_EXTENSION))) != "mp4") {
        echo "File is not a video!<br>";
        $uploadOk = 0;
    }
    if ($_FILES['file']['size'] > $maxSize) {
        echo "File is too large!  <br>";
        $uploadOk = 0;
    }
    if (!file_exists($target_dir)) {
        echo "Folder: $target_dir created successfully!<br>";
        mkdir($target_dir, 0777, true);
    }
    if ($uploadOk == 1) {
        if (!file_exists("$target_dir$time/")) {
            mkdir("$target_dir$time/", 0777, true);
            chmod("$target_dir$time/", 0777);
        }
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["file"]["tmp_name"])) . " has been uploaded.<br>";
            $target_txt = "$target_dir$time/testo.txt";
            $shell_exec_video = "sh cmd.sh '$target_file' '$target_txt' '$target_dir$time/'";
            echo shell_exec($shell_exec_video);
            $comandoPerPermessiCartella = "chmod 777 -R $target_dir$time/";
            echo shell_exec("$comandoPerPermessiCartella");
            $GLOBALS["token"] = $time;
            $mem->add($GLOBALS["token"], $time);
			$txt = date("d.m.y H:i:s")." : INFO : file ".$time." uploaded from ".$_SERVER['REMOTE_ADDR'] . PHP_EOL;
			fwrite($handlerInfo,$txt);
            require "stats/stats.php";
        } else {
			$txt = date("d.m.y H:i:s")." : ERROR : failed upload of ".$time." from ".$_SERVER['REMOTE_ADDR'] . PHP_EOL;
			fwrite($handlerError,$txt);
            echo "Sorry, there was an error uploading your file.<br>";
        }
    } else {
        echo "Please try again!<br>";
    }
} elseif (isset($_POST["submitToken"])) {
    $GLOBALS["token"] = $mem->get($_POST["id"]);
    echo "$value<br>";
    if ($GLOBALS["token"] != $null) {
        echo "it works";
        require "stats/stats.php";
        echo "ok";
    } else {
        echo "non ok";
    }
}
fclose($handler);

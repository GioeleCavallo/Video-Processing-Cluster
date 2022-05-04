<?php
global $token;

// gets all the memcached servers listening from the php.ini .
$servers = explode(",", ini_get("session.save_path"));
$c = count($servers);
for ($i = 0; $i < $c; ++$i) {
    $servers[$i] = explode(":", $servers[$i]);
}

$mem = new Memcached();
$mem->addServers($servers);

$error_dir = "error/";

$handlerInfo = fopen("/var/www/log/info.log","a");
$handlerError = fopen("/var/www/log/error.log","a");
$txt = "";

// check if the submit button is setted, else check if the submit token is setted.
if (isset($_POST["submit"])) {

    $time = time();
    $target_dir = "upload/";
    $filename = str_replace(" ", "_", $time . '_' . basename($_FILES["file"]["name"]));
    $target_file = $target_dir . $time . "/" . $filename;
    $uploadOk = 1;
    $maxSize = 50000000;

    // opena error page if file is not a mp4.
    if ((strtolower(pathinfo($target_file, PATHINFO_EXTENSION))) != "mp4") { 
        require $error_dir."file_not_video.html";
        $uploadOk = 0;
    }

    // open error page if file size is greater than the maxSize.
    if ($_FILES['file']['size'] > $maxSize) {
        require $error_dir."file_too_large.html";
        $uploadOk = 0;
    }

    // if the dir not exists, it creates it.
    if (!file_exists($target_dir)) {
       	mkdir($target_dir, 0777, true);
    }


    if ($uploadOk == 1) {

        // give permissions to the folder to make it readable and writable.
        if (!file_exists("$target_dir$time/")) {
            mkdir("$target_dir$time/", 0777, true);
            chmod("$target_dir$time/", 0777);
        }

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

            // this is the path to the txt file that ontains all the information needed to create the statistics
            $target_txt = "$target_dir$time/testo.txt";
            $shell_exec_video = "sh cmd.sh '$target_file' '$target_txt' '$target_dir$time/'";
            
            // the cmd.sh file is executed, which creates statistics on the file and the various mp4s.
            echo shell_exec($shell_exec_video);
            $comandoPerPermessiCartella = "chmod 777 -R $target_dir$time/";
            
            echo shell_exec("$comandoPerPermessiCartella");
            
            $GLOBALS["token"] = $time;
            $mem->add($GLOBALS["token"], $time);
			
            // write info upload on log.
            $txt = date("d.m.y H:i:s")." : INFO : file ".$time." uploaded from ".$_SERVER['REMOTE_ADDR'] . PHP_EOL;
			fwrite($handlerInfo,$txt);
            
            require "stats/stats.php";
        } else {

            // write error failed upload on log.
			$txt = date("d.m.y H:i:s")." : ERROR : failed upload of ".$time." from ".$_SERVER['REMOTE_ADDR'] . PHP_EOL;
			fwrite($handlerError,$txt);
            require $error_dir."upload_failed.html";
        }
    } else {
        require $error_dir."try_again.html";
    }
} elseif (isset($_POST["submitToken"])) {
    $GLOBALS["token"] = $mem->get($_POST["id"]);
    if ($GLOBALS["token"] != $null) {
        require "stats/stats.php";
    } else {
        require $error_dir."invalid_token.html";
    }
}
fclose($handler);


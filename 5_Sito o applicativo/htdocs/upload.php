<?php
//echo "in";
$time = time();
$target_dir = "upload/";
$filename = $time.'_'.basename($_FILES["file"]["name"]);
$target_file = $target_dir.$time."/".$filename;
$uploadOk = 1;
$maxSize = 500000000;
echo "fatto";
//var_dump($_FILES);
if(isset($_POST["submit"])){
    if($_FILES["file"]["type"] != "video/mp4"){
        echo "File is not a video!<br>";
        $uploadOk = 0;
    }
    if($_FILES['file']['size'] > $maxSize){
        echo "File is too large!  <br>";
        $uploadOk = 0;
    }
    if(!file_exists($target_dir)){
        echo "Folder: $target_dir created successfully!<br>";
        mkdir($target_dir, 0777, true);
    }
    if($uploadOk == 1){
        if(!file_exists("$target_dir$time/")){
            echo "Folder: $target_dir$time/ created successfully!<br>";
            mkdir("$target_dir$time/", 0777, true);
            chmod("$target_dir$time/", 0777);
        }
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
            echo "The file ".htmlspecialchars(basename($_FILES["file"]["tmp_name"]))." has been uploaded.<br>";
            $target_txt = "$target_dir$time/_testo.txt";

	    echo shell_exec("sh cmd.sh $target_file $target_txt $target_dir$time/");

            $comandoPerPermessiCartella = "chmod 777 -R $target_dir$time/";
            echo shell_exec("$comandoPerPermessiCartella");
		echo "funzia";
		$FILE_PATH = $target_txt.".csv";
		$DIR_PATH = "$time/";
		global $FILE_PATH;
		global $DIR_PATH;
	    // apertura statistiche


	    include "stats/stats.php";

	}else{
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }else{
        echo "Please try again!<br>";
    }

}else{
    require "index.php";
    echo "remember, only file less than 500 MB!";
}

?>

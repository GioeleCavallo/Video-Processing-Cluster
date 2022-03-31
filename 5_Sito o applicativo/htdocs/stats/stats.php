<?php
#####Dati

//echo "in";
function getCsv(){
    $nomeFile = $GLOBALS["FILE_PATH"];
    $data = array();
    if(($handle = fopen($nomeFile, "r")) !== false){
        while(($subData = fgetcsv($handle, 4096, ",")) !== false){
            $data[] = $subData;
        }
        fclose($handle);
    }
    return $data;
}
$data = getCsv();
//echo "<br>".getcwd()."<br>";

#####dati statistiche
$quantitaB = 0;
$quantitaI = 0;
$quantitaP = 0;
$colorsBar = array();
$sizeBar = array();
for($i = 0;$i < COUNT($data); $i++){
    for($j = 0;$j < COUNT($data[$i]); $j++){
		if($j == 17 && $i != 0){
			if($data[$i][$j] == 'B'){
				$quantitaB++;
				$colorsBar[] = "yellow";
			}elseif($data[$i][$j] == 'I'){
				$quantitaI++;
				$colorsBar[] = "red";
            }else{
				$quantitaP++;
				$colorsBar[] = "green";
            }
        }
    }
}

$timeStamp = array();
for($i = 2;$i < COUNT($data); $i++){
    //for($j = 0;$j < COUNT($data[$i]); $j++){
	//	if($j == 4 && $i != 0){
			$timeStamp[] = $data[$i][4];
			$sizeBar[] = $data[$i][12];
	//	}
	//}
}

#####stampa dei dati statistiche
$totale = $quantitaB+$quantitaI+$quantitaP;
$B = round($quantitaB/$totale*100);
$I = round($quantitaI/$totale*100);
$P = round($quantitaP/$totale*100);
?>

<head>
        <!--<link rel="stylesheet" href="css/css.css" />-->
</head>

<html>



<body>
        <div id="center">
                <h1 id="title">Statistics</h1>
                <hr id="title_divisor">
                <div>
                                <?php
                                echo "Frame B: $B %<br>";
                                echo "Frame I: $I %<br>";
                                echo "Frame P: $P %<br>";
                                ?>
								<script src="stats/Chart.js"></script>

								<div id="containerPie" style="display:block;max-width:25%;height:auto;margin-left:25%;margin-bottom:5%">
									<canvas id="myChart"></canvas>
								</div>
								<div id="containerPie" style="display:block;max-width:50%;height:auto;margin-left:25%;margin-top:5%">
									<canvas id="frequencyChart"></canvas>
								</div>
                                <script>
										// percentige
                                        var xValues = ["Frame: B", "Frame: I", "Frame: P"];
                                        var yValues = [<?php echo $quantitaB;?>, <?php echo $quantitaI;?>, <?php echo $quantitaP;?>];
                                        var barColors = ["gray","lightgray","Black"];
                                        new Chart("myChart", {
                                                type: "pie",
                                                data: {
                                                        labels: xValues,
                                                        datasets: [{
                                                                backgroundColor: barColors,
                                                                data: yValues
                                                        }]
                                                },
                                                options: {
                                                        title: {
                                                                display: true,
                                                                text: "Frequency Frame"
                                                        }
                                                }
                                        });
					// bar
					var xValuesBar = [<?php
					$max = COUNT($timeStamp);
					for($i = 0;$i < $max; $i++){
						if($i == $max -1){
							echo "$timeStamp[$i]";
						}else{
							echo "$timeStamp[$i], ";
						}
					}
					?>];
                                        var yValuesBar = [<?php
					$max = COUNT($sizeBar);
					for($i = 0;$i < $max; $i++){
						if($i == $max -1){
							echo "$sizeBar[$i]";
						}else{
							echo "$sizeBar[$i], ";
						}
					}
					?>];
					var barColors = [<?php
					$max = COUNT($colorsBar);
					for($i = 0;$i < $max; $i++){
						if($i == $max -1){
							echo "\"$colorsBar[$i]\"";
						}else{
							echo "\"$colorsBar[$i]\", ";
						}
					}
					?>];

					new Chart("frequencyChart", {
						type: "bar",
						data: {
							labels: xValuesBar,
							datasets: [{
								backgroundColor: barColors,
								data: yValuesBar
							}]
						},
						options: {
							legend: {display: false},
							title: {
								display: true,
								text: "Frequency"
							}
						}
					});
                		</script>
                </div>
				<div style="margin:10%">
					<br>
					<h1 id="title">Settings</h1>
					<hr id="title_divisor">
					<div id="drop_not_file_zone">
							<form action="action_page.php">
									<!--<input type="checkbox" id="change1" name="change1" value="change1">-->
									<label for="change1"><a href='<?php echo "./upload/".$GLOBALS["DIR_PATH"]."motion.mp4" ?>'>Motion vector</a></label><br>

									<!--<input type="checkbox" id="change2" name="change2" value="change2">-->
									<label for="change2"><a href='<?php echo "./upload/".$GLOBALS["DIR_PATH"]."I_frames.mp4" ?>'>Recreate with only frames I</a></label><br>
									<!--<input type="checkbox" id="change3" name="change3" value="change3">-->
									<label for="change2"><a href='<?php echo "./upload/".$GLOBALS["DIR_PATH"]."B_frames.mp4" ?>'>Recreate with only frames B</a></label><br>
									<label for="change2"><a href='<?php echo "./upload/".$GLOBALS["DIR_PATH"]."P_frames.mp4" ?>'>Recreate with only frames P</a></label><br>

									<label for="change3"><a href='<?php echo "./upload/".$GLOBALS["DIR_PATH"]."zip.zip" ?>'>Download Zip with all the frames</a></label><br><br>

									<!--<input type="submit" value="Download">-->
							</form>
					</div>
					<br>
				</div>
		</div>
</body>

</html>


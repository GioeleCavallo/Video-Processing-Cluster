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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link href="../css/stats.css" rel="stylesheet" >
</head>

<html>


<header>
	<h6>your access token: <?php echo "123123123";?></h6>
</header>
<body>
	<div id="center">
			
		<div class="title-container">
			<h1 class="title">Statistics</h1>
			
			<hr class="title_divisor">
			<table>
				<tr>
					<th colspan="2" align="center">Legenda</th>
				</tr>
				<tr>
					<td><?php echo "Frame B<br>"; ?></td>
					<td><?php echo " $B %<br>"; ?></td>
				</tr>
				<tr>
					<td><?php echo "Frame I<br>"; ?></td>
					<td><?php echo " $I %<br>"; ?></td>
				</tr>
				<tr>
					<td><?php echo "Frame P<br>"; ?></td>
					<td><?php echo " $P %<br>"; ?></td>
				</tr>

			</table>

			<script src="Chart.js"></script>

			<div id="containerPie" >
				<canvas id="pieChart"></canvas>
			</div>
			<br>
			<br>
			<br>
			<br>
			<div id="containerPie" >
				<canvas id="frequencyChart"></canvas>
			</div>
			<script>
				// percentige
				var xValues = ["Frame: B", "Frame: I", "Frame: P"];
				var yValues = [<?php echo $quantitaB; ?>, <?php echo $quantitaI; ?>, <?php echo $quantitaP; ?>];
				var barColors = ["red", "green", "blue"];
				var options_char = {
					title: {
						display: true,
						text: "Frequency Frame"
					},
				};
				var ctx = document.getElementById("pieChart").getContext('2d');
				new Chart(ctx, {
					type: "pie",
					data: {
						labels: xValues,
						datasets: [{
							backgroundColor: barColors,
							data: yValues
						}]
					},
					options: options_char,
					});
				// bar
				var xValuesBar = [<?php
									$max = COUNT($timeStamp);
									for ($i = 0; $i < $max; $i++) {
										if ($i == $max - 1) {
											echo "$timeStamp[$i]";
										} else {
											echo "$timeStamp[$i], ";
										}
									}
									?>];
				var yValuesBar = [<?php
									$max = COUNT($sizeBar);
									for ($i = 0; $i < $max; $i++) {
										if ($i == $max - 1) {
											echo "$sizeBar[$i]";
										} else {
											echo "$sizeBar[$i], ";
										}
									}
									?>];
				var barColors = [<?php
									$max = COUNT($colorsBar);
									for ($i = 0; $i < $max; $i++) {
										if ($i == $max - 1) {
											echo "\"$colorsBar[$i]\"";
										} else {
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
						legend: {
							display: false
						},
						title: {
							display: true,
							text: "Frequency"
						}
					}
				});
			</script>
		</div>
		<div class="title-container">
			<br>
			<h1 class="title">Download</h1>
			<hr class="title_divisor">
			<div id="drop_not_file_zone">
				<ul>
					<li><label for="change1"><a href='<?php echo $filePath . "motion.mp4" ?>'>Motion vector</a></label></li>
					<li><label for="change2"><a href='<?php echo $filePath . "I_frames.mp4" ?>'>Recreate with only frames I</a></label></li>
					<li><label for="change2"><a href='<?php echo $filePath . "B_frames.mp4" ?>'>Recreate with only frames B</a></label></li>
					<li><label for="change2"><a href='<?php echo $filePath . "P_frames.mp4" ?>'>Recreate with only frames P</a></label></li>

					<li><label for="change3"><a href='<?php echo $filePath . "zip.zip" ?>'>Download Zip with all the frames</a></label></li>
				</ul>
			</div>
			<br>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>


<?php
$filePath = "upload/" . $GLOBALS["token"] . "/";

// return the data of the CSV.
function getCsv($filePath) {
    $nomeFile = $filePath . "testo.txt.csv";
    $data = array();

    if (($handle = fopen($nomeFile, "r")) !== false) {
        while (($subData = fgetcsv($handle, 4096, ",")) !== false) {
            $data[] = $subData;
        }
        fclose($handle);
    }

    return $data;
}

$data = getCsv($filePath);

// get the info about the data.
// get count of frame I, B, P and set a different color for each type of frame.
$quantitaB = 0;
$quantitaI = 0;
$quantitaP = 0;
$colorsBar = array();
$sizeBar = array();

for ($i = 0; $i < COUNT($data); $i++) {
    for ($j = 0; $j < COUNT($data[$i]); $j++) {
        if ($j == 17 && $i != 0) {
            if ($data[$i][$j] == 'B') {
                $quantitaB++;
                $colorsBar[] = "red";
            } elseif ($data[$i][$j] == 'I') {
                $quantitaI++;
                $colorsBar[] = "green";
            } else {
                $quantitaP++;
                $colorsBar[] = "blue";
            }
        }
    }
}


// get the timestamp information about each frame.
$timeStamp = array();
for ($i = 2; $i < COUNT($data); $i++) {
    $timeStamp[] = $data[$i][4];
    $sizeBar[] = $data[$i][12];
}


$totale = $quantitaB + $quantitaI + $quantitaP;
$B = round($quantitaB / $totale * 100);
$I = round($quantitaI / $totale * 100);
$P = round($quantitaP / $totale * 100);
?>
<head>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/stats.css" rel="stylesheet" >
</head>

<html>


    <header>
        <h6>your access token: <?php echo $GLOBALS["token"]; ?></h6>
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

                <script src="stats/Chart.js"></script>

                <div id="containerPie"> 
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
                    // set the data for the pie chart.
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
                    var xValuesBar = [
                        <?php
                            $max = COUNT($timeStamp);
                            for ($i = 0; $i < $max; $i++) {
                                if ($i == $max - 1) {
                                    echo "$timeStamp[$i]";
                                } else {
                                    echo "$timeStamp[$i], ";
                                }
                            }
                        ?>
                            ];
                    var yValuesBar = [
                        <?php
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
    </body>

</html>

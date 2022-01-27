<!--
* Questa è il la pagina per aggiungere una fattura.
-->
<head><style><?php include 'style.css'; ?></style></head>

<body>

	<header>
		<div class="header" align="center">
			<div class="topnav_left">
				<a id="Email" href="<?php echo URL."Amministratori"?>"><?php echo $_SESSION['email']?></a>
			</div>
			<div class="topnav_center">
				<a id="Title" disabled="true"> Lavoro Temporaneo - creazione fatturazione</a>
			</div>
			<div class="topnav_right">
				<a id="Esci" href="<?php echo URL."Amministratori/esci"?>">LogOff</a>
			</div>
		</div>
	</header>

    <br>

    <main class="main">
	<div align="center">
				<div class="top_center">
					<button name="visualizzaFattura" style="width:100%; cursor: pointer;" 
					onclick="document.location='<?php echo URL.'Amministratori/'?>'">Home Amministrazione</button>
    			</div>
	    	</div>
		<div align="center">
			<div class="top_center">
				<h3 style="width:100%;">Crea una nuova Fattura</h3>
    		</div>
		</div>
		<div align="center">
			<div class="top_center">
				<?php if ($this->data->num_rows > 0) { $i=0;?>
					<table>
						<tr>
							<th style="display: none"> id </th>
							<th> datore </th>
							<th> lavoratore </th>
							<th> titolo </th>
							<th> descrizione </th>
							<th> tariffa oraria </th>
							<th> ore di lavoro </th>
							<th> data </th>
							<th> occupato </th>
							<th> scaduto </th>
							<th> crea fattura </th>
						</tr>
						<?php while($row = $this->data->fetch_assoc()) { ?>
						<tr><form method="POST" action="<?php echo URL;?>Amministratori/calcolaFattura/<?php echo $row['id']."/".$row['datore_email']."/".$row['lavoratore_email'];?>">
							<td style="display: none"><input type="text" value="<?php echo $row['id']; ?>" name='id'></td>
							<td><input style="width: 100%" type="text" value="<?php echo $row['datore_email']; ?>" name='datore_email'></td>
							<td><input style="width: 100%" type="text" value="<?php echo $row['lavoratore_email']; ?>" name='lavoratore_email'></td>
							<td><input style="width: 100%" type="text" value="<?php echo $row['titolo']; ?>" name='titolo'></td>
							<td><input style="width: 100%" type="text" value="<?php echo $row['descrizione']; ?>" name='descrizione'></td>
							<td><input style="width: 100%" type="text" value="<?php echo $row['tariffaOraria']; ?>" name='tariffaOraria'></td>
							<td><input style="width: 100%" type="text" value="<?php echo $row['oreDiLavoro']; ?>" name='oreDiLavoro'></td>
							<td><input style="width: 100%" type="text" value="<?php echo date('d-m-Y H:i:s',strtotime($row['data'])); ?>" name='data'></td>
							<td><input style="width: 100%" type="text" value="<?php echo $row['occupato']; ?>" name='occupato'></td>
							<td><input style="width: 100%" type="text" value="<?php echo $row['scaduto']; ?>" name='scaduto'></td>
							<td><input style="width: 100%" type='submit' value='CALCOLA FATTURAZIONE (<?php echo $i+1?>)' name='M'></td>
						</form></tr>
						<?php $i++; } ?>
					</table>
				<?php }else{ ?>
					<?php echo "non ci sono lavori da fatturare"; ?>
				<?php } ?>
    		</div>
		</div>
		<div align="center">
			<div class="top_center">
				<h3 style="width:100%;">Visualizza tutte le fatture</h3>
    		</div>
		</div>
		<div align="center">
			<div class="top_center">
				<?php if ($this->allData->num_rows > 0) { $i=0;?>
					<table>
						<tr>
							<th> data </th>
							<th> datore </th>
							<th> lavoratore </th>
							<th> totale </th>
						</tr>
						<?php while($row = $this->allData->fetch_assoc()) { ?>
						<tr>
							<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo date('d-m-Y H:i:s',strtotime($row['data'])); ?>" name='data'></td>
							<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['datore_email']; ?>" name='datore_email'></td>
							<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['lavoratore_email']; ?>" name='lavoratore_email'></td>
							<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['totale']; ?> Fr" name='totale'></td>
						</tr>
						<?php $i++; } ?>
					</table>
				<?php }else{ ?>
					<?php echo "non ci sono fatture da visualizzare"; ?>
				<?php } ?>
    		</div>
		</div>
	</main>
</body>
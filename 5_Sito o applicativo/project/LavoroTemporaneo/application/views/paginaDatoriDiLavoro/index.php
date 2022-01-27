<!--
* Questa è il la pagina per i datori di lavoro.
-->
<head><style><?php include 'style.css'; ?></style></head>

<body>

    <header>
	    <div class="header" align="center">
			<div class="topnav_left">
				<a id="Email" href="<?php echo URL."DatoriDiLavoro"?>"><?php echo $_SESSION['email']?></a>
			</div>
			<div class="topnav_center">
			    <a id="Title" disabled="true"> Lavoro Temporaneo (datore di lavoro)</a>
    		</div>
			<div class="topnav_right">
				<a id="Esci" href="<?php echo URL."DatoriDiLavoro/esci"?>">LogOff</a>
			</div>
	    </div>
    </header>

    <br>

    <main class="main">
			<div align="center">
				<div class="top_center">
					<form method="POST" action="<?php echo URL;?>DatoriDiLavoro/aggiungiOffertaDiLavoro">
						<button name="aggiungiLavoro" style="width:100%; cursor: pointer;">Aggiungi offerta di lavoro</button>
					</form>
				</div>
	    	</div>
			<div align="center">
				<div class="top_center">
					<h3 style="width:100%;">Le mie offerte di lavoro</h3>
    			</div>
			</div>
			<div align="center">
				<div class="top_center">
					<?php if ($this->data->num_rows > 0) { $i=0;?>
						<table>
							<tr>
								<th> titolo </th>
								<th style="display: none"> id </th>
								<th style="display: none"> datore </th>
								<th> lavoratore </th>
								<th> descrizione </th>
								<th> tariffa oraria </th>
								<th> ore di lavoro </th>
								<th style="display: none"> occupato </th>
								<th style="display: none"> scaduto </th>
								<th> modifica </th>
								<th> elimina </th>
							</tr>
							<?php while($row = $this->data->fetch_assoc()) { ?>
							<tr><form method="POST" action="<?php echo URL;?>DatoriDiLavoro/esegui/<?php echo $i;?>">
								<?php if($row['occupato'] == 0){ ?>
									<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['titolo']; ?>" name='titolo'></td>
									<td style="display: none"><input type="text" value="<?php echo $row['id']; ?>" name='id'></td>
									<td style="display: none"><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['datore_email']; ?>" name='datore_email'></td>
									<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['lavoratore_email']; ?>" name='lavoratore_email'></td>
									<td><input style="width: 100%" type="text" value="<?php echo $row['descrizione']; ?>" name='descrizione'></td>
									<td><input style="width: 100%" type="text" value="<?php echo $row['tariffaOraria']; ?>" name='tariffaOraria'></td>
									<td><input style="width: 100%" type="text" value="<?php echo $row['oreDiLavoro']; ?>" name='oreDiLavoro'></td>
									<td style="display: none"><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['occupato']; ?>" name='occupato'></td>
									<td style="display: none"><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['scaduto']; ?>" name='scaduto'></td>
									<td><input style="width: 100%" type='submit' value='MODIFICA OFFERTA (<?php echo $i+1?>)' name='M'></td>
									<td><input style="width: 100%" type='submit' value='ELIMINA OFFERTA (<?php echo $i+1?>)' name='E'></td>
								<?php }else{ ?>
									<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['titolo']; ?>" name='titolo'></td>
									<td style="display: none"><input type="text" value="<?php echo $row['id']; ?>" name='id'></td>
									<td style="display: none"><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['datore_email']; ?>" name='datore_email'></td>
									<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['lavoratore_email']; ?>" name='lavoratore_email'></td>
									<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['descrizione']; ?>" name='descrizione'></td>
									<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['tariffaOraria']; ?>" name='tariffaOraria'></td>
									<td><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['oreDiLavoro']; ?>" name='oreDiLavoro'></td>
									<td style="display: none"><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['occupato']; ?>" name='occupato'></td>
									<td style="display: none"><input class="disabled" readonly="true" style="width: 100%" type="text" value="<?php echo $row['scaduto']; ?>" name='scaduto'></td>
									<td><input class="disabled" readonly="true" style="width: 100%" type='submit' value='MODIFICA OFFERTA (<?php echo $i+1?>)' name='M'></td>
									<td><input style="width: 100%" type='submit' value='ELIMINA OFFERTA (<?php echo $i+1?>)' name='E'></td>
								<?php } ?>
							</form></tr>
							<?php $i++; } ?>
						</table>
					<?php }else{ ?>
						<?php echo "non hai ancora pubblicato un lavoro"; ?>
					<?php } ?>
    			</div>
			</div>
			<div align="center">
				<div class="top_center">
					<h3 style="width:100%;">Vedi tutte le richieste disponibili</h3>
    			</div>
			</div>
			<div align="center">
				<div class="top_center">
					<?php if($this->allData->num_rows > 0){ $i=1;?>
						<table>
						<tr>
							<th> titolo </th>
							<th style="display: none"> lavoro_id </th>
							<th> lavoratore </th>
							<th> descrizione </th>
							<th> allegati </th>
							<th> data </th>
							<th> accetta una richiesta </th>
							<th> rifiuta una richiesta </th>
						</tr>
						<?php while($row = $this->allData->fetch_assoc()){ ?>
							<tr><form method="POST" 
							action="<?php echo URL;?>DatoriDiLavoro/accettaORifiutaRichiestaDiLavoro/<?php echo $row['lavoro_id']."/".$row['data']."/".$row['lavoratore_email']; ?>/">
								<td><?php echo $row['titolo']; ?></td>
								<td style="display: none"><?php echo $row['lavoro_id']; ?></td>
								<td ><?php echo $row['lavoratore_email']; ?></td>
								<td><?php echo $row['descrizione']; ?></td>
								<td><?php echo $row['allegati']; ?></td>
								<td><?php echo date('d-m-Y H:i:s',strtotime($row['data'])); ?></td>
								<td><input style="width: 100%" type='submit' value='accetta la richiesta numero (<?php echo $i?>)' name='A'></td>
								<td><input style="width: 100%" type='submit' value='rifiuta la richiesta numero (<?php echo $i?>)' name='R'></td>
							</form></tr>
						<?php } ?>
						</table>
					<?php } else { ?>
						<?php echo "non hai ancora ricevuto un offerta per un lavoro";?>
					<?php } ?>
				</div>
			</div>
    </main>
</body>
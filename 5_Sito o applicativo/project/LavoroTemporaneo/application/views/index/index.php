<!--
* Questa è il la pagina inedx del applicativo.
-->
<head><style><?php include 'style.css'; ?></style></head>

<body>

	<header>
		<div class="header" align="center">
			<div class="topnav_left">
				<a id="Accedi" href="Accesso">Accedi</a>
			</div>
			<div class="topnav_center">
				<a id="Title" disabled="true"> Lavoro Temporaneo</a>
			</div>
			<div class="topnav_right">
				<a id="Registrati" href="Registrazione">Registrati</a>
			</div>
		</div>
	</header>

	<br>
	
	<main>
		<div align="center">
			<div class="top_center">
				<h3 style="width:100%;">Lavori offerti</h3>
    		</div>
		</div>
		<div align="center">
			<div class="top_center">
				<?php if($this->data->num_rows > 0){ ?>
					<table>
					<tr>
						<th style="display: none"> id </th>
						<th style="display: none"> datore </th>
						<th style="display: none"> lavoratore </th>
						<th> TITOLO </th>
						<th> DESCRIZIONE </th>
						<th> TARIFFA ORARIA </th>
						<th style="display: none"> occupato </th>
						<th style="display: none"> scaduto </th>
						<th> ORE DI LAVORO </th>
					</tr>
					<?php while($row = $this->data->fetch_assoc()){ ?>
						<tr>
							<td style="display: none"><?php echo $row['id']; ?></td>
							<td style="display: none"><?php echo $row['datore_email']; ?></td>
							<td style="display: none"><?php echo $row['lavoratore_email']; ?></td>
							<td><?php echo $row['titolo']; ?></td>
							<td><?php echo $row['descrizione']; ?></td>
							<td><?php echo $row['tariffaOraria']; ?> Fr</td>
							<td style="display: none"><?php echo $row['occupato']; ?></td>
							<td style="display: none"><?php echo $row['scaduto']; ?></td>
							<td><?php echo $row['oreDiLavoro']; ?> ora/e</td>
						</tr>
					<?php } ?>
					</table>
				<?php } else { ?>
					<?php echo "Al momento non ci sono risultati";?>
				<?php } ?>
			</div>
		</div>
	</main>

</body>
<!--
* Questa è il la pagina per aggiungere una richiesta lavorativa.
-->
<head><style><?php include 'style.css'; ?></style></head>

<body>

	<header>
		<div class="header" align="center">
			<div class="topnav_left">
				<a id="Email" href="<?php echo URL."DatoriDiLavoro"?>"><?php echo $_SESSION['email']?></a>
			</div>
			<div class="topnav_center">
				<a id="Title" href="<?php echo URL;?>Lavoratori"> Lavoro Temporaneo - aggiungi richiesta di lavoro</a>
			</div>
			<div class="topnav_right">
				<a id="Esci" href="<?php echo URL."DatoriDiLavoro/esci"?>">LogOff</a>
			</div>
		</div>
	</header>

    <br>

    <main>
		<form method="POST" action='<?php echo URL."Lavoratori/aggiungi"?>'>

			<label>Email</label><br>
			<input class="disabled" name="email" type="email" size="50" value="<?php echo $_SESSION['email'];?>" readonly="true">
			<br>

			<label>Titolo</label><br>
			<input class="disabled" name="titolo" type="text" size="50" value="<?php echo $this->titolo;?>" readonly="true">
			<br>

			<label>Descrizione</label><br>
			<input name="descrizione" type="textarea" size="50" value="Descrizione per il <?php echo $this->titolo;?>">
			<br>

			<label>Allegati</label><br>
			<input name="allegati" type="file" size="50" value="Nessun file è ancora stato selezionato">
			<br>

			<label style="display:none;">OffertaDiLavoroId</label><br>
			<input style="display:none;" class="disabled" name="id" type="number" size="50" value="<?php echo $this->id;?>" readonly="true">

			<input name="conferma" type="submit" value="Conferma">
		</form>
	</main>
</body>
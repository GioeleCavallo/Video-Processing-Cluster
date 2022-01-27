<!--
* Questa è il la pagina per l' accesso.
-->
<head><style><?php include 'style.css'; ?></style></head>

<body>

	<header>
		<div class="header" align="center">
			<div class="topnav_center">
				<a id="Title" href="<?php echo URL;?>"> Lavoro Temporaneo - form di accesso</a>
			</div>
		</div>
	</header>

    <br>

    <main>
		<form method="POST" action='<?php echo URL."Accesso/test"?>'>

			<label>Email</label><br>
			<input name="email" type="email" size="50">
			<br>
	
			<label>Password</label><br>
			<input name="password" type="password" size="50">
			
			<p>Non hai ancora un account? <a href="<?php echo URL."Accesso/reRender"?>">Registrati</a></p>

			<input name="conferma" type="submit" value="Conferma">
		</form>
	</main>
</body>
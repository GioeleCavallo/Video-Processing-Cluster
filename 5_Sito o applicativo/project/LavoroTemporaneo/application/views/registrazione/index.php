<!--
* Questa è il la pagina per la registrazione.
-->
<head><style><?php include 'style.css'; ?></style></head>

<body>

    <header>
	    <div class="header" align="center">
		    <div class="topnav_center">
			    <a id="Title" href="<?php echo URL;?>"> Lavoro Temporaneo - form di registrazione</a>
    		</div>
	    </div>
    </header>

    <br>

    <main>
	    <form method="POST" action='<?php echo URL."Registrazione/test"?>'>

	    	<label>Email</label><br>
		    <input name="email" type="email" size="50">
	    	<br>
	
	    	<label>Password</label><br>
	    	<input name="password" type="password" size="50">
	    	<br>
		
	    	<label for="ruolo">Ruolo</label><br>
	    	<select name="ruolo" style="width:330px">
	    		<option value="lavoratore">Lavoratore</option>
	    	    <option value="datore">Datore</option>
	     	</select>
			 <br>

			 <p>Hai già un account? <a href="<?php echo URL."Registrazione/reRender"?>">Accedi</a></p>
			 
		    <input name="conferma" type="submit" value="Conferma">
	    </form>
    </main>
</body>
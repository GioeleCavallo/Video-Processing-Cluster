<?php

// starto la sessione
session_start();

// carico il file di configurazione
require 'application/config/config.php';

// carico le classi di libreria per l'applicazione
require 'application/libs/application.php';

// carico le classi di libreria per l'applicazione
require 'application/libs/View.php';

// carico le classi di libreria per l'applicazione
require 'application/libs/Controller.php';

// carico le classi di libreria per l'applicazione
require 'application/libs/Model.php';

// faccio partire l'applicazione
$app = new Application();

?>
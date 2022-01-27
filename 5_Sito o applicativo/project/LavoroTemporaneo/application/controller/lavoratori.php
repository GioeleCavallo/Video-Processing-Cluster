<?php

class Lavoratori extends Controller{

    function __construct(){
        parent::__construct();
    }
    
    /*
    * Il metodo index, della classe Lavoratori permette di renderizzare 
    * alla pagina deilavoratori se si è loggati altrimenti si viene
    * renderizzati alla pagina di accesso.
    */
    function index(){
        require 'application/controller/session.php';
        $session = new Session();
        if($session->isLogged() && $_SESSION['nomeRuolo'] == 'lavoratore'){
            require 'application/models/lavoratori_model.php';
            $model = new Lavoratori_Model();
            $data = $model->getRischiesteLavori();
            $this->view->data = $data;
            $allData = $model->getLavoriNonOccupati();
            $this->view->allData = $allData;
            $this->view->render("paginaLavoratori/index");
        }else{
            header('Location: '.URL."Accesso");
        }
    }

    /*
    * Il metodo modifica, della classe Lavoratori permette di modificare 
    * una richieste di lavoro, questo metodo riceve un parametro numerico e non
    * restituisce niente.
    */
    function modifica($i){
        require 'application/models/lavoratori_model.php';
        $model = new Lavoratori_Model();
        $data = date('Y-m-d H:i:s',strtotime($_POST['data']));
        $lavoro_id = $_POST['lavoro_id'];
        $lavoratore_email = $_POST['lavoratore_email'];
        $titolo = $_POST['titolo'];
        $descrizione = $_POST['descrizione'];
        $allegati = $_POST['allegati'];
        $archiviato = $_POST['archiviato'];
        $model->modificaRichiestaDiLavoro($data,$lavoro_id,$lavoratore_email,
        $titolo,$descrizione,$allegati,$archiviato);
        header('Location: '.URL."Lavoratori");
    }

    /*
    * Il metodo elimina, della classe Lavoratori permette di eliminare 
    * una richiesta di lavoro, questo metodo riceve un parametro numerico e non 
    * restituisce niente.
    */
    function elimina($data){
        require 'application/models/lavoratori_model.php';
        $model = new Lavoratori_Model();
        $data = date('Y-m-d H:i:s',strtotime($_POST['data']));
        $lavoro_id = $_POST['lavoro_id'];
        $lavoratore_email = $_POST['lavoratore_email'];
        $titolo = $_POST['titolo'];
        $descrizione = $_POST['descrizione'];
        $allegati = $_POST['allegati'];
        $archiviato = "1";
        $model->modificaRichiestaDiLavoro($data,$lavoro_id,$lavoratore_email,
        $titolo,$descrizione,$allegati,$archiviato);
        header('Location: '.URL."Lavoratori");
    }

    /*
    * Il metodo esegui, della classe Lavoratori permette di eseguire un 
    * metodo in base al bottone che è stato schiacciato.
    */
    function esegui($i){
        if(isset($_POST['M'])){
            $this->modifica($i);
        }elseif(isset($_POST['E'])){
            $this->elimina($i);
        }
    }

    /*
    * Il metodo esci, della classe Lavoratori permette di uscire dalla 
    * sessione.
    */
    function esci(){
        session_destroy();
        header('Location: '.URL."Accesso");
    }

    /*
    * Il metodo aggiungiOffertaDiLavoro, della classe Lavoratori permette di 
    * essere renderizzati alla pagina per aggiungere una richiesta ad un lavoro.
    */
    function aggiungiRichiestaDiLavoro($id){
        require 'application/controller/session.php';
        $session = new Session();
        if($session->isLogged()){
            $this->view->id = $id;
            require 'application/models/lavoratori_model.php';
            $model = new Lavoratori_Model();
            $titolo = $model->getTitolo($id);
            $titolo = $titolo->fetch_assoc();
            $this->view->titolo = $titolo['titolo'];
            $this->view->render("aggiungiRichiesta/index");
        }else{
            header('Location: '.URL."Accesso");
        }
    }

    /*
    * Il metodo aggiungi, della classe Lavoratori permette 
    * di aggiungere richiesta ad un lavoro.
    */
    function aggiungi(){
        if(!empty($_POST['titolo'])){
			$titolo = $this->test_input($_POST['titolo']);
		}else{
			$titolo = "Richiesta per il lavoro";
		}
        if(!empty($_POST['descrizione'])){
			$descrizione = $this->test_input($_POST['descrizione']);
		}else{
			$descrizione = "Descrizione della richiesta per il lavoro";
		}
        if(!empty($_POST['allegati'])){
			$allegati = $this->test_input($_POST['allegati']);
		}else{
			$allegati = " ";
		}

        $id = $_POST['id'];
        $email = $_POST['email'];
        $data = null;
        $archiviato = 0;

        require 'application/models/lavoratori_model.php';
        $model = new Lavoratori_Model();
        $result = $model->lavoroNonAncoraEsistente($id, $email, $archiviato);
        if($result->num_rows == 0){
            $model->aggiungiLavoro($data,$id,$email,$titolo,$descrizione,$allegati,$archiviato);
            $titoloLavoro = $model->getLavoro($id);
            $row = $titoloLavoro->fetch_assoc();
            $titolo = $row['titolo'];
            $model->inviaEmailDiConferma($email, $titolo);
        }else{
            echo "richiesta già effettuata";
        }
        header('Location: '.URL."Lavoratori");
    }

    /*
    * Il metodo test_input, della classe Lavoratori riceve una stringa come 
	* parametro e pepermette di validarla, infatti questo metodo ritorna il 
	* risultato di una serie di operazioni per validate la stringa data.
    */
    function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
    
}

?>
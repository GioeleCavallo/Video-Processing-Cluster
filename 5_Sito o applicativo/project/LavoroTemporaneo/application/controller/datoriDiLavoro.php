<?php

class DatoriDiLavoro extends Controller{

    function __construct(){
        parent::__construct();
    }
    
    /*
    * Il metodo index, della classe DatoriDiLavoro permette di renderizzare 
    * alla pagina dei datori di lavoro se si è loggati altrimenti si viene
    * renderizzati alla pagina di accesso.
    */
    function index(){
        require 'application/controller/session.php';
        $session = new Session();
        if($session->isLogged() && $_SESSION['nomeRuolo'] == 'datore'){
            require 'application/models/datoriDiLavoro_model.php';
            $model = new DatoriDiLavoro_Model();
            $data = $model->getLavoriDatoriDiLavoro();
            $this->view->data = $data;
            $allData = $model->getOfferteDiLavoro();
            $this->view->allData = $allData;
            $this->view->render("paginaDatoriDiLavoro/index");
        }else{
            header('Location: '.URL."Accesso");
        }
    }

    /*
    * Il metodo modifica, della classe DatoriDiLavoro permette di modificare 
    * una offerta di lavoro, questo metodo riceve un parametro numerico e non
    * restituisce niente.
    */
    function modifica($i){
        require 'application/models/datoriDiLavoro_model.php';
        $model = new DatoriDiLavoro_Model();
        $id = $_POST['id'];
        $datore_email = $_POST['datore_email'];
        $lavoratore_email = $_POST['lavoratore_email'];
        $titolo = $_POST['titolo'];
        $descrizione = $_POST['descrizione'];
        $tariffaOraria = $_POST['tariffaOraria'];
        $occupato = $_POST['occupato'];
        $scaduto = $_POST['scaduto'];
        $oreDiLavoro = $_POST['oreDiLavoro'];
        $data = $_POST['data'];
        $model->modificaOffertaDiLavoro($id,$datore_email,$lavoratore_email,
        $titolo,$descrizione,$tariffaOraria,$occupato,$scaduto,$oreDiLavoro,$data);
        header('Location: '.URL."DatoriDiLavoro");
    }

    /*
    * Il metodo elimina, della classe DatoriDiLavoro permette di eliminare 
    * una offerta di lavoro, questo metodo riceve un parametro numerico e non 
    * restituisce niente.
    */
    function elimina($i){
        require 'application/models/datoriDiLavoro_model.php';
        $model = new DatoriDiLavoro_Model();
        $id = $_POST['id'];
        $model->eliminaOffertaDiLavoro($id);
        header('Location: '.URL."DatoriDiLavoro");
    }

    /*
    * Il metodo esegui, della classe DatoriDiLavoro permette di eseguire un 
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
    * Il metodo accettaRichiesta, della classe DatoriDiLavoro permette di 
    * accettare una richiesta ad un lavoro.
    */
    function accettaRichiesta($id, $data, $email){
        require 'application/models/datoriDiLavoro_model.php';
        $model = new DatoriDiLavoro_Model();
        $model->accettaRichiestaDiLavoro($id, $email, $data);
        header('Location: '.URL."DatoriDiLavoro");
    }

    /*
    * Il metodo rifiutaRichiesta, della classe DatoriDiLavoro permette di 
    * rifiutare una richiesta ad un lavoro.
    */
    function rifiutaRichiesta($id, $data, $email){
        require 'application/models/datoriDiLavoro_model.php';
        $model = new DatoriDiLavoro_Model();
        $model->rifiutaRichiestaDiLavoro($id, $data, $email);
        header('Location: '.URL."DatoriDiLavoro");
    }

    /*
    * Il metodo accettaORifiutaRichiestaDiLavoro, della classe DatoriDiLavoro 
    * permette di eseguire un metodo in base al bottone che è stato 
    * schiacciato.
    */
    function accettaORifiutaRichiestaDiLavoro($id, $data, $email){
        if(isset($_POST['A'])){
            $this->accettaRichiesta($id, $data, $email);
        }elseif(isset($_POST['R'])){
            $this->rifiutaRichiesta($id, $data, $email);
        }
    }

    /*
    * Il metodo esci, della classe DatoriDiLavoro permette di uscire dalla 
    * sessione.
    */
    function esci(){
        session_destroy();
        header('Location: '.URL."Accesso");
    }

    /*
    * Il metodo aggiungiOffertaDiLavoro, della classe DatoriDiLavoro permette 
    * di essere renderizzati alla pagina per aggiungere un'offerta di lavoro.
    */
    function aggiungiOffertaDiLavoro(){ 
        require 'application/controller/session.php';
        $session = new Session();
        if($session->isLogged()){
            $this->view->render("aggiungiOfferta/index");
        }else{
            header('Location: '.URL."Accesso");
        }
    }

    /*
    * Il metodo aggiungi, della classe DatoriDiLavoro permette 
    * di aggiungere un'offerta di lavoro.
    */
    function aggiungi(){
		if(!empty($_POST['titolo'])){
			$titolo = $this->test_input($_POST['titolo']);
		}else{
			$titolo = "Titolo";
		}
        if(!empty($_POST['descrizione'])){
			$descrizione = $this->test_input($_POST['descrizione']);
		}else{
			$descrizione = "Descrizione";
		}
        if(is_numeric($_POST['tariffaOraria']) && $_POST['tariffaOraria'] > 0 && 
           $_POST['tariffaOraria'] == round($_POST['tariffaOraria'], 0))
        {
            $tariffaOraria = $_POST['tariffaOraria'];
        }else{
            $tariffaOraria = 0;
        }
        if(is_numeric($_POST['oreDiLavoro']) && $_POST['oreDiLavoro'] > 0 && 
           $_POST['oreDiLavoro'] == round($_POST['oreDiLavoro'], 0))
        {
            $oreDiLavoro = $_POST['oreDiLavoro'];
        }else{
            $oreDiLavoro = 0;
        }
        $email = $_POST['email'];
        
        require 'application/models/datoriDiLavoro_model.php';
        $model = new DatoriDiLavoro_Model();
        $result = $model->lavoroNonAncoraEsistente($email, $titolo);
        if($result->num_rows == 0){
            $model->aggiungiLavoro($email, $titolo, $descrizione, $tariffaOraria, $oreDiLavoro);
        }else{
            echo "lavoro già effettuato";
        }
        header('Location: '.URL."DatoriDiLavoro");
    }

    /*
    * Il metodo test_input, della classe DatoriDiLavoro riceve una stringa come 
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
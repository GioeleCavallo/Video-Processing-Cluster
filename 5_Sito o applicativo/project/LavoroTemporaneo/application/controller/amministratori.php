<?php

class Amministratori extends Controller{

    function __construct(){
        parent::__construct();
    }
    
    /*
    * Il metodo index, della classe Amministratori permette di renderizzare 
    * alla pagina degli amministratori se si è loggati altrimenti si viene
    * renderizzati alla pagina di accesso.
    */
    function index(){
        require 'application/controller/session.php';
        $session = new Session();
        if($session->isLogged() && $_SESSION['nomeRuolo'] == 'amministratore'){
            $this->visualizzaLavoriConFiltro();
        }else{
            header('Location: '.URL."Accesso");
        }
    }

    /*
    * Il metodo modifica, della classe Amministratori permette di modificare 
    * un lavoro, questo metodo riceve un parametro numerico e non restituisce
    * niente.
    */
    function modifica($i){
        require 'application/models/amministratori_model.php';
        $model = new Amministratori_Model();
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
        $model->modificaLavoro($id,$datore_email,$lavoratore_email,$titolo,
        $descrizione,$tariffaOraria,$occupato,$scaduto,$oreDiLavoro,$data);
        header('Location: '.URL."Amministratori");
    }

    /*
    * Il metodo elimina, della classe Amministratori permette di eliminare 
    * un lavoro, questo metodo riceve un parametro numerico e non restituisce
    * niente.
    */
    function elimina($i){
        require 'application/models/amministratori_model.php';
        $model = new Amministratori_Model();
        $id = $_POST['id'];
        $model->eliminaLavoro($id);
        header('Location: '.URL."Amministratori");
    }

    /*
    * Il metodo esegui, della classe Amministratori permette di eseguire un 
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
    * Il metodo esci, della classe Amministratori permette di uscire dalla 
    * sessione.
    */
    function esci(){
        session_destroy();
        header('Location: '.URL."Accesso");
    }

    /*
    * Il metodo creaFattura, della classe Amministratori permette di creare una 
    * fattura.
    */
    function creaFattura(){
        require 'application/controller/session.php';
        $session = new Session();
        if($session->isLogged()){
            require 'application/models/amministratori_model.php';
            $model = new Amministratori_Model();
            $data = $model->getLavoriScaduti();
            $this->view->data = $data;
            $allData = $model->getFatture();
            $this->view->allData = $allData;
            $this->view->render("aggiungiFattura/index");
        }else{
            header('Location: '.URL."Accesso");
        }
    }

    /*
    * Il metodo calcolaFattura, della classe Amministratori permette di 
    * calcolare il costo della fattura.
    */
    function calcolaFattura($id, $datore_email, $lavoratore_email){
        $totale = 0;
        require 'application/models/amministratori_model.php';
        $model = new Amministratori_Model();
        $result = $model->calcolaFattura($id);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $totale = $row["oreDiLavoro"]*$row["tariffaOraria"];
            }
        } else {
            $totale = 0;
        }

        $totale1 = $totale + (($totale*10)/100);
        $data1 = date("Y-m-d H-i-sa");
        $model->creaFattura($data1, $datore_email, "samuele.abba@samtrevano.ch", $totale1);

        $totale2 = $totale;
        $date_now1 = new DateTime();
        $data2 = date_add($date_now1, date_interval_create_from_date_string("1 seconds"));
        $data2 = date_format($data2,"Y-m-d H-i-s");
        $model->creaFattura($data2, "samuele.abba@samtrevano.ch", $lavoratore_email, $totale2);

        $model->eliminaLavoro($id);

        header('Location: '.URL."Amministratori/creaFattura");
    }

    /*
    * Il metodo visualizzaLavoriConFiltro, della classe Amministratori permette di 
    * avere delle visualizzazioni differenti della tabella dei lavori nella view.
    */
    function visualizzaLavoriConFiltro(){
        require 'application/models/amministratori_model.php';
        $model = new Amministratori_Model();
        $data = null;
        if(isset($_POST['filtroLavoriOccupati'])){
            $data = $model->getLavoriOccupati();
        }else if(isset($_POST['filtroLavoriScaduti'])){
            $data = $model->getLavoriScaduti();
        }else{
            $data = $model->getLavori();
        }
        $this->view->data = $data;
        $this->view->render("paginaAmministratori/index");
    }
    
}

?>
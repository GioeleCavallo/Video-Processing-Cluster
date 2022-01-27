<?php

class DatoriDiLavoro_Model extends Model{

    function __construct(){}

    /*
    * Il metodo getLavoriDatoriDiLavoro, della classe DatoriDiLavoro_Model 
    * permette di ottenere tutti i lavori di un determinato utente.
    */
    function getLavoriDatoriDiLavoro(){
        $emailUser = $_SESSION['email'];
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro WHERE datore_email='$emailUser' AND scaduto='0'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo getOfferteDiLavoro, della classe DatoriDiLavoro_Model 
    * permette di ottenere tutte le proposte ad un lavoro di un determinato 
    * utente.
    */
    function getOfferteDiLavoro(){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro_proposta WHERE archiviato='0' AND
        lavoro_id IN (SELECT id from lavoro WHERE datore_email='$_SESSION[email]')";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo modificaOffertaDiLavoro, della classe DatoriDiLavoro_Model 
    * permette di modificare una offerta di lavoro grazie ai parametri.
    */
    function modificaOffertaDiLavoro($id,$datore_email,$lavoratore_email,$titolo,$descrizione,$tariffaOraria,$occupato,$scaduto,$oreDiLavoro,$data){
        require 'application/controller/connection.php';
        $sql = "UPDATE lavoro SET titolo='$titolo',descrizione='$descrizione',tariffaOraria='$tariffaOraria',oreDiLavoro='$oreDiLavoro'
        WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo eliminaOffertaDiLavoro, della classe DatoriDiLavoro_Model 
    * permette di eliminare ovvere far scadere una offerta di lavoro.
    */
    function eliminaOffertaDiLavoro($id){
        require 'application/controller/connection.php';
        $sql = "UPDATE lavoro SET scaduto='1'
        WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo accettaRichiestaDiLavoro, della classe DatoriDiLavoro_Model 
    * permette di accettare una richiesta ad un lavoro grazie ai parametri.
    */
    function accettaRichiestaDiLavoro($id, $email, $data){
        require 'application/controller/connection.php';
        $olddata = $data;
        $data = substr($data,0, 10)." ".substr($data,10, 8);
        $sql = "UPDATE lavoro SET lavoratore_email='$email', occupato='1', data='$data'
        WHERE id='$id'";
        $result = $conn->query($sql);
        $this->rifiutaRichiestaDiLavoro($id, $olddata, $email);
        return $result;
    }

    /*
    * Il metodo rifiutaRichiestaDiLavoro, della classe DatoriDiLavoro_Model 
    * permette di rifiutare una richiesta ad un lavoro grazie ai parametri.
    */
    function rifiutaRichiestaDiLavoro($id, $data, $email){
        require 'application/controller/connection.php';
        $data = substr($data,0, 10)." ".substr($data,10, 8);
        $sql = "UPDATE lavoro_proposta SET archiviato='1'
        WHERE data='$data'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo lavoroNonAncoraEsistente, della classe DatoriDiLavoro_Model 
    * permette di selezionare tutti i lavori che soddisfano i parametri.
    */
    function lavoroNonAncoraEsistente($email, $titolo){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro WHERE datore_email='$email' AND titolo='$titolo' AND scaduto='0'";
        $result = $conn->query($sql);
        return $result;
    }
    
    /*
    * Il metodo aggiungiLavoro, della classe DatoriDiLavoro_Model 
    * permette di aggiungere un lavoro nel db.
    */
    function aggiungiLavoro($email, $titolo, $descrizione, $tariffaOraria, $oreDiLavoro){
        require 'application/controller/connection.php';
        $date = new DateTime();
        $data = $date->format('Y-m-d H:i:s');
        $sql2 = "INSERT INTO lavoro(datore_email, lavoratore_email, titolo, descrizione, tariffaOraria, occupato, scaduto, oreDiLavoro, data)
        VALUES('$email','samuele.abba@samtrevano.ch','$titolo','$descrizione',$tariffaOraria,0, 0,$oreDiLavoro,'$data')";
        $result2 = $conn->query($sql2);
        return $result2;
    }
    
}

?>
<?php

class Lavoratori_Model extends Model{

    function __construct(){}

    /*
    * Il metodo getRischiesteLavori, della classe Lavoratori_Model permette di 
    * selezionare tutte le richieste ai lavori di un determinato utente.
    */
    function getRischiesteLavori(){
        $emailUser = $_SESSION['email'];
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro_proposta WHERE lavoratore_email='$emailUser' AND archiviato='0'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo getLavoriNonOccupati, della classe Lavoratori_Model 
    * permette di ottenere tutti i lavori non occupati e non archiviati.
    */
    function getLavoriNonOccupati(){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro
        WHERE occupato='0' AND archiviato='0'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo modificaRichiestaDiLavoro, della classe Lavoratori_Model 
    * permette di modificare una richiesta ad un lavoro grazie ai parametri
    * passati.
    */
    function modificaRichiestaDiLavoro($data,$lavoro_id,$lavoratore_email,$titolo,$descrizione,$allegati,$archiviato){
        require 'application/controller/connection.php';
        $sql = "UPDATE lavoro_proposta SET 
        lavoro_id='$lavoro_id',lavoratore_email='$lavoratore_email',titolo='$titolo',descrizione='$descrizione',allegati='$allegati',archiviato='$archiviato'
        WHERE data='$data'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo getTitolo, della classe Lavoratori_Model permette di ottenere 
    * tutti i lavori che hanno un determinato id specificato dal parametro.
    */
    function getTitolo($id){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro WHERE id='$id' LIMIT 1";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo lavoroNonAncoraEsistente, della classe Lavoratori_Model 
    * permette di ottenere tutte le richieste ai lavori che soddisfano i
    * parametri.
    */
    function lavoroNonAncoraEsistente($id, $email, $archiviato){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro_proposta WHERE lavoro_id='$id' AND lavoratore_email='$email' AND archiviato='$archiviato'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo aggiungiLavoro, della classe Lavoratori_Model permette di 
    * aggiungere una richiesta ad un lavoro tramite ai parametri.
    */
    function aggiungiLavoro($data,$id,$email,$titolo,$descrizione,$allegati,$archiviato){
        require 'application/controller/connection.php';
        $date = new DateTime();
        $data = $date->format('Y-m-d H:i:s');
        $sql = "INSERT INTO `lavoro_proposta`(`data`, `lavoro_id`, `lavoratore_email`, `titolo`, `descrizione`, `allegati`, `archiviato`) 
        VALUES ('$data','$id','$email','$titolo','$descrizione','$allegati', '$archiviato')";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo getLavoro, della classe Lavoratori_Model permette di 
    * ottenere un lavoro tramite un id passato come parametro.
    */
    function getLavoro($id){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo inviaEmailDiConferma, della classe Lavoratori_Model permette di 
    * inviare una email di conferma all'utente quando accetta un lavoro.
    */
    function inviaEmailDiConferma($email, $titolo){
		$to_email = $email;
		$subject = "Proposta al lavoro $titolo";
		$message = "Complimenti, la sua proposta al lavoro $titolo è avvenuta con successo";
		$headers = 'From: LavoroTemporaneoSAMT@gmail.com';
        mail($to_email, $subject, $message, $headers);
    }

}

?>
<?php

class Amministratori_Model extends Model{

    function __construct(){}

    /*
    * Il metodo getLavoriOccupati, della classe Amministratori_Model permette
    * di ottenere turri i lavori occupati e non archiviati contenuti nel db.
    */
    function getLavoriOccupati(){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro
        WHERE occupato='1' AND archiviato='0'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo getLavoriScaduti, della classe Amministratori_Model permette
    * di ottenere turri i lavori scaduti e non archiviati contenuti nel db.
    */
    function getLavoriScaduti(){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro
        WHERE scaduto='1' AND archiviato='0'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo getLavori, della classe Amministratori_Model permette di 
    * ottenere turri i lavori archiviati e non contenuti nel db.
    */
    function getLavori(){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM lavoro";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo modificaLavoro, della classe Amministratori_Model permette di 
    * modificare un lavoro all'interno del db grazie ai parametri passati.
    */
    function modificaLavoro($id, $datore_email, $lavoratore_email, $titolo, $descrizione, $tariffaOraria, $occupato, $scaduto, $oreDiLavoro){
        require 'application/controller/connection.php';
        $sql = "UPDATE lavoro SET datore_email='$datore_email',lavoratore_email='$lavoratore_email',titolo='$titolo',descrizione='$descrizione',
        tariffaOraria='$tariffaOraria',occupato='$occupato',scaduto='$scaduto',oreDiLavoro='$oreDiLavoro' 
        WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo eliminaLavoro, della classe Amministratori_Model permette di 
    * eliminare e quindi archiviare un lavoro all'interno del db.
    */
    function eliminaLavoro($id){
        require 'application/controller/connection.php';
        $sql = "UPDATE lavoro SET archiviato='1'
        WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo getFatture, della classe Amministratori_Model permette di 
    * ottenere tutte le fatture all'interno del db.
    */
    function getFatture(){
        require 'application/controller/connection.php';
        $sql = "SELECT * FROM fattura";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo calcolaFattura, della classe Amministratori_Model permette di 
    * ritornare tutti i dati relativi al calcolo del costo di un lavoro.
    */
    function calcolaFattura($id){
        require 'application/controller/connection.php';
        $sql = "SELECT oreDiLavoro, tariffaOraria FROM lavoro
        WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    /*
    * Il metodo creaFattura, della classe Amministratori_Model permette di 
    * inserire una nuova fattura nel db.
    */
    function creaFattura($data, $datore_email, $lavoratore_email, $totale){
        require 'application/controller/connection.php';
        $sql = "INSERT INTO fattura VALUES ('$data','$datore_email','$lavoratore_email','$totale')";
        $result = $conn->query($sql);
        return $result;
    }

}

?>
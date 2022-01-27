<?php

class Index_Model extends Model{
  
    function __construct(){}
	
    /*
    * Il metodo run, della classe Index_Model permette di selezionare tutti i 
    * lavori non archiviati nel db.
    */
    function run(){
      require 'application/controller/connection.php';
      $sql = "SELECT * FROM lavoro WHERE archiviato='0'";
      $result = $conn->query($sql);
		  return $result;
    }

}

?>
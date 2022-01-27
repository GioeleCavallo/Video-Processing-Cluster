<?php

class View{
    
    function __construct(){
        
    }

    /*
    * Il metodo render, della classe View riceve un parametro name con esso 
    * questo metodo carica il file del view con il name specificato.
    */
    public function render($name){
        require 'application/views/' . $name . '.php';
    }

}

?>
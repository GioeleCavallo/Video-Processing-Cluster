<?php

class Session extends Controller{

    function __construct(){}

    /*
    * Il metodo isLogged, della classe Session permette di verificare se sono settate 
    * determinate variabili di sessione e quindi se è stato effettuato un login.
    * Il metodo torna true se sono settate le variabili email, 
    * passwordHash e nomeRuolo altrimenti ritorna false.
    */
    function isLogged(){
        if(isset($_SESSION['email']) && isset($_SESSION['passwordHash']) && isset($_SESSION['nomeRuolo'])){
            return true;
        }else{
            return false;
        }
    }
    
}

?>
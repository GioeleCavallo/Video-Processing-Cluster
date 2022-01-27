<?php

class Accesso extends Controller{

    function __construct(){
        parent::__construct();
    }
    
	/*
    * Il metodo index, della classe Accesso permette di renderizzare la pagina 
	* di accesso.
    */
    function index(){
        $this->view->render("accesso/index");
    }

	/*
    * Il metodo reRender, della classe Accesso permette di renderizzare alla 
	* pagina di registrazione.
    */
	function reRender(){
		header("Location: ".URL."Registrazione");
    }

	/*
    * Il metodo test, della classe Accesso permette di testare gli input.
	* Se gli input non sono validi ritorna gli errori più opportuni altrimenti
	* viene creata una nuova sessione e si viene renderizzati nella propria 
	* pagina in base al proprio ruolo.
    */
    function test(){
		//Vriabili per gli errori e per i risultati
		$emailError;
		$passwordError;
		$email = $_POST["email"];
		$password = $_POST["password"];

		//validazione dell'email
		$emailError = $this->validationEmail($email);

		//validazione della password
		$passwordError = $this->validationPassword($password);

		//return
		if($emailError && $passwordError){
			require 'application/models/accesso_model.php';
        	$model = new Accesso_Model();
        	$model->openSession($email, $password);
			if(strcmp($_SESSION['nomeRuolo'], 'datore') == 0){
				header('Location: '.URL."DatoriDiLavoro");
			}else if(strcmp($_SESSION['nomeRuolo'], 'lavoratore') == 0){
				header('Location: '.URL."Lavoratori");
			}else if(strcmp($_SESSION['nomeRuolo'], 'amministratore') == 0){
				header('Location: '.URL."Amministratori");
			}else{
				header('Location: '.URL."Accesso");
			}
		}else{
			echo "Email: $emailError non valida<br>";
			echo "Password: $passwordError non valida";
		}
	}

	/*
    * Il metodo validationEmail, della classe Accesso riceve una mail come 
	* parametro e pepermette di validarla, infatti questo metodo ritorna true 
	* se la email è valida e rispecchia i parametri e ritorna false altrimenti.
    */
	function validationEmail($email){
		if(!empty($email)){
			$email = $this->test_input($email);
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	/*
    * Il metodo validationPassword, della classe Accesso riceve una password 
	* come parametro e pepermette di validarla, infatti questo metodo ritorna 
	* true se la password è valida e rispecchia i parametri e ritorna false 
	* altrimenti.
    */
	function validationPassword($password){
		if(!empty($password)){
			$password = $this->test_input($password);
			if(strlen($password) > 7){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	/*
    * Il metodo test_input, della classe Accesso riceve una stringa come 
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
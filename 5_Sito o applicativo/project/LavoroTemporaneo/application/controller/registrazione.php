<?php

class Registrazione extends Controller{

    function __construct(){
        parent::__construct();
    }
    
	/*
    * Il metodo index, della classe Registrazione permette di renderizzare la
	* pagina di registrazione.
    */
    function index(){
        $this->view->render("registrazione/index");
    }

	/*
    * Il metodo reRender, della classe Registrazione permette di renderizzare 
	* alla pagina di accesso.
    */
	function reRender(){
        header("Location: ".URL."Accesso");
    }

	/*
    * Il metodo test, della classe Registrazione permette di testare gli input.
	* Se gli input non sono validi ritorna gli errori più opportuni altrimenti
	* viene creato un nuovo utente e immesso nel db e inoltre gli viene spedita
	* una mail che conferma la sua iscrizione la lavoro temporaneo e si viene 
	* renderizzati nella pagina di accesso per effettuare subito l'accesso.
    */
    function test(){
		//Vriabili per gli errori e per i risultati
		$emailError = "";
		$passwordError = "";
		$ruoloError = "";
		$email = $_POST["email"];
		$password = $_POST["password"];
		$ruolo = $_POST["ruolo"];

		//validazione dell'email
		$emailError = $this->validationEmail($email);

		//validazione della password
		$passwordError = $this->validationPassword($password);

		//validazione del ruolo
		$ruoloError = true;

		//return
		if($emailError && $passwordError && $ruoloError){
			require 'application/models/registrazione_model.php';
        	$model = new Registrazione_Model();
        	$model->insertData($email, $password, $ruolo);
			header("Location: ".URL."Accesso");
		}else{
			echo "Email: $email non valida<br>";
			echo "Password: $password non valida<br>";
			echo "Ruolo: $ruolo non valido";
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
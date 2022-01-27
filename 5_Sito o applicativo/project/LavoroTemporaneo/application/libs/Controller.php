<?php

class Controller{

	function __construct(){
		$this->view = new View();
	}

	/*
    * Il metodo loadModel, della classe Controller riceve un parametro name,
	* con esso questo metodo carica il file del model con il name specificato.
    */
	function loadModel($name){
		$path = 'applications/models/$name_model.php';
		if(file_exists($path)){
			require $path;
			$modelName = '$name_Model';
			$this->model = new $modelName ;
		}

	}

}

?>
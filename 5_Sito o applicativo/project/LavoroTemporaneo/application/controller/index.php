<?php

class Index extends Controller{

    function __construct(){
        parent::__construct();
    }
    
    /*
    * Il metodo index, della classe Index permette di renderizzare la pagina 
	* di index, oltre a ciò il metodo si occupa di recuperare dei dati dal
    * db e passarli alla view.
    */
    function index(){
        require 'application/models/index_model.php';
        $model = new Index_Model();
        $data = $model->run();
        $this->view->data = $data;
        $this->view->render("index/index");
    }

}

?>
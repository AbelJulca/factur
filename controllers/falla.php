<?php
class Falla extends Controller {

    function __construct() {
        Session::init();
        parent::__construct(); 
    }
    
    function index() {        
        $this->view->render('error/index');
    }
    function error() {        
        $this->view->render('error/error');
    }

}
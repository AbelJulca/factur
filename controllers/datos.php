<?php

class Datos extends Controller
{
    function __construct() {
        parent::__construct();      
        Session::init();
        $slogged = Session::get('loggedIn');

        if ($slogged == false) {
            Session::destroy();
            header('location: ../index');
            exit;
        }
        //$this->view->js = array("dashboard/js/script-dashboard.js");
    }
    
    public function index() {
        $this->view->render('datos/index');
    }
}

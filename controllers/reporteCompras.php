<?php

class ReporteCompras extends Controller
{
    function __construct()
    {
        parent::__construct();

        Session::init();
        $slogged = Session::get('loggedIn');

        if ($slogged == false) {
            Session::destroy();
            header('location: ../index');
            exit;
        }
        $this->view->js = array("reporteCompras/js/script-reporteCompras.js");
    }
    public function index()
    {
        $this->view->render('reporteCompras/index');
    } 
}

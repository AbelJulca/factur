<?php
date_default_timezone_set('America/Lima');

require_once 'config/paths.php';
require_once 'config/database.php';

require_once "libs/Controller.php";
require_once "libs/Inicio.php";
require_once "libs/Session.php";
require_once "libs/View.php";
require_once "libs/Database.php";
require_once "libs/Model.php";
//LIBRERIA GREENTER
require_once "libs/api_facturacion/vendor/autoload.php";

require_once 'libs/fpdf/fpdf.php';
require_once 'libs/phpqrcode/qrlib.php';
require_once 'libs/solesLetras/vendor/autoload.php';
require_once 'libs/excel/vendor/autoload.php';
require_once 'libs/invoice.php';
require_once 'libs/invo.php';
require_once 'libs/invoiceguia.php';


//require_once('libs/signature.php');

$app = new Inicio();
$app->init();
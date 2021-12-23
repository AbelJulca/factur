<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Cix | Guia Remision</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?php echo URL ?>public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/select2/css/select2.min.css">
  <!-- stylo personal-->
  <link src="<?php echo URL ?>public/css/sweetalert2/bootstrap-4.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo URL ?>public/css/menu.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?php echo URL ?>public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">  
  
  <link rel="stylesheet" href="<?php echo URL ?>public/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?php echo URL ?>public/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
        height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="#" class="nav-link h6 title-rx m-0 font-weight-bold text-primary">GUIA REMISION</a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li>
          <?php include_once './views/misdatos.php'; ?>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="<?php echo URL ?>public/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SYSTEM</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo URL ?>public/images/logo_codilans.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">CODILANS</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <?php include_once './views/menu.php'; ?>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid" >            
            <form id="frmGuiaRemision">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row form-group">
                            
                            <div class="col-md-4 col-4">
                                <label class="font-weight-bold">Tipo Comp:</label>
                                <div id="cmbComproNota"></div> 
                            </div>
                            <div class="col-md-4 col-4">
                                <label class="font-weight-bold">Serie:</label>                                
                                <input type="text" class="form-control form-control-sm text-center" name="txtserie" id="txtserie" readonly autocomplete="off">
                                <input type="hidden" name="txtidserie" id="txtidserie">                            
                            </div>
                            <div class="col-md-4 col-4">
                                <label class="font-weight-bold" for="fechaPr">Num:</label>
                                <input type="text" class="form-control form-control-sm text-center" id="txtcorrelativo" name="txtcorrelativo" readonly="">
                            </div>
                        </div>
                        <div class="form-row form-group"> 
                            <div class="col-md-3 col-3">
                                <label class="font-weight-bold">Serie Ref:</label>
                                <input type="text" maxlength="4" class="form-control form-control-sm text-uppercase text-center" name="txtserieref" id="txtserieref" autocomplete="off">                                
                            </div>
                            <div class="col-md-5 col-5">
                                <label class="font-weight-bold">Num Ref:</label>
                                <div class="form-row">
                                    <div class="col-md-6 col-8">
                                        <input type="number" min="1" class="form-control form-control-sm" id="txtcorrelativoref" name="txtcorrelativoref"> 
                                    </div>
                                    <div class="col-md-6 col-4">
                                        <button type="button" id="btnBuscar" class="btn btn-info btn-sm" ><i class="fas fa-search"></i></button>
                                        <button class="btn cargarNc d-none btn-sm">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>                                              
                            </div>
                            <div class="col-md-4 col-4">
                                <label class="font-weight-bold">Doc:</label>
                                <input type="text" id="txtnrodocu" name="txtnrodocu" class="form-control form-control-sm">                                                                                     
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col-md-12 col-12">
                                <label class="font-weight-bold">Razon Social:</label>
                                <input type="text" class="form-control mayus form-control-sm" id="txtrazonsocial" name="txtrazonsocial" required="">
                                <input type="hidden" id="txtidventa" name="txtidventa">
                                <input type="hidden" id="txtidperiodo" name="txtidperiodo">
                                <input type="hidden" id="txttipodocumento" name="txttipodocumento" >
                                <input type="hidden" id="txtidcliente" name="txtidcliente" >
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label class="font-weight-bold" for="txtdireccion">Direccion:</label>
                            <input type="text" class="form-control mayus form-control-sm" id="txtdireccion" name="txtdireccion" required="">
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 col-4">
                                <div id="cmbModoTraslado"></div> 
                            </div>
                            <div class="col-md-8 col-8">                                           
                                <label class="font-weight-bold" >Motivo Traslado:</label>
                                <div class="form-row">
                                    <div class="col-md-12 col-12">
                                        <div id="cmbMotivo"></div>                               
                                    </div>                                                
                                </div> 
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold" for="txtobservacion">Descripción de motivo de traslado:</label>
                            <input type="text" class="form-control mayus form-control-sm" id="txtobservacion" name="txtobservacion" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col-md-4 col-4">
                                <label class="font-weight-bold" >Unidad Medida:</label>
                                <div id="cmbUnidad"></div> 
                            </div>
                            <div class="col-md-4 col-4">                                           
                                <label class="font-weight-bold" >Peso Total (KGM):</label>
                                <input type="text" onkeypress="return filterFloat(event, this);" class="form-control form-control-sm" id="txtpeso" name="txtpeso" required="" autocomplete="off"> 
                            </div>
                            <div class="col-md-4 col-4">                                           
                                <label class="font-weight-bold" >Num de paquet:</label>
                                <input type="number" class="form-control form-control-sm" id="txtnumeropaq" name="txtnumeropaq" min="1" required=""> 
                            </div>
                        </div>                                   
                        <div class="form-group mt-2">
                            <label class="font-weight-bold text-danger h6" for="direccionNota">Direccion Partida:</label> 
                            <div class="form-row">                                
                                <div class="col-md-4 col-8">                                           
                                    <label class="font-weight-bold" >Ubigeo:</label>
                                    <div class="form-row">
                                        <div class="col-md-8 col-10">
                                            <input type="text" maxlength="6" onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" id="txtubigeo" name="txtubigeo" required=""> 
                                        </div>
                                        <div class="col-md-2 col-2">
                                            <button type="button" id="btnBuscarUbigeo" class="btn btn-info btn-sm" ><i class='fas fa-search'></i></button>                                                        
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-8 col-12">                                           
                                    <label class="font-weight-bold" >Direccion:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="txtdireccionPart" name="txtdireccionPart" required=""> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label class="font-weight-bold text-primary h6" for="direccionNota">Direccion LLegada:</label> 
                            <div class="form-row">
                                <div class="col-md-4 col-8">                                           
                                    <label class="font-weight-bold" >Ubigeo:</label>
                                    <div class="form-row">
                                        <div class="col-md-8 col-10">
                                            <input type="text" maxlength="6" onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" id="txtubigeoLL" name="txtubigeoLL" required=""> 
                                        </div>
                                        <div class="col-md-2 col-2">
                                            <button type="button" id="btnBuscarUbigeoLL" class="btn btn-info btn-sm" ><i class='fas fa-search'></i></button>                                                        
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-8 col-12">                                           
                                    <label class="font-weight-bold" >Direccion:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="txtdireccionLL" name="txtdireccionLL" required=""> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold text-success h6">Datos Transportista:</label> 
                            <div class="form-row privado d-none">
                                <div class="col-md-3 col-4">
                                    <label class="font-weight-bold" >Ruc Empresa:</label>
                                    <input type="text" maxlength="11" onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" id="txtrucempresa" name="txtrucempresa" autocomplete="off"> 
                                </div>
                                <div class="col-md-9 col-4">
                                    <label class="font-weight-bold" >Razon Social Empresa:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="txtrazonsocialempresa" name="txtrazonsocialempresa" autocomplete="off"> 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 col-4">
                                    <label class="font-weight-bold" >Tipo Docu:</label>
                                    <div id="cmbTipoDocu"></div> 
                                </div>
                                <div class="col-md-5 col-5">                                           
                                    <label class="font-weight-bold" >Nro:</label>                                                
                                    <div class="form-row"> 
                                        <div class="col-md-7 col-7">
                                            <input type="text" maxlength="11" class="form-control form-control-sm" id="txtdocum" name="txtdocum" onKeyPress="return soloNumeros(event)" required="">                                                   
                                        </div>
                                        <div class="col-md-5 col-5 d-flex">
                                            <button title="Buscar DNI" type="button" id="btnBuscarDni" class="btn btn-warning btn-sm"><i class='fas fa-search'></i></button>
                                            <button type="button" class="btn btn-light bg-light btn-sm loadDni d-none">
                                                <div class="spinner-border spinner-border-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3">                                           
                                    <label class="font-weight-bold" >Placa:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="txtplaca" name="txtplaca" required=""> 
                                </div>
                            </div>
                            <div class="form-group mt-2">                                           
                                <label class="font-weight-bold" >Razon Social:</label>
                                <input type="hidden" id="txtidtrans" name="txtidtrans" >
                                <input type="text" class="form-control form-control-sm" id="txtnombre" name="txtnombre" required=""> 
                            </div>
                        </div>
                        <div class="form-row mt-2 justify-content-end">                                                
                            <div class="text-right col-md-2 col-7">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>                             
                            </div>
                            <div class="text-right col-md-2 col-2">                                                       
                                <button type="reset" id="btnCancelarNota" class=" btn btn-danger" >
                                    <i class="fas fa-trash-alt"></i>
                                </button>                                                    
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div id="tabla-ncdetalle"></div>
                </div>
            </div>
            <br>
        </div> 
    </div>
    <!-- /.content-wrapper -->  

    <div class="modal fade" id="ModalUbigeo" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ModalUbigeoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-primary" >UBIGEO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" >Departamento:</label> 
                                    <div id="cmbdepartamento"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" >Provincia:</label> 
                                    <div id="cmbprovincia">
                                        <select class="form-control form-control-sm">
                                            <option value="00">--Seleccione Uno--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" >Distrito:</label> 
                                    <div id="cmbdistrito">
                                        <select class="form-control form-control-sm">
                                            <option value="00">--Seleccione Uno--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold" >Codigo Ubigeo:</label>
                                <input type="text" class="form-control form-control-sm" id="txtUbigeox" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button title="Aceptar" type="button" id="btnAceptarLL" class="btn btn-success d-none" data-toggle="tooltip" data-placement="top"><i class='fa fa-save'></i></button>
                    <button title="Aceptar" type="button" id="btnAceptarPP" class="btn btn-primary" data-toggle="tooltip" data-placement="top"><i class='fa fa-save'></i></button>                                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm border-0" id="cargaEspera" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="cargaEsperaTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content bg-transparent border-0">        
          <div class="modal-body border-0">
            <div class="d-flex justify-content-center">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
          </div>        
        </div>
      </div>
    </div>
    
    <?php include_once './views/footer.php'; ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="<?php echo URL ?>public/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo URL ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo URL ?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo URL ?>public/dist/js/adminlte.js"></script>
  <script src="<?php echo URL ?>public/js/sweetalert2/sweetalert2.all.min.js"></script>
  <?php
  if (isset($this->js)) {
    foreach ($this->js as $js) {
      echo '<script src="' . URL . 'views/' . $js .'?'.rand().'"></script>';
    }
  }
  ?>  
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Cix | Caja</title>

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

  <link rel="stylesheet" href="<?php echo URL ?>public/css/menu.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?php echo URL ?>public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">  
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link src="<?php echo URL?>public/css/sweetalert2/bootstrap-4.css" rel="stylesheet">

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
          <a href="#" class="nav-link h6 m-0 font-weight-bold text-primary">APERTURA DE CAJA</a>
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
            <a href="#" class="d-block">DATA CIX</a>
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
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- /.row (main row) -->          
            <div class="row">
                <div class="col-md-4 mt-3 col-12">
                    <?php setlocale(LC_TIME, 'spanish'); ?>
                    <h6>Caja del Dia <?php echo strftime('%d %B.%Y') ?></h6>
                </div>
                <div class="col-md-4 col-6 mt-3">
                    <div class="row"> 
                        <div class="col-md-2 m-0 col-4">
                            <button type="button" id="AbrirCaja" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Abrir Caja"><i class="fas fa-box-open"></i></button>                                     
                        </div> 
                        <div class="col-md-10 m-0 col-8">
                            <h6 class="m-0">Abrir Caja</h6>
                            <small class="form-text text-muted m-0">Abrir la caja del dia.</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6 mt-3">
                    <div class="row "> 
                        <div class="col-md-2 m-0 col-4">
                            <button type="button" id="CerrarCaja" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Cerrar Caja"><i class="fas fa-power-off"></i></button>                                     
                        </div>
                        <div class="col-md-10 m-0 col-8">
                            <h6 class="m-0">Cerrar Caja</h6>
                            <small class="form-text text-muted m-0">Cerrar de caja del dia.</small>
                        </div>
                    </div>
                </div> 
            </div>
            <h5 class="font-weight-bold text-primary">VENTAS</h5>
            <div class="row">
                <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title" id="txtnamecaja">NOMBRE CAJA</h6>
                        </div>
                        <div class="card-body d-flex">                            
                            <div>

                            </div>
                            <div class="text-center align-items-center">                              
                                <input type="text" class="text-normal text-center h5 font-weight-bold" readonly="" id="txtmontocaja">
                                <small class="text-muted">MONTO</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">ESTADO</h6>
                        </div>
                        <div class="card-body d-flex">                            
                            <div>
                                <div class="align-self-center mr-3">
                                    <img width="30" src="<?php echo URL ?>public/images/dollar-pay.png" alt=""/>
                                </div>
                            </div>
                            <div class="text-center align-items-center">                              
                              <kbd id="txtestado" class="font-weight-bold h6 bg-danger">CERRADO</kbd>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">FACTURAS</h6>
                        </div>
                        <div class="card-body d-flex">                            
                            <div>
                                <div class="align-self-center mr-3">
                                    <img width="30" src="<?php echo URL ?>public/images/dollar-pay.png" alt=""/>
                                </div>
                            </div>
                            <div class="text-center align-items-center">                              
                                <input type="text" class="text-normal text-center h5 font-weight-bold" readonly="" id="txtmontofactura" value="0" >                               
                                <small class="text-muted">CANTIDAD</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">BOLETAS</h6>
                        </div>
                        <div class="card-body d-flex">                            
                            <div>
                                <div class="align-self-center mr-3">
                                    <img width="30" src="<?php echo URL ?>public/images/dollar-pay.png" alt=""/>
                                </div>
                            </div>
                            <div class="text-center align-items-center">                              
                                <input type="text" class="text-normal text-center h5 font-weight-bold" readonly="" id="txtmontoboleta" value="0" >                               
                                <small class="text-muted">CANTIDAD</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">TICKET</h6>
                        </div>
                        <div class="card-body d-flex">                            
                            <div>
                                <div class="align-self-center mr-3">
                                    <img width="30" src="<?php echo URL ?>public/images/dollar-pay.png" alt=""/>
                                </div>
                            </div>
                            <div class="text-center align-items-center">                              
                                <input type="text" class="text-normal text-center h5 font-weight-bold" readonly="" id="txtmontoticket" value="0" >                               
                                <small class="text-muted">CANTIDAD</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">MONTO TOTAL</h6>
                        </div>
                        <div class="card-body d-flex">                            
                            <div>
                                <div class="align-self-center mr-3">
                                    <img width="30" src="<?php echo URL ?>public/images/dollar-pay.png" alt=""/>
                                </div>
                            </div>
                            <div class="text-center align-items-center">                              
                                <input type="text" class="text-normal text-center h5 font-weight-bold" readonly="" id="txtmontototal" value="0" >                               
                                <small class="text-muted">CANTIDAD</small>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="form-row justify-content-end">
              <div class="col-md-4">
                <label for="">Periodo:</label>
                <div id="cmbperiodo"></div>
              </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <table id="datosConsulta" class="table table-sm table-responsive-md" width="100%">
                      <thead class="thead-dark">
                          <tr>
                          <th scope="col">DESCRIPCION</th>
                          <th scope="col">FECHA</th>
                          <th scope="col">MONTO_A</th>                              
                          <th scope="col">FACTURA</th>
                          <th scope="col">BOLETA</th>
                          <th scope="col">TICKET</th>
                          <th scope="col">MONTO_C</th>
                          </tr>
                      </thead>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <br><br>
      </section>
      <!-- /.content -->

      <div class="modal fade" id="cajaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="cajaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold text-primary" >REGISTRAR CAJA</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formCaja">
                            <div class="modal-body">                                
                                <div class="form-group">
                                    <label class="font-weight-bold text-body">Nombre:</label>
                                    <input type="text" class="form-control mayus" id="txtnombrecaja" name="txtnombrecaja" autocomplete="off" required>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label class="font-weight-bold text-body">Fecha:</label>
                                        <input type="text" class="form-control" readonly="" id="txtfecha" name="txtfecha" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="font-weight-bold text-body">Año:</label>
                                        <input type="text" class="form-control" readonly="" id="txtyear" name="txtyear" value="<?php echo date('Y'); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="font-weight-bold text-body">Monto:</label>
                                        <input type="text" class="form-control" id="txtmonto" name="txtmonto" value="0.00" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Guardar Caja">
                                    <i class='fas fa-save'></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Termina Modal-->
    </div>
    <!-- /.content-wrapper --> 
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

   <!-- DataTables  & Plugins -->
   <script src="<?php echo URL ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo URL ?>public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo URL ?>public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


  <script src="<?php echo URL ?>public/plugins/select2/js/select2.full.min.js"></script>
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
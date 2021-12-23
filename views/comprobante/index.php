<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Cix | Comprobante</title>

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

  <!-- Theme style -->
  <link src="<?php echo URL ?>public/css/sweetalert2/bootstrap-4.css" rel="stylesheet">

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
          <a href="#" class="nav-link h6 m-0 font-weight-bold text-primary">NUEVA VENTA</a>
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
          <br>
          <form id="frmVenta">
            <div class="row">
              <div class="col-md-2 col-6">
                <label for="">Serie:</label>
                <input type="hidden" id="txtidserie" name="txtidserie">
                <input type="hidden" id="txttipocompro" name="txttipocompro">
                <input type="text" maxlength="4" class="form-control form-control-sm text-uppercase" id="txtserie" name="txtserie" readonly>
              </div>
              <div class="col-md-2 col-6">
                <label for="">Correlativo:</label>
                <input type="number" class="form-control form-control-sm" id="txtcorrelativo" name="txtcorrelativo" readonly>
              </div>
              <div class="col-md-2 col-6">
                <label for="">Fecha Emision:</label>
                <input type="date" id="txtfecha" name="txtfecha" class="form-control form-control-sm"
                  value="<?php echo date('Y-m-d') ?>">
              </div>
              <div class="col-md-2 col-6">
                <label for="">Tipo Documento:</label>
                <div id="cmbtipodocumento"></div>
              </div>
              <div class="col-md-2 col-6">
                <label for="">Forma pago:</label>
                <div id="cmbformapago"></div>
              </div>
              <div class="col-md-2 col-6">
                <label for="">Tipo Cambio:</label>
                <input type="text" class="form-control form-control-sm" id="txttipocambio" name="txttipocambio"
                  readonly>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="font-weight-bold text-body" for="nrdocu">Tipo. Doc:</label>
                <div id="cmbtiponrodoc"></div>
              </div>
              <div class="col-md-3">
                <label class="font-weight-bold text-body" for="nrdocu">Nro. Doc:</label>
                <div class="row">
                    <div class="form-group col-md-8 col-6">
                        <input type="text" maxlength="11" onkeypress="return soloNumeros(event);" class="form-control form-control-sm" id="nrdocu" name="nrdocu" required="" autocomplete="off">                                                  
                    </div>
                    <div class="form-group col-md-4 col-6 d-flex">                                                       
                        <button type="button" class=" btn btn-warning btn-sm" id="btnBuscarDocum">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" class="btn btn-light btn-sm loadDni d-none">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>                                                    
                    </div>
                </div> 
              </div>
              <div class="col-md-3">
                <input type="hidden" id="txtidcliente" name="txtidcliente">
                <label for="">Razon Social:</label>
                <textarea name="razonSocial" id="razonSocial" class="form-control form-control-sm" rows="2"></textarea>
              </div>
              <div class="col-md-4">
                <label for="">Dirección:</label>
                <textarea name="direccion" id="direccion" class="form-control form-control-sm" rows="2"></textarea>
              </div>               
            </div>
            <div class="row mt-2">
              <div class="col-md-2 col-6">
                <input type="hidden" id="txtidperiodo" name="txtidperiodo">
                <label for="">Moneda:</label>
                <div id="cmbmoneda"></div>
              </div>
              <div class="col-md-2 col-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="ckbinventario" name="ckbinventario"
                    checked="checked">
                  <label class="form-check-label font-weight-bold" for="ckbinventario">
                    Ingresa al invetario
                  </label>
                </div>
              </div>
              <div class="col-md-2 col-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="ckbincluirigv" name="ckbincluirigv"
                    checked="checked">
                  <label class="form-check-label font-weight-bold" for="ckbincluirigv">
                    Precio Incluye IGV
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-2">
                <div class="form-row mt-2">
                  <div class="col-md-6">
                      <label>Agregar Producto:</label>
                      <input type="search" class="form-control form-control-sm" id="txtBuscarProducto"
                        placeholder="ESCRIBA LOS 3 PRIMEROS CARACTERES DEL PRODUCTO" autocomplete="off">
                  </div>
                  <!--div class="col-md-6">
                      <label>Glosa:</label>
                      <input type="text" class="form-control form-control-sm text-uppercase" id="txtglosa" name="txtglosa" autocomplete="off">
                  </div-->
                </div>
                <div class="form-group mt-3 mb-3">
                  <div id="tablaProducto"></div>
                </div>
              </div>              
            </div>
            <div class="row">
              <div class="col-md-12 mt-2">
                <div id="tablaVenta"></div>                
              </div>
            </div>
            <div class="form-row justify-content-end"> 
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Monto de Tarjeta:</label>
                  <input type="text" class="form-control form-control-sm" onkeypress="return filterFloat(event, this);" id="txtmontovisa" name="txtmontovisa"> 
                </div> 
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Descripción:</label>
                  <input type="text" class="form-control form-control-sm text-uppercase" id="txtdescripcionvisa" name="txtdescripcionvisa">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Número de Ope:</label>
                  <input type="number" class="form-control form-control-sm" id="txtnumopvisa" name="txtnumopvisa">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Pago con:</label>
                  <input type="text" class="form-control form-control-sm" onkeypress="return filterFloat(event, this);" id="txtpagocon" name="txtpagocon" autocomplete="off">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Vuelto:</label>
                  <input type="text" class="form-control form-control-sm" id="txtvuelto" name="txtvuelto" readonly value="0.00">
                </div>
              </div>
            </div>
            <div class="form-row mt-3 justify-content-end">
              <div class="text-right col-md-1 col-2">
                <button title="Realizar Venta" type="submit" class="btn btn-primary" data-toggle="tooltip"
                  data-placement="top">
                  <i class="fas fa-save"></i>
                </button>
              </div>
              <div class="ml-2 col-md-1 col-2">
                <button title="Cancelar" type="button" id="btnCancelarCompra" class=" btn btn-danger"
                  data-toggle="tooltip" data-placement="top">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>              
            </div>
            <br>
          </form>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal Registro Cliente-->
      <div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold">REGISTRAR CLIENTE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="frmCliente">
            <div class="modal-body">
              <div class="form-group">
                <label for="">Nro Doc:</label>
                <input type="text" id="txtdni" name="txtdni" class="form-control form-control-sm">
                <input type="hidden" id="txttipodoc" name="txttipodoc">
              </div>
              <div class="form-group">
                <label for="">Razon Social:</label>
                <input type="text" id="txtrazonsocial" name="txtrazonsocial" class="form-control form-control-sm">
              </div>
              <div class="form-group">
                <label for="">Dirección:</label>
                <textarea name="txtdireccion" id="txtdireccion" class="form-control form-control-sm text-uppercase" rows="2"></textarea>
              </div>            
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
            </div>
            </form>
          </div>
        </div>
      </div>
    <!-- Fin Modal Registro Cliente-->

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
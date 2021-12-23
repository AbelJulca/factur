<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Codilans | Empresa</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- stylo personal-->
  <link href="<?php echo URL ?>public/css/bootstrap.css" rel="stylesheet" type="text/css"/>    
  <link rel="stylesheet" href="<?php echo URL ?>public/css/menu.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?php echo URL ?>public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->
  <link src="<?php echo URL ?>public/css/sweetalert2/bootstrap-4.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo URL ?>public/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?php echo URL ?>public/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
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
          <a href="#" class="nav-link h6 m-0 font-weight-bold text-primary">NUEVA EMPRESA</a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
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
        <img src="<?php echo URL ?>public/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Main row -->
          <div class="row justify-content-end">            
            <div class="col-md-1 mt-2">
              <button id="btnAddempresa" class="btn btn-info btn-sm" type="button" data-toggle="tooltip" data-placement="left" title="Agregar Empresa">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <div class="">
                <table id="datosEmpresa" class="table table-sm table-responsive-md" width="100%">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">RUC</th>
                      <th scope="col">RAZON_SOCIAL</th>
                      <th scope="col">MODO_NOTA</th>
                      <th scope="col">MODO_GUIA</th>
                      <th scope="col">ESTADO</th>
                      <th scope="col">OPCION</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Modal -->
    <div class="modal fade" id="empresaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="empresaModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary font-weight-bold">AGREGAR EMPRESA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frmEmpresa">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-row">
                      <div class="col-md-4 col-5">
                        <label class="font-weight-bold" for="dni">Documento:</label>
                        <select name="cmbdocumP" id="cmbdocumP" class="form-control form-control-sm">
                          <option value="6">RUC</option>
                        </select>
                      </div>
                      <div class="col-md-8 col-7">
                        <label class="font-weight-bold" for="dniP">Número:</label>
                        <div class="form-row">
                          <div class="col-md-7 col-7">
                            <input type="text" maxlength="11" onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" id="dniP" name="dniP" required="" autocomplete="off">
                          </div>
                          <div class="col-md-5 col-5">
                            <button title="Buscar Documento" data-toggle="tooltip" data-placement="top" type="button" id="btnBuscarDni" class="btn btn-warning btn-sm"><i class='fas fa-search'></i></button>
                            <button type="button" class="btn btn-light bg-light loadDni d-none btn-sm">
                              <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                              </div>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mt-3">
                      <label class="font-weight-bold">Razon Social:</label>
                      <textarea rows="2" id="razonsocialP" name="razonsocialP" class="form-control form-control-sm mayus"></textarea>
                    </div>
                    <div class="form-group mt-3">
                      <label class="font-weight-bold">Nombre Comercial:</label>
                      <textarea rows="2" id="nombrecomercialP" name="nombrecomercialP" class="form-control form-control-sm mayus"></textarea>
                    </div>
                    <div class="form-group mt-3">
                      <label class="font-weight-bold">Direccion:</label>
                      <textarea rows="2" id="direccionP" name="direccionP" class="form-control form-control-sm mayus"></textarea>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-4">
                        <label class="font-weight-bold">Pais:</label>
                        <div id="cmbpais"></div>
                      </div>
                      <div class="col-md-8">
                        <label class="font-weight-bold">Departamento:</label>
                        <div id="cmbdepartamento"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <label class="font-weight-bold">Provincia:</label>
                        <div id="cmbprovincia"></div>
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Distrito:</label>
                        <div id="cmbdistrito"></div>
                      </div>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <label class="font-weight-bold">Ubigeo:</label>
                        <input type="text" maxlength="6" id="txtubigeo" name="txtubigeo" onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Usuario Sol:</label>
                        <input type="text" id="txtusuariosol" name="txtusuariosol" class="form-control form-control-sm">
                      </div>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <label class="font-weight-bold">Clave Sol:</label>
                        <input type="text" id="txtclavesol" name="txtclavesol" class="form-control form-control-sm">
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Modo Notas:</label>
                        <select id="txtmodonota" name="txtmodonota" class="form-control form-control-sm">
                          <option value="FE_BETA">FE_BETA</option>
                          <option value="FE_PRODUCCION ">FE_PRODUCCION </option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <label class="font-weight-bold">Modo Guia:</label>
                        <select id="txtmodoguia" name="txtmodoguia" class="form-control form-control-sm">
                          <option value="GUIA_BETA">GUIA_BETA</option>
                          <option value="GUIA_PRODUCCION">GUIA_PRODUCCION</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="text-white">Estado:</label>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="customSwitches" name="chkestado">
                          <label class="custom-control-label" for="customSwitches">Activo</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group text-right mt-3">
                      <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fas fa-save"></i></button>
                      <button type="reset" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Limpiar Formulario"><i class="fas fa-brush"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Modal -->
    <!-- Editar Empresa -->
    <div class="modal fade" id="empresaEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="empresaEditModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary font-weight-bold">EDITAR EMPRESA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frmEmpresaEditar">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-row">
                      <div class="col-md-4 col-5">
                        <label class="font-weight-bold" for="dni">Documento:</label>
                        <select name="cmbdocumPEdit" id="cmbdocumPEdit" class="form-control form-control-sm">
                          <option value="6">RUC</option>
                        </select>
                      </div>
                      <div class="col-md-8 col-7">
                        <label class="font-weight-bold" for="dniPEdit">Número:</label>
                        <div class="form-row">
                          <div class="col-md-7 col-7">
                            <input type="text" maxlength="11" onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" id="dniPEdit" name="dniPEdit" required="" autocomplete="off">
                            <input type="hidden" id="txtcodigo" name="txtcodigo" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mt-3">
                      <label class="font-weight-bold">Razon Social:</label>
                      <textarea rows="2" id="razonsocialPEdit" name="razonsocialPEdit" class="form-control form-control-sm mayus"></textarea>
                    </div>
                    <div class="form-group mt-3">
                      <label class="font-weight-bold">Nombre Comercial:</label>
                      <textarea rows="2" id="nombrecomercialPEdit" name="nombrecomercialPEdit" class="form-control form-control-sm mayus"></textarea>
                    </div>
                    <div class="form-group mt-3">
                      <label class="font-weight-bold">Direccion:</label>
                      <textarea rows="2" id="direccionPEdit" name="direccionPEdit" class="form-control form-control-sm mayus"></textarea>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-4">
                        <label class="font-weight-bold">Pais:</label>
                        <div id="cmbpaisEdit"></div>
                      </div>
                      <div class="col-md-8">
                        <label class="font-weight-bold">Departamento:</label>
                        <div id="cmbdepartamentoEdit"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <label class="font-weight-bold">Provincia:</label>
                        <div id="cmbprovinciaEdit"></div>
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Distrito:</label>
                        <div id="cmbdistritoEdit"></div>
                      </div>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <label class="font-weight-bold">Ubigeo:</label>
                        <input type="text" maxlength="6" id="txtubigeoEdit" name="txtubigeoEdit" onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Usuario Sol:</label>
                        <input type="text" id="txtusuariosolEdit" name="txtusuariosolEdit" class="form-control form-control-sm">
                      </div>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <label class="font-weight-bold">Clave Sol:</label>
                        <input type="text" id="txtclavesolEdit" name="txtclavesolEdit" class="form-control form-control-sm">
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Modo Notas:</label>
                        <select id="txtmodonotaEdit" name="txtmodonotaEdit" class="form-control form-control-sm">
                          <option value="FE_BETA">FE_BETA</option>
                          <option value="FE_PRODUCCION ">FE_PRODUCCION </option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <label class="font-weight-bold">Modo Guia:</label>
                        <select id="txtmodoguiaEdit" name="txtmodoguiaEdit" class="form-control form-control-sm">
                          <option value="GUIA_BETA">GUIA_BETA</option>
                          <option value="GUIA_PRODUCCION">GUIA_PRODUCCION</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="text-white">Estado:</label>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="chkestadoEdit" name="chkestadoEdit">
                          <label class="custom-control-label" for="chkestadoEdit">Activo</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group text-right mt-3">
                      <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fas fa-save"></i></button>
                      <button type="reset" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Limpiar Formulario"><i class="fas fa-brush"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Elimnar -->
    <div class="modal fade" id="ModalEliminar" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ModalEliminarLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold text-primary">AVISO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="h5 text-danger" id="txteliminar"> </p>
            <input type="hidden" id="txtcodigodelete">
          </div>
          <div class="modal-footer">
            <button title="Aceptar" type="button" id="btn-cinfirm-elimina" class="btn btn-success">Si,
              Confirmar!</button>
            <button title="Cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Termina Modal de Eliminar -->

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
  <!-- AdminLTE App -->
  <script src="<?php echo URL ?>public/dist/js/adminlte.js"></script>

  <script src="<?php echo URL ?>public/js/sweetalert2/sweetalert2.all.min.js"></script>

  <?php
  if (isset($this->js)) {
    foreach ($this->js as $js) {
      echo '<script src="' . URL . 'views/' . $js.'?'.rand().'"></script>';
    }
  }
  ?>
</body>

</html>
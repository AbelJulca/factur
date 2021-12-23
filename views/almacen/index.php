<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Codilans | Almacen</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- stylo personal-->
  <link rel="stylesheet" href="<?php echo URL ?>public/css/menu.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?php echo URL ?>public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link src="<?php echo URL ?>public/css/sweetalert2/bootstrap-4.css" rel="stylesheet">

  <!-- Theme style -->
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
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Main row -->
          <div class="row">
            <div class="col-md-12">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item font-weight-bold">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                    aria-controls="home" aria-selected="true">SUCURSAL</a>
                </li>
                <li class="nav-item font-weight-bold">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">ALMACEN</a>
                </li>
                <li class="nav-item font-weight-bold">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                    aria-controls="contact" aria-selected="false">SERIES</a>
                </li>
              </ul>
            </div>
          </div>
          <!-- /.row (main row) -->
          <div class="row">
            <div class="col-md-12">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="container-fluid">
                    <div class="row justify-content-end">
                      <div class="col-md-12 mt-2 text-center text-primary">
                        <h5 class="font-weight-bold">LISTA DE SUCURSALES</h5>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-12">
                        <div class="">
                          <table id="datosSucursal" class="table table-sm table-responsive-md" width="100%">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">DESCRIPCION</th>
                                <th scope="col">UBIGEO</th>
                                <th scope="col">DEPARTAMENTO</th>
                                <th scope="col">PROVINCIA</th>
                                <th scope="col">DISTRITO</th>
                                <th scope="col">DIRECCION</th>
                                <th scope="col">ESTADO</th>
                                <th scope="col">OPCION</th>
                              </tr>
                            </thead>

                          </table>

                        </div>

                      </div>
                    </div>
                    <br>
                  </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="container-fluid">
                    <div class="row justify-content-end">
                      <div class="col-md-12 mt-2 text-center text-primary">
                        <h5 class="font-weight-bold">LISTA DE ALMACEN</h5>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-12">
                        <div class="">
                          <table id="datosAlmacen" class="table table-sm table-responsive-md" width="100%">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">DESCRIPCION</th>
                                <th scope="col">CONDICION</th>
                                <th scope="col">SUCURSAL</th>
                                <th scope="col">ESTADO</th>
                                <th scope="col">OPCION</th>
                              </tr>
                            </thead>

                          </table>

                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group mt-3 mb-3 text-center text-primary">
                          <h6 class="font-weight-bold">LISTA DE SUCURSALES</h6>
                        </div>
                        <table id="datosSerie" class="table table-sm table-responsive-md small" width="100%">
                          <thead class="thead-dark">
                            <tr>
                              <th scope="col">DESCRIPCION</th>
                              <th scope="col">DIRECCION</th>
                              <th scope="col">OPCION</th>
                            </tr>
                          </thead>

                        </table>
                      </div>
                      <div class="col-md-6">
                        <div class="container">
                          <div class="form-group mt-3 mb-3 text-center text-primary">
                            <h6 class="font-weight-bold">REGISTRO DE SERIES</h6>
                          </div>
                          <div class="row justify-content-center">
                            <div class="col-md-10">
                              <div class="card">
                                <div class="card-body">
                                  <div class="form-group text-center">
                                    <h5 class="font-weight-bold" id="txttitulo">Selecciona Sucursal</h5>
                                  </div>                                  
                                  <p class="card-text text-justify">La serie se compone de 4 caracteres, si es Boleta empieza con una <strong>B</strong>
                                  si es Factura empieza con <strong>F</strong> seguidos de 3 caracteres que pueden ser alfanumericos FXXX-########
                                  </p>
                                  <form id="formSerie">
                                    <div class="form-group">
                                      <div class="form-row">
                                        <input type="hidden" id="txtidsucurser" name="txtidsucurser"/>
                                        <div class="col-md-6">
                                          <label>Tipo Comprobante</label>
                                          <div id="cmbtipocomprobante"></div>
                                        </div>
                                        <div class="col-md-6">
                                          <label>Introdusca su serie</label>
                                          <input type="text" name="txtserie" id="txtserie" maxlength="4" class="form-control form-control-sm text-uppercase" autocomplete="off">
                                        </div>
                                      </div>
                                      <div class="form-row justify-content-end nc-one d-none">
                                        <div class="col-md-6">
                                          <label for="">Referencia: </label>
                                          <select class="form-control form-control-sm" name="txtref" id="txtref">
                                            <option value="03">BOLETA</option>
                                            <option value="01">FACTURA</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group text-right">
                                      <button type="submit" class="btn btn-primary">Registrar</button>
                                    </div>
                                  </form>

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Modal Sucursal-->
    <div class="modal fade" id="sucursalModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
      aria-labelledby="sucursalModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary font-weight-bold">AGREGAR SUCURSAL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frmSucursal">
              <div class="form-group">
                <label class="font-weight-bold">Descripcion:</label>
                <input rows="2" id="txtdesccripcion" name="txtdesccripcion"
                  class="form-control form-control-sm text-uppercase" />
              </div>
              <div class="form-group mt-3">
                <label class="font-weight-bold">Direccion:</label>
                <textarea rows="2" id="txtdireccion" name="txtdireccion"
                  class="form-control form-control-sm text-uppercase"></textarea>
              </div>
              <div class="form-group mt-3">
                <label class="font-weight-bold">Empresa:</label>
                <div id="cmbempresa"></div>
              </div>
              <div class="form-row mt-3">
                <div class="col-md-6">
                  <label class="font-weight-bold">Departamento:</label>
                  <div id="cmbdepartamento"></div>
                </div>
                <div class="col-md-6">
                  <label class="font-weight-bold">Provincia:</label>
                  <div id="cmbprovincia"></div>
                </div>
              </div>
              <div class="form-row mt-3">
                <div class="col-md-6">
                  <label class="font-weight-bold">Distrito:</label>
                  <div id="cmbdistrito"></div>
                </div>
                <div class="col-md-6">
                  <label class="font-weight-bold">Ubigeo:</label>
                  <input type="text" maxlength="6" id="txtubigeo" name="txtubigeo"
                    onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" autocomplete="off">
                </div>
              </div>
              <div class="form-row mt-3">
                <div class="col-md-6">
                  <label class="text-white">Estado:</label>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitches" name="chkestado">
                    <label class="custom-control-label" for="customSwitches">Activo</label>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                  title="Guardar"><i class="fas fa-save"></i></button>
                <button type="reset" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                  title="Limpiar Formulario"><i class="fas fa-brush"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Modal Sucursal-->
    <!-- Editar Sucursal -->
    <div class="modal fade" id="sucursalEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      role="dialog" aria-labelledby="sucursalEditModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary font-weight-bold">EDITAR SUCURSAL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frmEditSucursal">
              <div class="form-group">
                <label class="font-weight-bold">Descripcion:</label>
                <input type="hidden" id="txtidsuc" name="txtidsuc" />
                <input rows="2" id="txtdesccripcionEdit" name="txtdesccripcionEdit"
                  class="form-control form-control-sm text-uppercase" />
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Direccion:</label>
                <textarea rows="2" id="txtdireccionEdit" name="txtdireccionEdit"
                  class="form-control form-control-sm text-uppercase"></textarea>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Empresa:</label>
                <div id="cmbempresaEdit"></div>
              </div>
              <div class="form-row">
                <div class="col-md-6">
                  <label class="font-weight-bold">Departamento:</label>
                  <div id="cmbdepartamentoEdit"></div>
                </div>
                <div class="col-md-6">
                  <label class="font-weight-bold">Provincia:</label>
                  <div id="cmbprovinciaEdit"></div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6">
                  <label class="font-weight-bold">Distrito:</label>
                  <div id="cmbdistritoEdit"></div>
                </div>
                <div class="col-md-6">
                  <label class="font-weight-bold">Ubigeo:</label>
                  <input type="text" maxlength="6" id="txtubigeoEdit" name="txtubigeoEdit"
                    onKeyPress="return soloNumeros(event)" class="form-control form-control-sm" autocomplete="off">
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6">
                  <label class="text-white">Estado:</label>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitchesEdit" name="chkestadoEdit">
                    <label class="custom-control-label" for="customSwitchesEdit">Activo</label>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                  title="Modificar"><i class="fas fa-save"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de Elimnar -->
    <div class="modal fade" id="ModalEliminar" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
      aria-labelledby="ModalEliminarLabel" aria-hidden="true">
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
            <input type="hidden" id="txtcodigo">
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

    <!-- Modal Almacen-->
    <div class="modal fade" id="almacenModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
      aria-labelledby="almacenModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary font-weight-bold">AGREGAR ALMACEN</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frmAlmacen">
              <div class="form-group">
                <label class="font-weight-bold">Descripcion:</label>
                <input rows="2" id="txtdescalmacen" name="txtdescalmacen"
                  class="form-control form-control-sm text-uppercase" />
              </div>
              <div class="form-group mt-3">
                <label class="font-weight-bold">Sucursal:</label>
                <div id="cmbsucursal"></div>
              </div>
              <div class="form-row mt-3">
                <div class="col-md-6">
                  <label class="font-weight-bold">Condicion:</label>
                  <select name="txtcondicion" id="txtcondicion" class="form-control form-control-sm">
                    <option value="FISICO">FISICO</option>
                    <option value="VIRTUAL">VIRTUAL</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="text-white">Estado:</label>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="chkalmacen" name="chkalmacen">
                    <label class="custom-control-label" for="chkalmacen">Activo</label>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                  title="Guardar"><i class="fas fa-save"></i></button>
                <button type="reset" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                  title="Limpiar Formulario"><i class="fas fa-brush"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Modal Almacen -->

    <!-- Modal Editar Almacen-->
    <div class="modal fade" id="almacenEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      role="dialog" aria-labelledby="almacenEditModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary font-weight-bold">AGREGAR ALMACEN</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frmEditAlmacen">
              <div class="form-group">
                <label class="font-weight-bold">Descripcion:</label>
                <input rows="2" id="txtdescalmacenEdit" name="txtdescalmacenEdit"
                  class="form-control form-control-sm text-uppercase" />
                <input type="hidden" id="txtidalm" name="txtidalm" />
              </div>
              <div class="form-group mt-3">
                <label class="font-weight-bold">Sucursal:</label>
                <div id="cmbsucursalEdit"></div>
              </div>
              <div class="form-row mt-3">
                <div class="col-md-6">
                  <label class="font-weight-bold">Condicion:</label>
                  <select name="txtcondicionEdit" id="txtcondicionEdit" class="form-control form-control-sm">
                    <option value="FISICO">FISICO</option>
                    <option value="VIRTUAL">VIRTUAL</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="text-white">Estado:</label>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="chkalmacenEdit" name="chkalmacenEdit">
                    <label class="custom-control-label" for="chkalmacenEdit">Activo</label>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                  title="Guardar"><i class="fas fa-save"></i></button>
                <button type="reset" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                  title="Limpiar Formulario"><i class="fas fa-brush"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Modal Editar Almacen -->

    <!-- Modal de Elimnar Almacen-->
    <div class="modal fade" id="ModalEliminarAlmacen" data-backdrop="static" data-keyboard="false" tabindex="-1"
      role="dialog" aria-labelledby="ModalEliminarAlmacenLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold text-primary">AVISO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="h5 text-danger" id="txteliminarAlma"> </p>
            <input type="hidden" id="txtcodigoAlmacen">
          </div>
          <div class="modal-footer">
            <button title="Aceptar" type="button" id="btn-cinfirm-elimina-almacen" class="btn btn-success">Si,
              Confirmar!</button>
            <button title="Cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Termina Modal de Eliminar Almacen-->
    <!-- Modal Lista de Series-->
    <div class="modal fade" id="seriesModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="seriesModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold text-primary" id="txttituloserie">LISTA DE SERIES</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="tablaSeries"></div>
          </div>
        </div>
      </div>
    </div>
<!-- Termina Modal Lista de Series-->
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
      echo '<script src="' . URL . 'views/' . $js .'?'.rand().'"></script>';
    }
  }
  ?>
</body>

</html>
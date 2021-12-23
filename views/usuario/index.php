<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Cix | Usuario</title>

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
    <link rel="stylesheet"
        href="<?php echo URL ?>public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo URL ?>public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link src="<?php echo URL?>public/css/sweetalert2/bootstrap-4.css" rel="stylesheet">

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
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link h6 m-0 text-primary font-weight-bold">LISTA DE USUARIOS</a>
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
                        <img src="<?php echo URL ?>public/images/logo_codilans.png" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">CODILANS</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
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
            <br>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                <table id="datosUsuario" class="table table-sm table-responsive-md" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">CODIGO</th>
                                            <th scope="col">NOMBRES</th>
                                            <th scope="col">TELEFONO</th>
                                            <th scope="col">DIRECCION</th>
                                            <th scope="col">USUARIO</th>
                                            <th scope="col">PERFIL</th>
                                            <th scope="col">ALMACEN</th>
                                            <th scope="col">ESTADO</th>
                                            <th scope="col">OPCION</th>
                                        </tr>
                                    </thead>

                                </table>

                            </div>

                        </div>
                    </div>
                    <br>
                    <!-- /.row (main row) -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Modal -->
        <div class="modal fade" id="usuarioModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="proveedorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold">AGREGAR USUARIO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmUsuario">
                            <div class="form-row">
                                <div class="col-md-6 col-7">
                                    <label class="font-weight-bold" for="dniP">Dni:</label>
                                    <div class="form-row">
                                        <div class="col-md-8 col-7">
                                            <input maxlength="8" type="text" onKeyPress="return soloNumeros(event)"
                                                class="form-control form-control-sm" id="txtdni" name="txtdni"
                                                required="" autocomplete="off">
                                        </div>
                                        <div class="col-md-4 col-5 d-flex">
                                            <button title="Buscar Documento" data-toggle="tooltip" data-placement="top"
                                                type="button" id="btnBuscarDni" class="btn btn-warning btn-sm"><i
                                                    class='fas fa-search'></i></button>
                                            <button type="button" class="btn btn-light bg-light loadDni d-none btn-sm">
                                                <div class="spinner-border spinner-border-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Nombre:</label>
                                    <input type="text" id="txtnombre" name="txtnombre"
                                        class="form-control form-control-sm mayus" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Apellido Paterno:</label>
                                    <input type="text" id="txtapep" name="txtapep"
                                        class="form-control form-control-sm mayus" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Apellido Materno:</label>
                                    <input type="text" id="txtapem" name="txtapem"
                                        class="form-control form-control-sm mayus" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Telefono:</label>
                                    <input maxlength="9" type="text" onKeyPress="return soloNumeros(event)"
                                        class="form-control form-control-sm" id="txttelefono" name="txttelefono"
                                        autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Perfil:</label>
                                    <div id="cmbperfil"></div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold">Almacen:</label>
                                <div id="cmbalmacen"></div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold">Direccion:</label>
                                <input type="text" id="txtdireccion" name="txtdireccion"
                                    class="form-control form-control-sm mayus" autocomplete="off">
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Usuario:</label>
                                    <input type="text" id="txtusuario" name="txtusuario"
                                        class="form-control form-control-sm" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Clave:</label>
                                    <input type="password" id="txtpass" name="txtpass" data-toggle="tooltip"
                                        data-placement="top" title="Clave por defecto 1 - 6"
                                        class="form-control form-control-sm" value="123456" autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip"
                                    data-placement="top" title="Guardar"><i class="fas fa-save"></i></button>
                                <button type="reset" class="btn btn-warning btn-sm" data-toggle="tooltip"
                                    data-placement="top" title="Limpiar Formulario"><i
                                        class="fas fa-brush"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
        <!-- Modal Editar Producto -->
        <div class="modal fade" id="usuarioEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="usuarioEditModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold">EDITAR USUARIO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmEditUsuario">
                            <div class="form-row">
                                <div class="col-md-6 col-7">
                                    <label class="font-weight-bold" for="txtdniEdit">Dni:</label>
                                    <input type="hidden" id="txtidusuario" name="txtidusuario" />
                                    <input maxlength="8" type="text" onKeyPress="return soloNumeros(event)"
                                        class="form-control form-control-sm" id="txtdniEdit" name="txtdniEdit"
                                        required="" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Nombre:</label>
                                    <input type="text" id="txtnombreEdit" name="txtnombreEdit"
                                        class="form-control form-control-sm mayus" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Apellido Paterno:</label>
                                    <input type="text" id="txtapepEdit" name="txtapepEdit"
                                        class="form-control form-control-sm mayus" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Apellido Materno:</label>
                                    <input type="text" id="txtapemEdit" name="txtapemEdit"
                                        class="form-control form-control-sm mayus" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Telefono:</label>
                                    <input maxlength="9" type="text" onKeyPress="return soloNumeros(event)"
                                        class="form-control form-control-sm" id="txttelefonoEdit" name="txttelefonoEdit"
                                        autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Perfil:</label>
                                    <div id="cmbperfilEdit"></div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold">Almacen:</label>
                                <div id="cmbalmacenEdit"></div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold">Direccion:</label>
                                <input type="text" id="txtdireccionEdit" name="txtdireccionEdit"
                                    class="form-control form-control-sm mayus" autocomplete="off">
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Usuario:</label>
                                    <input type="text" id="txtusuarioEdit" name="txtusuarioEdit"
                                        class="form-control form-control-sm" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Clave:</label>
                                    <input type="password" id="txtpassEdit" name="txtpassEdit"
                                        class="form-control form-control-sm" autocomplete="off">
                                </div>
                            </div>
                            <div>
                                <label class="text-white">Estado:</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitches"
                                        name="chkestado">
                                    <label class="custom-control-label" for="customSwitches">Activo</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip"
                                    data-placement="top" title="Modificar"><i class="fas fa-save"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal Editar Producto -->

        <!-- Modal de Elimnar -->
        <div class="modal fade" id="acccesosModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="acccesosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold text-primary">ACCESO ALMACEN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmAccesoAlmacen">
                            <div class="form-group">
                                <input type="hidden" id="txtidusuarioacces" name="txtidusuarioacces">
                                <label for="">Sucursal:</label>
                                <div id="cmbsucursal"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Almacen:</label>
                                <div id="cmbalmacenSucursal"></div>
                            </div>
                            <div class="modal-footer">
                                <button data-toggle="tooltip" data-placement="top" title="Guardar" type="submit"
                                    class="btn btn-success"><i class="fas fa-save"></i></button>
                            </div>
                        </form>
                        <div class="form-group">
                            <table id="datosAccesosAlmacen" class="table table-sm table-responsive-md" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">SUCURSAL</th>
                                        <th scope="col">ALMACEN</th>
                                        <th scope="col">CONDICION</th>
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
    <script src="<?php echo URL?>public/js/sweetalert2/sweetalert2.all.min.js"></script>

    <?php
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                echo '<script src="' . URL . 'views/' . $js .'?'.rand().'"></script>';
            }
        }
        ?>
</body>

</html>
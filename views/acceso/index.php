<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codilans | Usuario</title>

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
                    <a href="#" class="nav-link h6 m-0 text-primary font-weight-bold">ACCESOS</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <!-- Notifications Dropdown Menu -->
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
            <section class="content">
                <div class="container-fluid">
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group text-center">
                                                            <h5 class="font-weight-bold">INGRESE UN NUEVO PERFIL</h5>
                                                        </div>
                                                        <form id="formPerfil">
                                                        <label>Nombre:</label>
                                                            <div class="form-group">
                                                                <div class="form-row">
                                                                    <div class="col-md-10">                                                                        
                                                                        <input type="text" name="txtperfil" id="txtperfil" class="form-control form-control-sm text-uppercase" required="" autocomplete="off">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="submit" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Registrar"><i class="fas fa-save"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <table id="datosPerfil"
                                                    class="table table-sm table-responsive-md small" width="100%">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">COD</th>
                                                            <th scope="col">NOMBRE</th>
                                                            <th scope="col" class="text-center">OPCION</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                            <div class="card">
                                                <div class="card-body">
                                                        <div class="form-group text-center">
                                                            <h5 class="font-weight-bold" id="txttitulo">SELECCIONE UN PERFIL</h5>
                                                        </div>
                                                        <label>ENCABEZADOS:</label>
                                                            <div class="form-group">
                                                                <div class="form-row">
                                                                    <div class="col-md-9">                                                                        
                                                                        <div id="cmbmenu"></div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button" id="btnpermiso" class="btn btn-primary btn-sm">PERMISOS</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    ...
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    ...</div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (main row) -->
                    
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Modal -->
        <div class="modal fade" id="perfilEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="proveedorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold">EDITAR PERFIL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditPerfil">
                            <label>Nombre:</label>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-10">
                                        <input type="hidden" name="txtidperfil" id="txtidperfil">                                                                       
                                        <input type="text" name="txtperfilEdit" id="txtperfilEdit" class="form-control form-control-sm text-uppercase" required="" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Modificar"><i class="fas fa-save"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
        <!-- Modal Editar Producto -->
        <div class="modal fade" id="permisosModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="usuarioEditModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold">ASIGNAR PERMISOS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmPermisos">
                            <input type="hidden" id="txtcodigoperfil" name="txtcodigoperfil">
                            <input type="hidden" id="txtnombrepadre" name="txtnombrepadre">
                            <div id="listaHijos"></div>
                            <div class="float-right">
                                <button type="submit" id="btnaplicarcambios" class="btn btn-primary">Aplicar Cambios</button>
                            </div> 
                        </form>                                             
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal Editar Producto -->

        <!-- Modal de Elimnar -->
        <div class="modal fade" id="ModalEliminar" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="ModalEliminarLabel" aria-hidden="true">
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
                        <button title="Cancelar" type="button" class="btn btn-danger"
                            data-dismiss="modal">Cancelar</button>
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
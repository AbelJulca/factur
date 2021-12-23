<div class="btn-group btn-group-sm">
  <button type="button" class="view-1 btn btn-while dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php echo Session::get('nombreUser').' '.Session::get('apellpUser').' '.Session::get('apellmUser') ?>
  </button>
  <button type="button" class="view-2 btn btn-while dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <b class="view-font"><?php echo Session::get('nombreUser')?></b>
  </button>
  <div class="dropdown-menu dropdown-menu-right">
    <a class="dropdown-item" href="datos/index"><i class="far fa-address-card mr-2"></i>Mis Datos</a>
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#almacenModalCenter"><i class="fas fa-warehouse mr-2"></i>Cambiar Almacen</a>
    <a class="dropdown-item" href="dashboard/logout"><i class="fas fa-sign-out-alt mr-2"></i>Salir</a>
  </div>
</div>
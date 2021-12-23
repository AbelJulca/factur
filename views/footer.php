<!-- Modal cambiar almacen -->
<div class="modal fade" id="almacenModalCenter" tabindex="-1" role="dialog" aria-labelledby="almacenModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">CAMBIAR ALMACEN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="frmcambioalmacenAC">
      <div class="modal-body">
        <div class="form-group">
          <div id="empresaCA"></div>
        </div>
        <div class="form-group">
          <div id="sucursalCA"></div>
        </div>
        <div class="form-group">
          <div id="almacenCA"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Aplicar Cambios</button>
      </div>
      </form>
    </div>
  </div>
</div>

<footer class="main-footer">
  <strong>Copyright &copy; 2014-2021 <a href="https://www.codilans-pe.com">Codilans-pe.com</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0 <b class="ml-3"><?php echo Session::get('sucursal'). ' | ' .Session::get('almacen') ?></b>
  </div>
</footer>
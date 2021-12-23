<?php
Session::init();
$menu = array_values(Session::get('menu'));
$rutas = array_values(Session::get('rutas'));
?> 
<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="<?php echo URL ?>dashboard" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>

    <?php if ($menu[0]['estado'] == '1'): ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-building"></i>
          <p>
            Entidad         
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($rutas[0]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="<?php echo URL ?>empresa" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Empresa</p>
              </a>
            </li>
          <?php endif; ?> 

          <?php if ($rutas[1]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="<?php echo URL ?>periodo" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Periodo</p>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; ?> 
    
    <?php if ($menu[1]['estado'] == '1'): ?>
      <li class="nav-item">      
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-copy"></i>
          <p>        
              Registros
            <i class="fas fa-angle-left right"></i>
          </p>
        </a> 
        <ul class="nav nav-treeview">
          <?php if ($rutas[2]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="<?php echo URL ?>almacen" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Almacen</p>
              </a>
            </li>             
          <?php endif; ?>
          <?php if ($rutas[3]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="<?php echo URL ?>cliente" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Clientes</p>
              </a>
            </li>            
          <?php endif; ?>
          <?php if ($rutas[4]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="<?php echo URL ?>proveedor" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Proveedor</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($rutas[5]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="<?php echo URL ?>categoria" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categoria</p>
              </a>
            </li>          
          <?php endif; ?>
          <?php if ($rutas[6]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="<?php echo URL ?>producto" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Producto</p>
              </a>
            </li>          
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; ?>

    <?php if ($menu[2]['estado'] == '1'): ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-comment-dollar"></i>
          <p>
            Gestion Venta
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($rutas[7]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="comprobante" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Comprobante</p>
              </a>
            </li>       
          <?php endif; ?>
          <?php if ($rutas[8]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="reporteVenta" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Venta</p>
              </a>
            </li>        
          <?php endif; ?>
          <?php if ($rutas[9]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="reportecredito" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Creditos</p>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; ?>

    <?php if ($menu[3]['estado'] == '1'): ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>
            Compras
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($rutas[10]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="compras" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Nueva Compra</p>
              </a>
            </li>           
          <?php endif; ?>
          <?php if ($rutas[11]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="consultacompras" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Consulta Compra</p>
              </a>
            </li>           
          <?php endif; ?> 
          <?php if ($rutas[12]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="bajacompra" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Baja Compra</p>
              </a>
            </li>
          <?php endif; ?> 
          <?php if ($rutas[13]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="reportebajacompras" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Bajas</p>
              </a>
            </li>
          <?php endif; ?> 
        </ul>
      </li>
    <?php endif; ?>

    <?php if ($menu[4]['estado'] == '1'): ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cash-register"></i>
          <p>
            Caja
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($rutas[14]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="caja" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Apertura</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($rutas[15]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="movimiento" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Movimientos</p>
              </a>
            </li>
          <?php endif; ?>  
        </ul>
      </li>
    <?php endif; ?>

    <?php if ($menu[5]['estado'] == '1'): ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-edit"></i>
          <p>
            Sunat
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($rutas[16]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="factura" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Factura</p>
              </a>
            </li>            
          <?php endif; ?> 
          <?php if ($rutas[17]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="boleta" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Boletas</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($rutas[18]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="notacredito" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Nota Credito</p>
              </a>
            </li>            
          <?php endif; ?> 
          <?php if ($rutas[19]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="notadebito" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Nota Debito</p>
              </a>
            </li>
          <?php endif; ?> 
          <?php if ($rutas[20]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="bajaboletas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Baja Boletas</p>
              </a>
            </li>
          <?php endif; ?> 
          <?php if ($rutas[21]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="bajafacturas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Baja Facturas</p>
              </a>
            </li>
          <?php endif; ?> 
        </ul>
      </li>
    <?php endif; ?>

    <?php if ($menu[6]['estado'] == '1'): ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-clipboard-list"></i>
          <p>
            Reportes Sunat
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($rutas[22]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="reportenotacredito" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Nota Credito</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($rutas[23]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="reportenotadebito" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Nota Debito</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($rutas[24]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="reportebajafac" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Baja Facturas</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($rutas[25]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="reportebajabol" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Baja Boletas</p>
              </a>
            </li>
          <?php endif; ?>          
        </ul>
      </li>
    <?php endif; ?>

    <?php if ($menu[7]['estado'] == '1'): ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-table"></i>
          <p>
            Otros
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($rutas[26]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="guiaremision" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Guia Remision</p>
              </a>
            </li>
          <?php endif; ?> 
          <?php if ($rutas[27]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="transportista" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Transportista</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($rutas[28]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="reporteguia" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte Guia</p>
              </a>
            </li>
          <?php endif; ?>   
        </ul>
      </li>
    <?php endif; ?>

    <?php if ($menu[8]['estado'] == '1'): ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-shield"></i>
          <p>
            Permisos
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php if ($rutas[29]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="usuario" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Usuarios</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($rutas[30]['estado'] == '1'): ?>
            <li class="nav-item">
              <a href="acceso" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Accesos</p>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php endif; ?>
  </ul>
</nav>
<!-- /.sidebar-menu -->
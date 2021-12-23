<select name="txtsucursal" id="txtsucursal" class="form-control form-control-sm" onchange="obtenerAlmacen()">        
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] .'-'. $value['direccion']?>
            </option>
         <?php endforeach; ?> 
</select>
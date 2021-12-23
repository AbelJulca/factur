<label for="">Sucursal:</label>
<select name="txtsucursalCA" id="txtsucursalCA" class="form-control form-control-sm" onchange="llenaralmacenCA()">       
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>
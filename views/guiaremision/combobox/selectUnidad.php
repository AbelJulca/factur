<select name="txtunidad" id="txtunidad" class="form-control form-control-sm" >    
          <?php foreach ($this->Listar as $key => $value): ?>
            <option class="codiland-select" value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>
<small id="smallunidad" class="text-danger h6 d-none">Seleccione Unidad****.</small>

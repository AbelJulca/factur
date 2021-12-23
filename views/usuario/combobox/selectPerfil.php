<select name="txtperfil" id="txtperfil" class="form-control form-control-sm">
<option value="0">--SELECCIONE UNO--</option>          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>
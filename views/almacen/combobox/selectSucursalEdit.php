<select name="txtsucursalEdit" id="txtsucursalEdit" class="form-control form-control-sm" >          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>
<select name="txtmenu" id="txtmenu" class="form-control form-control-sm text-uppercase">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['descripcion'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
          <?php endforeach; ?> 
</select>


<select name="txtemisor" id="txtemisor" class="form-control">          
          <?php foreach ($this->ListarEmisor as $key => $value): ?>
            <option class="codiland-select" value="<?php echo $value['codigo'] ?>">
              <?php echo $value['razon_social'] ?>
            </option>
         <?php endforeach; ?> 
</select>


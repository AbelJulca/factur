<select name="txtempresa" id="txtempresa" class="form-control form-control-sm" >          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['razon_social'] ?>
            </option>
         <?php endforeach; ?> 
</select>
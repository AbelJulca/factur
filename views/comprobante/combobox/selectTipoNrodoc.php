<select name="txttiponrodoc" id="txttiponrodoc" class="form-control form-control-sm">        
          <?php foreach ($this->Listar as $key => $value): ?>
            <?php //if($value['codigo'] == '01' || $value['codigo'] == '03' || $value['codigo'] == '04' ){ ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
            <?php //} ?>
         <?php endforeach; ?> 
</select>

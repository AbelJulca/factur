<select name="txtdocumento" id="txtdocumento" class="form-control form-control-sm">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <?php if($value['codigo'] == '1'): ?>
              <option value="<?php echo $value['codigo'] ?>">
                <?php echo $value['descripcion'] ?>
              </option>
            <?php endif; ?>
         <?php endforeach; ?> 
</select>
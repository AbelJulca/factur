<select name="txtafectacion" id="txtafectacion" class="form-control form-control-sm">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>

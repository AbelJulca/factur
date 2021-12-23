<select name="txtperiodo" id="txtperiodo" class="form-control form-control-sm"  style="width: 100%;">        
          <?php foreach ($this->Listar as $key => $value): ?>            
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>           
         <?php endforeach; ?> 
</select>
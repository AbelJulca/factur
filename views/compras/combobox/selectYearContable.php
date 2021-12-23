<select name="txtyearcontable" id="txtyearcontable" class="form-control form-control-sm"  style="width: 100%;">        
          <?php foreach ($this->Listar as $key => $value): ?>            
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['actual'] ?>
            </option>           
         <?php endforeach; ?> 
</select>

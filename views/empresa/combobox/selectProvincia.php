<select name="txtprovincia" id="txtprovincia" class="form-control form-control-sm" onchange="ListarDistrito()">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo_provincia'] ?>">
              <?php echo $value['provincia'] ?>
            </option>
         <?php endforeach; ?> 
</select>
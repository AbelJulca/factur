<select name="txtdistrito" id="txtdistrito" class="form-control form-control-sm" onchange="llenarubigeo()">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo_distrito'] ?>">
              <?php echo $value['distrito'] ?>
            </option>
         <?php endforeach; ?> 
</select>
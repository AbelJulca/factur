<select name="serieNc" id="serieNc" class="form-control" onchange="cambiarCorrelativo()">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['serie'] ?>
            </option>
         <?php endforeach; ?> 
</select>


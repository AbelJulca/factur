<select name="serieNcrRef" id="serieNcrRef" class="form-control" onchange="seriesReferencia()" >          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['serie'] ?>
            </option>
         <?php endforeach; ?> 
</select>


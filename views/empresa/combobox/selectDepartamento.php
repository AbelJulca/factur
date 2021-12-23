<select name="txtdepartamento" id="txtdepartamento" class="form-control form-control-sm" onchange="ListarProvincia()">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo_departamento'] ?>">
              <?php echo $value['departamento'] ?>
            </option>
         <?php endforeach; ?> 
</select>
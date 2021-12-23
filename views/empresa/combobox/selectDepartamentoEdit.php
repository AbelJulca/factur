<select name="txtdepartamentoEdit" id="txtdepartamentoEdit" class="form-control form-control-sm" onchange="ListarProvinciaEdit()">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo_departamento'] ?>">
              <?php echo $value['departamento'] ?>
            </option>
         <?php endforeach; ?> 
</select>
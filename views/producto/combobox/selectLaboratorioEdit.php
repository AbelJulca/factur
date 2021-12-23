<select name="txtlaboratorioEdit" id="txtlaboratorioEdit" class="form-control form-control-sm">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['nombre'] ?>
            </option>
         <?php endforeach; ?> 
</select>

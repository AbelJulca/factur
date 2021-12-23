<select name="txtdocumentoEdit" id="txtdocumentoEdit" class="form-control form-control-sm" onchange="cambiardoc()">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>
<select name="txtprovinciaEdit" id="txtprovinciaEdit" class="form-control form-control-sm" onchange="ListarDistritoEdit()">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo_provincia'] ?>">
              <?php echo $value['provincia'] ?>
            </option>
         <?php endforeach; ?> 
</select>
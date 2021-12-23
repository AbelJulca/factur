<select name="txttipocomprobante" id="txttipocomprobante" class="form-control form-control-sm" onchange="notacd()" >          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>
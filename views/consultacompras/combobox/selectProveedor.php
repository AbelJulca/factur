<select name="txtproveedor" id="txtproveedor" class="select2"  style="width: 100%;" onchange="listarProveedor()">
<option selected value="0">--SELECCIONE UNO--</option>          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['razon_social'] ?>
            </option>
         <?php endforeach; ?> 
</select>

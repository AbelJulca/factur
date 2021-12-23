<label for="">Empresa:</label>
<select name="txtempresaCA" id="txtempresaCA" class="form-control form-control-sm" onchange="llenarsucursalCA()">       
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>
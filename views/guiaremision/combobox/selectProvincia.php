<select name="txtprovincia" id="txtprovincia" class="form-control" onchange="llenarDistrito()"> 
    <option value="00">--Seleccione Uno--</option>
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>


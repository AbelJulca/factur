<label class="font-weight-bold" >Modo Traslado:</label>
<select name="txtmodotraslado" id="txtmodotraslado" class="form-control form-control-sm" onchange="modoprivado()">          
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>


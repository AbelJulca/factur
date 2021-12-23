<select name="txttipodocumento" id="txttipodocumento" class="form-control form-control-sm"  style="width: 100%;">        
          <?php foreach ($this->Listar as $key => $value): ?>
            <?php if($value['codigo'] == '01' || $value['codigo'] == '03' ){ ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
            <?php } ?>
         <?php endforeach; ?> 
</select>

<?php if(Session::get('idperfil') == '1' || Session::get('idperfil') == '2'){ ?> 
<select name="txtalmacen" id="txtalmacen" class="select2"  style="width: 100%;" onchange="renovarDatos()">        
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>
<?php }else{ ?> 
<select name="txtalmacen" id="txtalmacen" class="select2"  style="width: 100%;" disabled="true">        
          <?php foreach ($this->Listar as $key => $value): ?>
            <option value="<?php echo $value['codigo'] ?>">
              <?php echo $value['descripcion'] ?>
            </option>
         <?php endforeach; ?> 
</select>

<?php } ?> 

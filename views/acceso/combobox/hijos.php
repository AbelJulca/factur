<?php foreach ($this->Listar as $key => $value): ?>
 <?php if($value['estado'] == '1'){ ?>  
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <input type="checkbox" name="permisos[]" value="<?php echo $value['codigo'] ?>" checked="checked">
        </div>
    </div>
    <input type="text" class="form-control text-uppercase" readonly="" value="<?php echo $value['ruta'] ?>">
</div>
<?php }else{ ?>
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <input type="checkbox" name="permisos[]" value="<?php echo $value['codigo'] ?>">
        </div>
    </div>
    <input type="text" class="form-control text-uppercase" readonly="" value="<?php echo $value['ruta'] ?>">
</div>

<?php }?>
<?php endforeach; ?>
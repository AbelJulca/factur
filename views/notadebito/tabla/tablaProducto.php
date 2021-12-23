<table class="table table-sm table-responsive-md">
    <thead>
        <tr>
            <!--<th scope="col">COD</th>-->
            <th scope="col" class="text-center">COMERCIAL</th>
            <th scope="col" class="text-center">GENERICO</th>
            <th scope="col" class="text-center">FECHA_V</th>
            <th scope="col">PRECIO</th>
            <th scope="col">CANTIDAD</th>
            <th scope="col">AGREGAR</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->Listar as $key => $value): ?>
            <tr>                
                <th><?php echo $value['nombre_comercial'] ?></th>
                <th><?php echo $value['nombre_generico'] ?></th>
                <th><?php echo $value['fecha_vencimiento'] ?></th>                
                <th><input class="form-control form-control-sm" value="<?php echo $value['precio_referencial'] ?>" onkeypress="return filterFloat(event, this);" id="txtprecio<?php echo $value['codigo'] ?>" type="text" autocomplete="off"/></th>
                <th><input class="form-control form-control-sm" id="txtCantidad<?php echo $value['codigo'] ?>" value="0" type="number" min="0" autocomplete="off"/></th>
                <th class="text-center">
                    <button type="button" class="btn btn-primary btn-sm" onclick="AgregarCarrito('<?= $value['codigo'] ?>')"> + </button>                  
                </th>                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

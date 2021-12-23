<table class="table table-sm table-responsive-md">
    <thead>
        <tr>
            <th scope="col" class="text-center">DESCRIPCION</th>
            <th scope="col" class="text-center">FECHA_V</th>
            <th scope="col">COMPRA</th>
            <th scope="col">CANTIDAD</th>
            <th scope="col">AGREGAR</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->Listar as $key => $value): ?>
            <tr>                
                <th><small class="text-body font-weight-bold"><?php echo $value['nombre_comercial'] ?> </small></th>
                <th><input class="form-control form-control-sm" id="txtfechaven<?php echo $value['codigo'] ?>" type="date"/></th>
                <th><input class="form-control form-control-sm" onkeypress="return filterFloat(event, this);" id="txtprecio<?php echo $value['codigo'] ?>" type="text" autocomplete="off"/></th>
                <th><input class="form-control form-control-sm" id="txtCantidad<?php echo $value['codigo'] ?>" value="0" type="number" min="0" autocomplete="off"/></th>
                <th class="text-center">
                    <button type="button" class="btn btn-primary btn-sm" onclick="AgregarCarrito('<?= $value['codigo'] ?>')"> + </button>                  
                </th>                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

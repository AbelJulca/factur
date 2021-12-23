<table class="table table-sm table-responsive-md">
    <thead>
        <tr>
            <!--<th scope="col">COD</th>-->
            <th scope="col" class="text-center">COMERCIAL</th>
            <th scope="col" class="text-center">GENERICO</th>
            <th scope="col">AGREGAR</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->Listar as $key => $value): ?>
            <tr>                
                <th><?php echo $value['nombre_comercial'] ?></th>
                <th><?php echo $value['nombre_generico'] ?></th>
                <th class="text-center">
                    <button type="button" class="btn btn-primary btn-sm" onclick="AgregarCarrito('<?= $value['codigo'] ?>','<?= $value['nombre_comercial'] ?>')"> + </button>                  
                </th>                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

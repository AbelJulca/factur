<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">CODIGO</th>
            <th scope="col" class="text-center">DESCRIPCION</th>
            <th scope="col">PRECIO</th>            
            <th scope="col">STOCK</th>            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->Listar as $key => $value): ?>
            <tr>
                <th scope="row" class="text-center"><small><?php echo $value['codigo'] ?> </small></th>                
                <th><small><?php echo $value['descripcion'] ?> </small></th>               
                <th class="text-center"><small><?php echo $value['precioVenta'] ?> </small></th>
                <th class="text-center"><small><?php echo $value['cantidad'] ?> </small></th>                               
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>

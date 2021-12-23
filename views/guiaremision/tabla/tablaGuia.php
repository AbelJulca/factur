<div class="container">    
    <div class="row">       
        <div class="col-lg-12 col-12">
            <table class="table table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ITEM</th>
                        <th scope="col">COD</th>
                        <th scope="col">PRODUCTO</th>
                        <th scope="col">UND</th>
                        <th scope="col">CANT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->carrito as $key => $value): ?>
                        <tr>
                            <th><?php echo $key+1; ?></th>
                            <th><?php echo $value['sku'] ?></th>
                            <th><?php echo $value['nombre_comercial'] ?></th>
                            <th><?php echo $value['idunidad'] ?></th>                   
                            <th><?php echo $value['cantidad'] ?></th>                           
                        </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>         
        </div>        
    </div>

</div>


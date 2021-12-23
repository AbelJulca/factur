   <div class="form-row">       
        <div class="col-md-12 col-12">
            <table class="table table-sm table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">COMPROBANTE</th>
                        <th scope="col">SERIE</th>
                        <th scope="col">CORRELATIVO</th> 
                        <th scope="col">ACCION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->Listar as $key => $value): ?>
                        <tr>
                            <th><small class="text-body font-weight-bold"><?php echo $value['comprobante'] ?> </small></th> 
                            <th><small class="text-body font-weight-bold"><?php echo $value['serie'] ?> </small></th>                            
                            <th><small class="text-body font-weight-bold"><?php echo $value['correlativo'] ?> </small></th>
                            <th>
                                <button type="button" class="btn btn-danger btn-xs" onclick="eliminarSerieCodido('<?= $value['codigo_detalle'] ?>','<?= $value['codigo_serie'] ?>')"><i class="fas fa-trash-alt"></i></button>
                            </th>                            
                        </tr>
                    <?php endforeach;?> 
                </tbody>   
            </table>         
        </div>        
    </div>

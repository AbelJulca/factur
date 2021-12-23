   <div class="form-row">       
        <div class="col-md-12 col-12">
            <table class="table table-sm table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ITEM</th>
                        <th scope="col">COD</th>                         
                        <th scope="col">CANT</th>                   
                        <th scope="col">UND</th>
                        <th scope="col">PRODUCTO</th>
                        <th scope="col">FECHA_V</th>
                        <th scope="col">VU</th>
                        <th scope="col">SUBT</th>
                        <th scope="col">ACCION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cont = 1;
                    foreach ($this->carrito as $key => $value):
                        ?>
                        <tr>
                            <th><small class="text-body"><?php echo $cont ?> </small></th>
                            <th><small class="text-body"><?php echo $value['sku'] ?> </small></th>                            
                            <th><small class="text-body"><?php echo $value['cantidad'] ?> </small></th>
                            <th><small class="text-body"><?php echo $value['idunidad'] ?> </small></th>                  
                            <th><small class="text-body"><?php echo $value['nombre_comercial'] ?> </small></th>
                            <th><input class="form-control form-control-sm" id="txtfechavenaux<?php echo $value['codigo'] ?>" type="date" value="<?php echo $value['fecha_vencimiento']?>"/></th>
                            <th><?php echo round($value['precio'], 2) ?></th>
                            <th><?php echo round($value['precio'] * $value['cantidad'], 2) ?></th>
                            <th>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-danger btn-xs" onclick="dellItemCarrito('<?= $value['codigo'] ?>')"><i class="fas fa-trash-alt"></i></button>
                                    <?php if($value['fecha_vencimiento'] == ''){ ?>
                                        <button type="button" class="btn btn-warning ml-1 btn-xs" onclick="editFechaCarrito('<?= $value['codigo'] ?>')"><i class="far fa-clock"></i></button>
                                    <?php }?>
                                </div>
                            </th>                            
                        </tr>
                        <?php
                        $cont = $cont + 1;
                    endforeach;
                    ?> 
                </tbody>   
                <?php
                echo "<tr><td colspan='8' align='right'>OP. GRAVADAS S/.</td><td><b>" .number_format($this->op_gravadas, 2, '.', ''). "</b></td></tr>";
                echo "<tr><td colspan='8' align='right'>IGV(18%) S/.</td><td><b>" .number_format($this->igv, 2, '.', ''). "</b></td></tr>";
                echo "<tr><td colspan='8' align='right'>I.C.B.P.E.R S/.</td><td><b>" .number_format($this->op_icbper, 2, '.', ''). "</b></td></tr>";
                echo "<tr><td colspan='8' align='right'>OP. EXONERADAS S/.</td><td><b>" .number_format($this->op_exoneradas, 2, '.', ''). "</b></td></tr>";
                echo "<tr><td colspan='8' align='right'>OP. INAFECTAS S/.</td><td><b>" .number_format($this->op_inafectas, 2, '.', '') . "</b></td></tr>";
                echo "<tr><td colspan='8' align='right'><b>TOTAL S/.</b></td><td><b>" .number_format($this->total, 2, '.', '') . "</b></td></tr>";
                ?>
            </table>         
        </div>        
    </div>

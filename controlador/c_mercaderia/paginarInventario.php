<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select cd.idp, cd.codproducto, cd.nombreproducto, cd.precio_venta, cd.entrada
                        FROM c_mercaderia cd
                                 WHERE cd.estado = 'A'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>

              <table id="example2" class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>PRECIO VENTA</th>
                    <th>STOCK DISPONIBLE</th>
                    <th>SELECCIONAR</th>
                </tr>
            </thead>
            
            <tbody style="background:lightgreen">
            <?php foreach($all as $registro2){ ?>
            
                <tr style="height:10px;">
                    <td><?php echo $registro2['codproducto'] ?></td>
                    <td><?php echo $registro2['nombreproducto'] ?></td>
                    <td><?php echo $registro2['precio_venta'] ?></td>
                    
                    <?php if ($registro2['entrada'] == 0) { ?>
                        <td >Sin stock</td>
                        <td></td>
                    <?php }else{ ?>
                    <td><?php echo $registro2['entrada'] ?></td>
                    <td><a href="javascript:seleccionar(<?php echo $registro2['idp'] ?>)">
                            <span class=""><i class="fa fa-check" ></i> Seleccionar </span></a></td>
                    <?php } ?>
                </tr>

                <?php } ?>  
                </tbody>                      
            </table>

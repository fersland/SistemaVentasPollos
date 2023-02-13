<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select C.nombre, P.nombreproveedor, m.codproducto, m.existencia, m.nombreproducto, m.precio_venta, m.precio_compra, 
                                                    m.existe, m.entrada, m.salida, m.idp, m.ruta, m.pre_gr, m.pre_kg, m.pre_lt, m.pre_lb,
                                                    m.kilo, m.libra, m.gramo, m.litro, m.ok, s.nombre as lasucursal, m.cajas, m.fechacompra, m.ncompra, m.ok
                                                    FROM c_mercaderia m

                                                        LEFT JOIN c_proveedor P ON .P.id_proveedor = m.id_proveedor
                                                        LEFT JOIN c_categoria C ON C.nombre = m.categoria
                                                        INNER JOIN c_sucursal s ON m.sucursal = s.id_sucursal
                                                                    where m.estado = 'A' AND m.menudo is NULL ");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover table-responsive "  style="width:100%">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <td></td>
                    <th>COMPRA</th>
                    <th>SUCURSAL</th>
                    <th>FECHA_COMPRA</th>
                    <th>PROVEEDOR</th>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>CATEGORIA</th>
                    <th>C*_UNIDAD</th>
                    <th>C*_KILOS</th>
                    <th>C*_CAJA</th>
                    
                    
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ 
                
                if ($registro2['ok'] == 2) { 
                    $ok = 'coral';
                }else if($registro2['ok'] == 1){
                    $ok = 'lightgreen';
                }?>            
                <tr style="background: <?php echo $ok ?>;">
                    <td data-toggle="modal" data-target="#modal-info">
                    <a class="btn btn-warning" href="javascript:showInfoProducts(<?php echo $registro2['idp']; ?>)">
                    <i class="fa fa-eye"></i> </a></td>
                    
                    <td><a href="../app/mercaderia/confirmar.php?cid=<?php echo $registro2['idp'] ?>">
                        <span class="btn btn-info btn-sm"><i class="fa fa-edit"></i>  </span></a></td>
                        
                    <td><a href="../app/mercaderia/confirmardel.php?cid=<?php echo $registro2['idp'] ?>">
                        <span class="btn btn-danger btn-sm"><i class="fa fa-remove"></i>  </span></a></td>                    
                    
                    <!--<td><img src="../img/<?php //echo $registro2['ruta'] ?>" width="35" /></td>-->
                    <!--<td><img src="../../datos/clases/barcode/barcode.php<?php //echo $registro2['cbarras'] ?>" width="100" /></td>-->
                    <td><?php echo $registro2['ncompra'] ?></td>
                    <td><?php echo $registro2['lasucursal'] ?></td>
                    <td><?php echo $registro2['fechacompra'] ?></td>
                    <td><?php echo $registro2['nombreproveedor'] ?></td>
                    <td><?php echo $registro2['codproducto'] ?></td>
                    <td><?php echo $registro2['nombreproducto'] ?></td>
                    <td><?php echo $registro2['nombre'] ?></td>
                    <!--<td><?php //echo $registro2['precio_venta'] ?></td>
                    <td><?php //echo $registro2['pre_gr'] ?></td>
                    <td><?php //echo $registro2['pre_kg'] ?></td>
                    <td><?php //echo $registro2['pre_lt'] ?></td>
                    <td><?php //echo $registro2['pre_lb'] ?></td>-->
                    
                        <td><?php echo $registro2['existencia'] ?></span></td>
                        <td><?php echo $registro2['kilo'] ?></span></td>
                        <td><?php echo $registro2['cajas'] ?></span></td>                    
                    
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
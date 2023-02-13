<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select C.nombre, P.nombreproveedor, m.codproducto, m.existencia, m.nombreproducto, m.precio_venta, m.precio_compra, 
                                                    m.existe, m.entrada, m.salida, m.idp, m.ruta, m.pre_gr, m.pre_kg, m.pre_lt, m.pre_lb,
                                                    m.kilo, m.libra, m.gramo, m.litro, m.ok
                                                    FROM c_mercaderia m

                                                        INNER JOIN c_proveedor P ON .P.id_proveedor = m.id_proveedor
                                                        INNER JOIN c_categoria C ON C.id_categoria = m.categoria
                                                                    where m.estado = 'A'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover table-responsive "  style="width:100%">
                <thead>
                <tr>
                    <td></td>
                    <!--<th>FOTO</th>-->
                    <th>PROVEEDOR</th>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>CATEGORIA</th>
                    <th>C*_UNIDAD</th>
                    <th>C*_KILOS</th>
                    
                    
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){?>            
                <tr>
                    

                    <td><a href="../app/convenios/newconvenios.php?cid=<?php echo $registro2['idp'] ?>&codigo=<?php echo $registro2['codproducto']; ?>">
                        <span class="btn btn-success btn-sm"><i class="fa fa-plus"></i>  </span></a></td>
                        
                    
                    
                    
                    <!--<td><img src="../img/<?php //echo $registro2['ruta'] ?>" width="35" /></td>-->
                    <!--<td><img src="../../datos/clases/barcode/barcode.php<?php //echo $registro2['cbarras'] ?>" width="100" /></td>-->
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
                    
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
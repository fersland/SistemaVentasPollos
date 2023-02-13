<?php
    require_once ("../../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select e.id, concat(c.nombres) as elcliente, m.nombreproducto, e.pnuevo, e.pkilo, e.plibra, e.pgramo, e.plitro, e.fecha_registro, e.cod 
                                                from c_convenios e INNER JOIN c_clientes c ON e.cliente = c.cedula
                                                left join c_mercaderia m ON e.producto = m.idp 
                                                where e.id_estado = 1 ORDER BY e.id DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
<div class="box">
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>PRODUCTO</th>
                    <th>CLIENTE</th>
                    <th>PRECIO UNIT</th>
                    <th>PRECIO KG</th>
                    <th>CODIGO</th>                    
                    <th>FECHA</th>
                    <th>EDITAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach( (array) $all as $registro2){ ?>
                <tr >
                    <td><?php echo @$registro2['nombreproducto'] ?></td>
                    <td><?php echo @$registro2['elcliente'] ?></td>
                    <td><?php echo @$registro2['pnuevo'] ?></td>
                    <td><?php echo @$registro2['pkilo'] ?></td>
                    <td><?php echo @$registro2['cod'] ?></td>                    
                    <td><?php echo @$registro2['fecha_registro'] ?></td>
                    <td><a class="<?php echo @$ee ?>" href="../../app/mercaderia/convenios_act.php?cid=<?php echo @$registro2['id'] ?> " >
                        <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                    <td><a class="<?php echo @$dd ?>" href="../../app/mercaderia/convenios_eli.php?cid=<?php echo @$registro2['id'] ?> " >
                        <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>    
                </tr>
                <?php } ?>  
            </tbody>                      
        </table>
    </div>
</div>
$(document).ready(pagination(1));
$(function(){
	$('#bs-prod').on('keyup',function(){
		var dato = $('#bs-prod').val();
		var url = '../../../controlador/c_activos/busca_activos.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'dato='+dato,
		success: function(datos){
			$('#agrega-registros').html(datos);
		}
	});
	return false;
	});
});

function editarProducto(id){
	$('#formulario')[0].reset();
	var url = '../../../controlador/c_activos/c_activos_show.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
				$('#reg').show();
				$('#edi').show();
				$('#pro').val('Edicion');
				$('#id-prod').val(id);
                $('#_proveedor').val(datos[0]);
                $('#_fecha').val(datos[1]);
                $('#_nfactura').val(datos[2]);
                $('#_descripcion').val(datos[3]);
                $('#_valor').val(datos[4]);
                $('#_estado_f').val(datos[5]);
                $('#_ubicacion').val(datos[6]);
                $('#_codigo_e').val(datos[7]);
                $('#_persona').val(datos[8]);                
                $('#_stock').val(datos[9]);
                $('#_obs').val(datos[10]);
                
			return false;
		}
	});
	return false;
}

function pagination(partida){
	var url = '../../../controlador/c_activos/paginarActivos.php';
	$.ajax({
		type:'POST',
		url:url,
		data:'partida='+partida,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
}
$(document).ready(pagination(1));
$(function(){
	$('#bs-prod').on('keyup',function(){
		var dato = $('#bs-prod').val();
		var url = '../../../../controlador/c_orden_trabajo/buscaOrdenCodigo.php';
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
	var url = '../../../controlador/c_lineas/b_mercaderia_ventasantiguas_show.php';
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
                $('#code').val(datos[0]);
                $('#_present').val(datos[1]);
                $('#_name').val(datos[2]);
                $('#_litros').val(datos[3]);
                $('#_price').val(datos[4]);
                $('#_stock').val(datos[5]);
                $('#_bodega').val(datos[6]);
                /*$('#cedula').val(datos[1]);
                $('#nombres').val(datos[2]);
				/*$('#registra-empleado').modal({
					show:true,
					backdrop:'static'
				});*/
			return false;
		}
	});
	return false;
}

function pagination(partida){
	var url = '../../../../controlador/c_orden_trabajo/paginar_orden_codigo.php';
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
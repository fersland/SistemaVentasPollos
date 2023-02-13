$(document).ready(pagination(1));
$(function(){
	$('#bs-prod').on('keyup',function(){
		var dato = $('#bs-prod').val();
		var url = '../../../../controlador/c_lineas/busca_venta_param.php';
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
	var url = '../../../../controlador/c_lineas/b_mercaderia_param.php';
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
                $('#_idp').val(datos[0]);
                $('#auto').val(datos[1]);
                $('#_price').val(datos[2]);
                $('#_stock').val(datos[3]);
                $('#_bodega').val(datos[4]);
			return false;
		}
	});
	return false; 
}

function pagination(partida){
	var url = '../../../../controlador/c_lineas/paginar_venta_param.php';
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
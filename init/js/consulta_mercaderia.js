$(document).ready(pagination(1));
$(function(){
	$('#bs-prod').on('keyup',function(){
		var dato = $('#bs-prod').val();
		var url = '../../../controlador/c_lineas/busca_lineas.php';
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
	var url = '../../../controlador/c_lineas/b_mercaderia_code_show.php';
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
                
                $('#_id_prov').val(datos[0]);
                $('#_ncompra').val(datos[1]);
                $('#_codigo').val(datos[2]);
                $('#_categoria').val(datos[3]);
                $('#_bodega').val(datos[4]);
                $('#_percha').val(datos[5]);
                $('#_nombre').val(datos[6]);
                
                
                $('#_present').val(datos[7]);
                $('#_litros').val(datos[8]);
                $('#_filtro').val(datos[9]);
                $('#_aceite').val(datos[10]);                
                $('#_stock').val(datos[11]);
                $('#_viscosidad').val(datos[12]);
                $('#_marca').val(datos[13]);
                
                $('#_medida').val(datos[14]);
                $('#_precio_compra').val(datos[15]);
                $('#_obs').val(datos[16]);
                $('#_precio').val(datos[17]);
                
			return false;
		}
	});
	return false;
}

function pagination(partida){
	var url = '../../../controlador/c_lineas/paginarLineas.php';
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
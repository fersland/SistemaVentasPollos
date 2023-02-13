$(document).ready(pagination(1));
$(function(){
	$('#bs-prod').on('keyup',function(){
		var dato = $('#bs-prod').val();
		var url = '../../../controlador/c_clientes/busca_clientes.php';
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
	var url = '../../../controlador/c_clientes/b_cliente_show.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
				$('#pro').val('Edicion');
				$('#id-prod').val(id);
				$('#_cedula').val(datos[0]);
                $('#_nombres').val(datos[1]);
                $('#_correo').val(datos[2]);
                $('#_celular').val(datos[3]);
                $('#_direccion').val(datos[4]);
                $('#_placa').val(datos[5]);
			return false;
		}
	});
	return false;
}

function pagination(partida){
	var url = '../../../controlador/c_clientes/paginarClientes.php';
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
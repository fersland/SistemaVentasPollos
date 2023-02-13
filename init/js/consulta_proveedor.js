$(document);
function editarProducto(id){    
	$('#formulario')[0].reset();
	var url = '../../../controlador/c_proveedor/b_proveedor_show.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
				$('#pro').val('Edicion');
				$('#id-prod').val(id);
				$('#ruc').val(datos[0]);
                $('#nombres').val(datos[1]);
                $('#direccion').val(datos[2]);
                $('#telefono').val(datos[3]);
                $('#celular').val(datos[4]);
                $('#correo').val(datos[5]);
                $('#observacion').val(datos[6]);
			return false;
		}
	});
	return false;
}
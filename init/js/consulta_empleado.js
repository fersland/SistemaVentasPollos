$(document).ready(pagination(1));
$(function(){
	$('#bs-prod').on('keyup',function(){
		var dato = $('#bs-prod').val();
		var url = '../../../controlador/c_empleados/busca_empleados.php';
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
	var url = '../../../controlador/c_empleados/b_empleado_show.php';
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
				$('#acceso').val(datos[0]);
                $('#cedula').val(datos[1]);
                $('#nombres').val(datos[2]);
                $('#apellidos').val(datos[3]);
                $('#lugnac').val(datos[4]);
                $('#fecnac').val(datos[5]);
                $('#edad').val(datos[6]);
                $('#correo').val(datos[7]);
                $('#direccion').val(datos[8]);
                $('#telefono').val(datos[9]);
                $('#celular').val(datos[10]);
                $('#tiposangre').val(datos[11]);
                $('#estciv').val(datos[12]);
                $('#observacion').val(datos[13]);
			return false;
		}
	});
	return false;
}

function pagination(partida){
	var url = '../../../controlador/c_empleados/paginarEmpleados.php';
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
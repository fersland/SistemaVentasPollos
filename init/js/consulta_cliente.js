//$(document).ready(pagination(1));
$(function(){
	$('#bs-cl').on('keyup',function(){
		var dato = $('#bs-cl').val();
		var url = '../../../controlador/c_clientes/busca_cliente_venta.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'dato='+dato,
		success: function(datos){
			$('#agrega-clientes').html(datos);
		}
	});
	return false;
	});
});


function param(id){
	//$('#formulario')[0].reset();
	var url = '../../../controlador/c_clientes/b_cliente_venta_show.php';
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
                $('#id_cl').val(datos[0]);
                $('#thecedula').val(datos[1]);
                $('#thecedula2').val(datos[1]);
                $('#nomcliente').val(datos[2]);
                $('#nomcliente2').val(datos[2]);
			//return false;
		}
	});
	return false;
}
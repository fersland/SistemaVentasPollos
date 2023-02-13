$(document).ready(pagination(1));
$(function(){
	$('#desde').on('change', function(){
		var desde = $('#desde').val();
		var hasta = $('#hasta').val();
		var cliente = $('#cliente').val();
		var url = '../../../controlador/c_seguridad/asignar_buscar.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'desde='+desde+'&hasta='+hasta+'&cliente='+cliente,
			success: function(datos){
				$('#args').html(datos);
			}
		});

		return false;
		});

	$('#hasta').on('change', function(){
		var desde = $('#desde').val();
		var hasta = $('#hasta').val();
		var cliente = $('#cliente').val();
		var url = '../../../controlador/c_seguridad/asignar_buscar.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'desde='+desde+'&hasta='+hasta+'&cliente='+cliente,
			success: function(datos){
				$('#args').html(datos);
			}
		});
		return false;
	});
});

function pagination(partida){
	var url = '../../../controlador/c_seguridad/asignar_paginar.php';
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
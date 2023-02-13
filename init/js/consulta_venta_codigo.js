//$(document).ready(pagination(1));
$(function(){
	$('#bs-prod').on('keyup',function(){
		var dato = $('#bs-prod').val();
		var url = '../../controlador/c_lineas/busca_ventascodigo.php';
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

/************************************
    VENTAS / ORD / BUSCAR PRODUCTO
*************************************/
function editarProducto(id){
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
				$("#_price_kg").prop("readonly", false);

if ($("#positivo").val() == 2) {
	$("#_peso_menudo").prop("readonly", false);
	$("#_peso_pata").prop("readonly", false);
	$("#_peso_higado").prop("readonly", false);
}else if($("#positivo").val() == 1){
	$("#_peso_menudo").prop("readonly", true);
	$("#_peso_pata").prop("readonly", true);
	$("#_peso_higado").prop("readonly", true);
}
                $('#code').val(datos[0]);
                $('#_price').val(datos[1]);
                $('#_stock').val(datos[2]);
                $('#_desc').val(datos[3]);
                
                $('#_gramo').val(datos[4]);
                $('#_litro').val(datos[5]);
                $('#_libra').val(datos[6]);
                $('#_kilo').val(datos[7]);
                
                $('#_price_lt').val(datos[8]);
                $('#_price_kg').val(datos[9]);
                $('#_price_lb').val(datos[10]);
                $('#_price_gr').val(datos[11]);
                $('#sucursal').val(datos[12]);
                $('#categoria').val(datos[13]);

                $('#_merma_compra').val(datos[14]);
                $('#_ncompra').val(datos[15]);
                $('#cajasdisp').val(datos[16]);
                $('#positivo').val(datos[17]);
			return false;
		}
	});
	return false;
}

/************************************
    VENTAS / ORD / BUSCAR PRODUCTO PARA CONVENIOSSSSSSSSSSSSSSSSSSSS
*************************************/
function convenios(id){
	var url = '../../../controlador/c_lineas/b_mercaderia_convenios.php';
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
                $('#code').val(datos[1]);
                $('#_desc').val(datos[2]);
                $('#_stock').val(datos[3]);
                $('#_price').val(datos[4]);
                $('#_price_kg').val(datos[5]);
                $('#_kilo').val(datos[6]);
                $('#cajasdisp').val(datos[7]);
		$('#categoria').val(datos[8]);
		$('#thecedula').val(datos[9]);
		$('#thecedula2').val(datos[9]);
		$('#nomcliente').val(datos[10]);
		$('#nomcliente2').val(datos[10]);
		$("#_price_kg").prop("readonly", true);
		
                
                
			return false;
		}
	});
	return false;
}
function categorias(id){
	var url = '../../controlador/c_lineas/b_categorias_show.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
                $('#_cate').val(datos[0]);
                $('#_desc').val(datos[1]);
			return false;
		}
	});
	return false;
}

function mercaderia(id){
	var url = '../../controlador/c_lineas/codigo_mercaderia.php';
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
                $('#_price').val(datos[1]);
                $('#_cate').val(datos[2]);
                $('#_desc').val(datos[3]);
                $('#_pricev').val(datos[4]);
			return false;
		}
	});
	return false;
}

function mercaderiargs(id){
	var url = '../../controlador/c_lineas/codigo_mercaderia_requiem.php';
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
                $('#_nombre').val(datos[1]);
			return false;
		}
	});
	return false;
}
/******************************************
 CONSULTA PARA INVENTARIO PAGINA PRINCIPAL
 ******************************************/
function seleccionar(id){
	var url = '../../controlador/c_lineas/rellenarProducto.php';
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
                $('#_codigo').val(datos[0]);
                $('#_nombre').val(datos[1]);
                $('#_stock').val(datos[2]);
			return false;
		}
	});
	return false;
}
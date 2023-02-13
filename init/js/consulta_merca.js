function showInfoProducts(id){
    
	$('#formulario')[0].reset();
	var url = '../../controlador/c_mercaderia/b_merca_show.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
				$('#pro').val('Edicion');
				$('#edi').hide();
				$('#reg').show();
				$('#id-prod').val(id);
				$('#_cod').val(datos[0]);
                $('#_pve').val(datos[1]);
                $('#_exi').val(datos[2]);
                $('#_nom').val(datos[3]);
                $('#_gra').val(datos[4]);
                $('#_lit').val(datos[5]);
                $('#_lib').val(datos[6]);
                $('#_kil').val(datos[7]);
                $('#_plt').val(datos[8]);
                $('#_pkg').val(datos[9]);
                $('#_plb').val(datos[10]);
                $('#_pgr').val(datos[11]);
                $('#_nca').val(datos[12]);
                $('#_prov').val(datos[13]);
			return false;
		}
	});
	return false;
}
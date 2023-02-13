$(document).ready(function(){
    console.log('Jquery funcionando');
    
    $('#ruc').keyup(function(e){
        let ruc = $('#ruc').val();
        console.log(ruc);
        $.ajax({
            url: '../../../controlador/c_proveedor/reg_proveedor.php',
            type: 'POST',
            data: {ruc:ruc},
            success: function(response) {
                console.log(response);
            }
        })
    })
    
        $('#frm').submit(function(e){
            const postData = {
                name: $('#ruc').val()    
            };
            
        $.post('../../../controlador/c_proveedor/reg_proveedor.php', postData, function (response){
            console.log(response);
            $('#frm').trigger('reset');
        })
        e.preventDefault();        
    });
    
    $(document).on("ready", function(){
        listar();
        
        var listar = function(){
            var table = $("#results").DataTable({
                "ajax":{
                    "method":"POST",
                    "url": "../../../controlador/c_proveedor/paginarProveedores.php"
                },
                "columns":[
                    {"data":"ruc"}
                ]
            });
        }
    })
});
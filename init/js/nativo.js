$(function() {
    $('#selectpago').change(function(){
        $('.vehicle').hide();
        $('#' + $(this).val()).show();
    });
});

    function muestra_oculta(id){
        if (document.getElementById){ //se obtiene el id
        var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
        el.style.display = (el.style.display == 'block') ? 'none' : 'block'; //damos un atributo display:none que oculta el div
        }
    }
        window.onload = function(){
        muestra_oculta('contenido');/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
    }


$(document).ready(function(){
  $("#flip").click(function(){
    $("#panel").slideToggle("slow");
  });
});


function Disabled(){
        document.getElementById('id_cl').value='';
        document.getElementById('cedula').value='';
        document.getElementById('cliente').value='';
    }

    function DisabledCheckbox(){
        document.getElementById("final").checked = false;
    }                                                                                                                 
    
/** SELECCIONAR TODO PARA RESPALDAR **/
 $(document).ready(function(){
    $('#all').on('click',function(){
        if(this.checked){
            $('.case1').each(function(){
                this.checked = true;
            });
        }else{
             $('.case1').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case1').on('click',function(){
        if($('.case1:checked').length == $('.case1').length){
            $('#all').prop('checked',true);
        }else{
            $('#all').prop('checked',false);
        }
    });
});


/** INICIO SEGURIDAD PERMISOS DE ROLES **/
 $(document).ready(function(){
    $('#todo1').on('click',function(){
        if(this.checked){
            $('.case1').each(function(){
                this.checked = true;
            });
        }else{
             $('.case1').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case1').on('click',function(){
        if($('.case1:checked').length == $('.case1').length){
            $('#todo1').prop('checked',true);
        }else{
            $('#todo1').prop('checked',false);
        }
    });
});

 // 2

  $(document).ready(function(){
    $('#todo2').on('click',function(){
        if(this.checked){
            $('.case2').each(function(){
                this.checked = true;
            });
        }else{
             $('.case2').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case2').on('click',function(){
        if($('.case2:checked').length == $('.case2').length){
            $('#todo2').prop('checked',true);
        }else{
            $('#todo2').prop('checked',false);
        }
    });
});

   // 3

  $(document).ready(function(){
    $('#todo3').on('click',function(){
        if(this.checked){
            $('.case3').each(function(){
                this.checked = true;
            });
        }else{
             $('.case3').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case3').on('click',function(){
        if($('.case3:checked').length == $('.case3').length){
            $('#todo3').prop('checked',true);
        }else{
            $('#todo3').prop('checked',false);
        }
    });
});

// 4

  $(document).ready(function(){
    $('#todo4').on('click',function(){
        if(this.checked){
            $('.case4').each(function(){
                this.checked = true;
            });
        }else{
             $('.case4').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case4').on('click',function(){
        if($('.case4:checked').length == $('.case4').length){
            $('#todo4').prop('checked',true);
        }else{
            $('#todo4').prop('checked',false);
        }
    });
});

// 5

  $(document).ready(function(){
    $('#todo5').on('click',function(){
        if(this.checked){
            $('.case5').each(function(){
                this.checked = true;
            });
        }else{
             $('.case5').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case5').on('click',function(){
        if($('.case5:checked').length == $('.case5').length){
            $('#todo5').prop('checked',true);
        }else{
            $('#todo5').prop('checked',false);
        }
    });
    
    
});

// 6

  $(document).ready(function(){
    $('#todo6').on('click',function(){
        if(this.checked){
            $('.case6').each(function(){
                this.checked = true;
            });
        }else{
             $('.case6').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case6').on('click',function(){
        if($('.case6:checked').length == $('.case6').length){
            $('#todo6').prop('checked',true);
        }else{
            $('#todo6').prop('checked',false);
        }
    });
    
    
});

// 7 VEHICULOS

  $(document).ready(function(){
    $('#todo7').on('click',function(){
        if(this.checked){
            $('.case7').each(function(){
                this.checked = true;
            });
        }else{
             $('.case7').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case7').on('click',function(){
        if($('.case7:checked').length == $('.case7').length){
            $('#todo7').prop('checked',true);
        }else{
            $('#todo7').prop('checked',false);
        }
    });
    
    
});


// 8 CONVENIOS

  $(document).ready(function(){
    $('#todo8').on('click',function(){
        if(this.checked){
            $('.case8').each(function(){
                this.checked = true;
            });
        }else{
             $('.case8').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case8').on('click',function(){
        if($('.case8:checked').length == $('.case8').length){
            $('#todo8').prop('checked',true);
        }else{
            $('#todo8').prop('checked',false);
        }
    });
    
    
});
/** FIN SEGURIDAD PERMISOS DE ROLES**/


  function soloNumeros(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
  }
  
  function caracteres(e) {
    tecla = (document.all) ? e.keyCode : e.which;
 if (tecla==8 || tecla==37 || tecla<=38 || tecla==39 || tecla<=40) return true;
    patron =/^[\u00F1A-Za-z _]*[\u00F1A-Za-z][\u00F1A-Za-z _]*$/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}
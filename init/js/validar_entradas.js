function validarRegistro(){
    var stock = document.querySelector("#_stock").value;
    var cant = document.querySelector("#_cant").value;

    if ( cant > stock ) {
            document.querySelector("label[for='cantidadLabel']").innerHTML+="<br>La cantidad no debe superar la existencia disponible.";
            return false;
        }
    }
    return true;
}
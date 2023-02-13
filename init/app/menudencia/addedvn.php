<?php

  

  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_usuario' AND a_modulo=2 AND a_item=34");

  $ver->execute();

  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);



  foreach ($fetch as $key => $value) {

    $save = $value['sav'];

    $edit = $value['edi'];

    $dele = $value['del'];

    $prin = $value['pri'];

  }

  if (@$save == 'A') {

    @$ss = '';

  }elseif (@$save == 'I'){

    @$ss = "disabled";

  }



  if (@$prin == 'A'){

    @$pp = '';

  }elseif (@$prin == 'I'){

    @$pp = 'disabled';

  }



  if (@$edit == 'A'){

    @$ee = '';

  }elseif (@$edit == 'I'){

    @$ee = 'disabled';

  }



  if (@$dele == 'A'){

    @$dd = '';

  }elseif (@$dele == 'I'){

    @$dd = 'disabled';

  }

  // SELECCIONE EL PROVEEDOR
  $yan = $db->prepare("SELECT * FROM c_proveedor WHERE estado = 'A'");
  $yan->execute();
  $allyan = $yan->fetchAll();

?>
<script type="text/javascript">
  function sumar()

{
	var ipata = parseFloat(document.form1.pata_.value);
	var imolleja = parseFloat(document.form1.molleja_.value);
	var ihigado = parseFloat(document.form1.higado_.value);

var numero1 = parseFloat(document.form1.five_pollo.value);
var total_menudo = numero1 * 15;

var rs = total_menudo * ipata;
var rs_molleja = total_menudo * imolleja;
var rs_higado = total_menudo * ihigado;

document.form1.five_pata.value= rs.toFixed(2);
document.form1.five_molleja.value= rs_molleja.toFixed(2);
document.form1.five_higado.value= rs_higado.toFixed(2);


document.form1.total_menudo.value= total_menudo.toFixed(2);


}


function sumarTwo()

{

	var ipata = parseFloat(document.form1.pata_.value);
	var imolleja = parseFloat(document.form1.molleja_.value);
	var ihigado = parseFloat(document.form1.higado_.value);

var numero1 = parseFloat(document.form1.six_pollo.value);
var total_menudo = numero1 * 12;

var rs = total_menudo * ipata;
var rs_molleja = total_menudo * imolleja;
var rs_higado = total_menudo * ihigado;

document.form1.six_pataTwo.value= rs.toFixed(2);
document.form1.six_mollejaTwo.value= rs_molleja.toFixed(2);
document.form1.six_menudenciaTwo.value= rs_higado.toFixed(2);


document.form1.total_menudo.value= total_menudo.toFixed(2);


}


function sumarThree()

{

	var ipata = parseFloat(document.form1.pata_.value);
	var imolleja = parseFloat(document.form1.molleja_.value);
	var ihigado = parseFloat(document.form1.higado_.value);

var numero1 = parseFloat(document.form1.unidad.value);

var rs = numero1 * ipata;
var rs_molleja = numero1 * imolleja;
var rs_higado = numero1 * ihigado;

document.form1.ud_pata.value= rs.toFixed(2);
document.form1.ud_molleja.value= rs_molleja.toFixed(2);
document.form1.ud_menudo.value= rs_higado.toFixed(2);


document.form1.total_menudo.value= total_menudo.toFixed(2);


}


// SUMA 1
function sumar1()

{

var numero1 = parseFloat(document.form1.five_pata.value);
var numero2 = parseFloat(document.form1.six_pataTwo.value);
var numero3 = parseFloat(document.form1.ud_pata.value);


var total1 = (numero1 + numero2 + numero3);

document.form1.suma1.value= total1.toFixed(2);

}

// SUMA 2
function sumar2()

{

var numero1 = parseFloat(document.form1.five_molleja.value);
var numero2 = parseFloat(document.form1.six_mollejaTwo.value);
var numero3 = parseFloat(document.form1.ud_molleja.value);


var total1 = (numero1 + numero2 + numero3);

document.form1.suma2.value= total1.toFixed(2);


}

// SUMA 3
function sumar3()

{

var numero1 = parseFloat(document.form1.five_higado.value);
var numero2 = parseFloat(document.form1.six_menudenciaTwo.value);
var numero3 = parseFloat(document.form1.ud_menudo.value);


var total1 = (numero1 + numero2 + numero3);

document.form1.suma3.value= total1.toFixed(2);


}

// SUMA KG
function sumarKG()

{

var numero1 = parseFloat(document.form1.suma1.value);
var numero2 = parseFloat(document.form1.suma2.value);
var numero3 = parseFloat(document.form1.suma3.value);


var total1 = (numero1 + numero2 + numero3);

document.form1.total_menudo.value= total1.toFixed(2);


}
</script>



<?php // llamada de tablero decimales

$call = $db->prepare("SELECT * FROM tablerovn");
$call->execute();
$icall = $call->fetch(); ?>
<div class="content-wrapper">

    <section class="content-header">

      <h1>ADMINISTRACI&Oacute;N / <b>MENUDENCIA DE VENTAS</b></h1>



    </section>

<section class="content" style="margin-top: -40px;">

<div class="row">

        <div class="col-md-12">

<?php if (isset($_POST['register'])) {

        require_once ("../../controlador/c_menudencia/reg_menudo_vn.php");

} ?>

       <div class="alert alert-dismissible fade show" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

       </div>            

    <div class="col-md-12">
        <div class="box box-success">
        <div class="box-body">
        <div class="col-md-12">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
            </div>

    <form id="form1" name="form1" method="post" class="form-horizontal" >
    	<input type="hidden" id="pata_" name="pata_" value="<?php echo $icall['pata']; ?>">
    	<input type="hidden" id="molleja_" name="molleja_" value="<?php echo $icall['molleja']; ?>">
    	<input type="hidden" id="higado_" name="higado_" value="<?php echo $icall['higado']; ?>">
        <div class="box-body">   

          <div class="form-group">
            <label class="col-md-2">Factura de Venta</label>
            <div class="col-md-3">
              <input type="text" name="factura" class="form-control" required placeholder="N° Factura" />    
            </div>
          </div>


          <!--<div class="form-group">
            <label class="col-md-2">Seleccione Proveedor</label>
            <div class="col-md-3">
              <select class="form-control" name="proveedor">
                <?php //foreach ($allyan as $key => $value): ?>
                  <option value="<?php //echo $value['id_proveedor']; ?>"><?php //echo strtoupper($value['nombreproveedor']); ?></option>
                <?php //endforeach ?>
              </select>
            </div>
          </div>-->
          
          
          <table class="table">
            <thead>
              <tr>
                <th>TIPO</th>
                <th>CANT. POLLO</th>
                <th>PATA</th>
                <th>MOLLEJA</th>
                <th>HIGADO</th>
              </tr>
            </thead>

            <TBODY>
              <tr>
                <td>105</td>
                <td style="background: lightgreen"><input type="" name="five_pollo" onkeyup="sumar();"></td>
                <td><input type="" name="five_pata" onkeyup="sumar1();"></td>
                <td><input type="" name="five_molleja"></td>
                <td><input type="" name="five_higado" onkeyup="sumar3();"></td>
              </tr>

              <tr>
                <td>106,107,108,109</td>
                <td style="background: lightgreen"><input type="" name="six_pollo" onkeyup="sumarTwo();"></td>
                <td><input type="" name="six_pataTwo" onkeyup="sumar1();"></td>
                <td><input type="" name="six_mollejaTwo" onkeyup="sumar2();" ></td>
                <td><input type="" name="six_menudenciaTwo" onkeyup="sumar3();"></td>
              </tr>

            </TBODY>

            <tfoot>
              <tr style="background: lightgreen">
                <td>Unidad</td>
                <td style="background: lightgreen"><input name="unidad" onkeyup="sumarThree();"></td>
                <td><input type="" name="ud_pata" onkeyup="sumar1();"></td>
                <td><input type="" name="ud_molleja" onkeyup="sumar2();"></td>
                <td><input type="" name="ud_menudo" onkeyup="sumar3();"></td>
              </tr>

              <tr style="background: green">
                <td colspan="2"><b>TOTAL MENUDO</b></td>
                <td><input name="suma1" onkeyup="sumar1(); sumarKG()" required></td>
                <td><input name="suma2" onkeyup="sumar2(); sumarKG()" required></td>
                <td><input name="suma3" onkeyup="sumar3(); sumarKG()" required></td>
              </tr>

              <tr>
                <td></td>
                <td></td>
                <td><input type="" name="total_menudo" required></td>
                <td></td>
                <td></td>
              </tr>
            </tfoot>

          </table>


       



        </div>



    <div class="box-footer">

        <a href="#tab_1-1" class="btn bg-navy" data-toggle="tab"><i class="fa fa-reply"></i> Volver</a>

        <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>

        <button type="submit" class="btn btn-success pull-right" value="Registrar" name="register" <?php //echo @$ss ?>><i class="fa fa-check-square-o"></i> Guardar Datos</button>

    </div>

    </form>

            </div>

            </div>

            </div><!-- /.tab-pane -->

                </div>

                

                

    <div class="col-md-12">

                    <div class="box box-warning">

                        <div class="box-body">

                            <?php require_once ('./'."../../controlador/c_menudencia/paginarMenudovn.php"); ?>

                        </div>

                    </div>

                </div>







            

          

        </div><!-- /.col -->

      </div><!-- /.row -->

  </section>

</div>
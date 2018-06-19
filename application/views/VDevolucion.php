<!DOCTYPE html>
<html>

<?php
  $this->load->view('librerias');
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
<script lenguage="javascript" type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script lenguage="javascript" type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">

<script>

  function borrarPrestamo(){
    var numInve; 
    var idPres; 
    $('.numInve').each(function(){
      numInve += ',';
      numInve += $(this).val();
      //console.log("Entró");
      //console.log(i);
    }); 

    $('.idPres').each(function(){
      idPres += ',';
      idPres += $(this).val();
      //console.log("Entró");
      //console.log(i);
    });

    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/prestamo2",
      type:"POST",
      data:{numInve:numInve, idPres:idPres},
      success: function(respuesta){
        var registros = JSON.parse(respuesta);
        //console.log('Registros: ');
        console.log(registros);
        alert('Devoluciones registradas con éxito');
      }      
    });
  }





$(document).ready(function(){
  //var idIncremento = $("#tablaresponsive tr").length -1 ;
  $("#nuevalinea").click(function(){

    $("table tbody").append('<tr><td><input style="color:black;" required type="number" id=numivS name="numivs[]" class="numInve" placeholder="Número Inventario"></td><td><input class="idPres" style="color:black;" required type="number" name="idsp[]" class="form-control" placeholder="Id Prestamo"></td><td><button type="button" class="botonRojo">Eliminar</button></td></tr>');
  });

  $("#tablaresponsive").on('click', '.botonRojo', function () {
    var numeroFilas = $("#tablaresponsive tr").length;
    if(numeroFilas>1){
      $(this).closest('tr').remove();
    }
  });
});
</script>


<div class="content">
  <div class="content__container">
    <ul class="content__container__list">
      <li class="content__container__list__item">Devoluciones !</li>
      <li class="content__container__list__item">Devoluciones !</li>
      <li class="content__container__list__item">Devoluciones !</li>
      <li class="content__container__list__item">Devoluciones !</li>
    </ul>
  </div>
</div>

<div class="panel-body">
  <form method= "post" action="generaPDFDevol" target="_blank">
    <td>
      <label style="margin-left: 470px; margin-top: 130px;" >Fecha: </label><input style="width: 150px; margin-left: 470px;" type="text" name="fecha" value="<?php echo $this->fecha; ?>" class="form-control">
    </td>

    <table align="center" style="margin-top: 50px; width: 400px;" class="table table-bordered" id="tablaresponsive">
      <thead> 
        <tr>
          <th>Ingrese número de Inventario: </th>
          <th>Id de prestamo: </th>
        </tr>
      </thead>

      <tbody>
      
      </tbody>
    </table>

    <button style="margin-left: 540px;" type="button" id="nuevalinea" class="botonAzul">Otra devolución</button>
    <input onclick="borrarPrestamo()" readonly="" class="botonVerde" value="Terminar" style="width: 100px;" >

      <input type="submit" value="GenerarPDF" class="botonNaranja" style="width: 200px; margin-left: 570px; margin-top: 25px;"></input>
    </form>


  <form method= "post" action="pPrincipal">
    <input type="submit" value="Regresar" class="botonNaranja" style="width: 200px; margin-left: 570px; margin-top: 25px;">
  </form>
</div>
</html>

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
  function obtenId(comp){
    let id  = comp.id;
    var NumPrestamo = document.getElementById('inve_'+id).value;
    console.log('Id del boton: ');
    console.log(id);
    obtenInfoLibro(NumPrestamo, id);
  }

  function obtenInfoLibro(NumInve, id){
    console.log('Num Inventario: ');
    console.log(NumInve);
    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/traeInfoInve",
      type:"POST",
      data:{NumInve:NumInve},
      success: function(respuesta){
        var registros = JSON.parse(respuesta);
        console.log('Registros: ');
        console.log(registros);
        if (registros == 0) {
          alert('No se encontro ese libro o ya está prestado');
        }else{
          html = "<td COLSPAN=6 ><table><td><label>Titulo Libro: </label><input style='width: 190px;' readonly  class='form-control' type='text' value='"+registros['titulo']+"' ></input></td><td><label style='margin-left:25px;' >Editorial: </label><input style='width: 90px; margin-left:25px;' readonly  class='form-control' type='text' value='"+registros['nom_editorial']+"' ></input></td><td><label style='margin-left:25px;'>Nom Autor: </label><input style='width: 150px;  margin-left:25px;' readonly  class='form-control' type='text' value='"+registros['nom_autor']+"' ></input></td><td><label style='margin-left:25px;'>Tema: </label><input style='width: 120px;  margin-left:25px;' readonly  class='form-control' type='text' value='"+registros['nom_tema']+"' ></input></td><td><label style='margin-left:25px;'>Clasificación: </label><input style='width: 50px;  margin-left:25px;' readonly  class='form-control' type='text' value='"+registros['nom_clasi']+"' ></input></td><td><label style='margin-left:25px;' >Biblioteca: </label><input style='width: 90px; margin-left:25px;' readonly  class='form-control' type='text' value='"+registros['nom_biblioteca']+"' ></input></td><td></td></table></td>";
        console.log(html);
        $("#muestraDatos"+id).html(html);
        }
      }      
    });

  }

$(document).ready(function(){
  var idIncremento = 0;
  var hoy = new Date();
  var dia = hoy.getDate();
  var mes = hoy.getMonth();
  var anio = hoy.getFullYear();
  hoy = anio+"-"+mes+"-"+dia;
  $("#nuevalinea").click(function(){
    idIncremento = idIncremento + 1;

    $("table").append('<tr><td><input required type="number" name="Ninvens[]" class="form-control" placeholder="Num. inventario" id=inve_'+idIncremento+'></td><td><input readonly type="number" name="NumPrestamo[]" class="form-control" placeholder='+idIncremento+'></td><td><input class="form-control" placeholder='+hoy+' value='+hoy+' name=fechaPres[] ></td><td><input type="date" class="form-control" name=fechaDev[] required ></td><td><button type="button" class="botonNaranja" id='+idIncremento+' onclick="obtenId(this)" >Info.</button></td><td><button type="button" class="botonRojo">Eliminar</button></td></tr><tr id=muestraDatos'+idIncremento+' ></tr><tr><td COLSPAN=6 ></td></tr>');
  });

  $("#tablaresponsive").on('click', '.botonRojo', function () {
    var numeroFilas = $("#tablaresponsive tr").length;
    if(numeroFilas>1){
      $(this).closest('tr').remove();
      idIncremento = idIncremento - 1;
    }
  });
});
</script>


<div class="content">
  <div class="content__container">
    <ul class="content__container__list">
      <li class="content__container__list__item">! Prestamo !  </li>
      <li class="content__container__list__item">! Prestamo !  </li>
      <li class="content__container__list__item">! Prestamo !  </li>
      <li class="content__container__list__item">! Prestamo !  </li>
    </ul>
  </div>
</div>

<div class="panel-body">
<form action="agregaPrestamo" method= "post" target="_blank">
<table align="center" style="margin-top: 50px; width: 900px;" class="table table-bordered" id="tablaresponsive">
  <select  required class="form-control" name="usr" style="margin-top: 150px; width: 200px; margin-left: 158px;">
    <option>Selecciona el usuario ... </option>
    <?php
    for ($i=0; $i < count($this->usrs); $i++) {?>
      <option><?php echo $this->usrs[$i]['nom_usuario'] ?></option>
    <?php } ?>
    ?>
  </select>

  <thead> 
    <tr>
      <th>Número de Inventario:</th>
      <th>Número de Prestamo.</th>
      <th>Fecha de Prestamo.</th>
      <th>Fecha de Devolución.</th>
    </tr>
  </thead>

  <tbody>

  </tbody>
</table>

<button style="margin-left: 460px;" type="button" id="nuevalinea" class="botonAzul">Agregar Prestamo</button>
<input type="submit" name="guardar" class="botonVerde" value="Terminar">
</form>

<form method= "post" action="pPrincipal">
  <input type="submit" value="Regresar" class="botonNaranja" style="width: 200px; margin-left: 500px; margin-top: 25px;"></input>
</form>
</div>
</html>

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
$(document).ready(function(){
  //var idIncremento = $("#tablaresponsive tr").length -1 ;
  var idIncremento = '<?php echo($this->lastIdAutor);?>';
  idIncremento = parseInt(idIncremento);
  $("#nuevalinea").click(function(){
    idIncremento = idIncremento + 1;

    $("table tbody").append('<tr><td><input required type="text" name="nom[]" class="form-control" placeholder="Nombre nueva editorial"></td><td><input readonly type="text" name="id[]" value='+idIncremento+' class="form-control"></td><td><button type="button" class="botonRojo">Eliminar</button></td></tr>');
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
      <li class="content__container__list__item">Editoriales !</li>
      <li class="content__container__list__item">Agregar !</li>
      <li class="content__container__list__item">Modificar !</li>
      <li class="content__container__list__item">Eliminar !</li>
    </ul>
  </div>
</div>

<div class="panel-body">
<form action="fdoAutor" method= "post">
<table align="center" style="margin-top: 150px; width: 400px;" class="table table-bordered" id="tablaresponsive">
  <thead> 
    <tr>
      <th>Nombre Autor</th>
      
    </tr>
  </thead>

  <tbody>
    <?php
        for ($i=0; $i < count($this->autoresOrig); $i++) {
          if($this->autoresOrig[$i]['vigencia'] == 1){?>
        <tr>
         <td><input required type="text" value="<?php echo $this->autoresOrig[$i]['nom_autor'];?>" name="nom[]" class="form-control" ></td>
         <td><input readonly type="text" value="<?php echo $this->autoresOrig[$i]['id_autor'];?>" name="id[]" class="form-control" style="display:none"></td>
         <td><button type="button" class="botonRojo">Eliminar</button></td>
        </tr>
      <?php }} ?>
  </tbody>
</table>

<button style="margin-left: 470px;" type="button" id="nuevalinea" class="botonAzul">Agregar Autor</button>
<input type="submit" name="guardar" class="botonVerde" value="Guardar Cambios">
</form>

<form method= "post" action="fVCapturaLibros">
  <input type="submit" value="Regresar" class="botonNaranja" style="width: 200px; margin-left: 540px; margin-top: 25px;"></input>
</form>
</div>
</html>

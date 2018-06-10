<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="http://getbootstrap.com/docs-assets/ico/favicon.png">
<?php
	$this->load->view('librerias');
?>
<title>Reportes</title>
<script lenguage="javascript" type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
<script type="text/javascript" src="/final/js/jquery-3.3.1.min.js"></script>

<script  lenguage="javascript" type="text/javascript">
  $(document).ready(function(){
    $(".contenido").hide();
    $("#select").change(function(){
      $(".contenido").hide();
      $("#div_" + $(this).val()).show();
    });
  });
</script>

<script type="text/javascript">
  function repo1(){
    var tituloLibro = document.getElementById('tituloLibro').value;
    var nomBiblio = document.getElementById('nomBiblio').value;
    console.log('Ttulo del libro: ');
    console.log(tituloLibro);
    console.log('Nom Biblio: ');
    console.log(nomBiblio);

    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/generaRepo1",
      type:"POST",
      data:{tituloLibro:tituloLibro, nomBiblio:nomBiblio},
      success: function(respuesta){
        //console.log(respuesta);
        var registros = JSON.parse(respuesta);
        console.log(registros);
        //registros = eval(respuesta);

        if(registros!=''){

          if (registros['indicador'] == 0) {
            alert('Selecciona algún filtro');
          }

          if(registros['indicador'] == 1){
            html = "<table><td><input readonly value='"+registros[0]["titulo"]+"' class='form-control' type='text' name='titulo' id='titulo' style='width: 260px; margin-left: 420px; margin-bottom: 30px;'></td><td></input><input readonly value='"+registros[0]["autores"]+"' class='form-control' type='text' name='autores' id='autores' style='width: 480px; margin-bottom: 30px; margin-left: 50px;'></td></table>";

            html += "<table style='width: 300px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";

            html +="<tr><th>Biblioteca</th><th>Unidades disponibles</th></th>";

            //html += "</thead><tbody>";
            for (var i=0; i<1; i++){
              for (var j=0; j<(registros[i]['bibliotecas']).length; j++){
                html+="<tr><td>"+registros[i]['bibliotecas'][j]['id_biblioteca']+"</td><td align='center'>"+registros[i]['bibliotecas'][j]['noLibros']+"</td> ";
              }
            }
            html+="<tr><th>Total</th><th align='center'>"+registros[0]['total']+"</th>";
          }

          if (registros['indicador'] == 2) {
              html = "<table><td><input readonly value='"+registros["biblioteca"]+"' class='form-control' type='text' name='titulo' id='titulo' style='width: 260px; margin-left: 420px; margin-bottom: 30px;'></td><td></input><td></table>";

              html += "<table style='width: 500px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";

              html +="<tr><th>Libro</th><th>Autor(es)</th><th>Unidades Disponibles</th></th>";

              for (var i=0; i<registros['libros'].length; i++){
                html+="<tr><td>"+registros['libros'][i]['titulo']+"</td><td align='center'>"+registros['libros'][i]['autores']+"</td><td>"+registros['libros'][i]['cantidad']+"</td> ";
              }

              html+="<tr><th>Total</th><th></th><th align='center'>"+registros['totalGlobal']+"</th>";
          }

          if (registros['indicador'] == 3) {
            html = "<table><td><input readonly value='"+registros["nomLibro"]+"' class='form-control' type='text' name='titulo' id='titulo' style='width: 260px; margin-left: 220px; margin-bottom: 30px;'></td><td></input><input readonly value='"+registros["autores"]+"' class='form-control' type='text' name='autores' id='autores' style='width: 480px; margin-bottom: 30px; margin-left: 50px;'></td><td>Total: <input readonly value='"+registros["cantidad"]+"' class='form-control' type='text' name='titulo' id='titulo' style='width: 40px; margin-left: 20px; margin-bottom: 30px;'></td></table>";
          }
        }
        $("#muestraDatos").html(html);
      }      


    });
  }
</script>

</head>

<body>
<div class="content">
  <div class="content__container">
    <ul class="content__container__list">
      <li class="content__container__list__item">Reportes </li>
      <li class="content__container__list__item">Titulos </li>
      <li class="content__container__list__item">Bibliotecas </li>
      <li class="content__container__list__item">Usuarios </li>
    </ul>
  </div>
</div>

<table align="center"  style="margin-top: 200px;">
  <td align="center">
    <select class="form-control" name="select" id="select">
      <option></option>
      <option value="1">Titulo libro, Autor(es), Biblioteca, Total</option>
      <option value="2">Titulo libo, Biblioteca, Total de prestamos</option>
      <option value="3">Bivlioteca, Titulo libro, Total de prestamos</option>
      <option value="4">Usuario, Total de prestamos</option>
      <option value="5">Usuario, Titulo libro, Biblioteca, No. ejemplar</option>
      <option value="6">Biblioteca, Mes, Total de prestamos</option>
    </select>
  </td>
</table>



  <div id="div_1" class="contenido" class="container">
    <form method="post" action="generaPDFRepo1">
      <table style="margin-top: 30px; margin-left: 415px;" >
        <td>
          <select class="form-control" name="tituloLibro" id="tituloLibro" style="width: 200px;  margin-bottom: 50px; margin-right: 20px; margin-left: 54px;">
          <option value="vacio">Elige Titulo ... </option>
          <?php
          for ($i=0; $i < count($this->titulos); $i++) {?>
            <option><?php echo $this->titulos[$i]['titulo'] ?></option>
          <?php } ?>
          </select>
        </td>

        <td>
          <select class="form-control" name="nomBiblio" id="nomBiblio" style="width: 200px; margin-bottom: 50px;">
            <option value="vacio">Elige Biblioteca ... </option>
            <?php
            for ($i=0; $i < count($this->biblios); $i++) {?>
              <option><?php echo $this->biblios[$i]['nom_biblioteca'] ?></option>
            <?php } ?>
          </select>
        </td>
      </table>

      <div id="muestraDatos">
        <!-- Este es el div en que se desplegara la consulta-->
      </div>

      <table style="margin-top: 30px; margin-left: 415px;" >
        <td>
          <input type="submit" value="GenerarPDF" class="botonAzul" style="width: 200px; margin-left: 70px; margin-top: 10px;"></input> 
    </form>
        </td>
        <td>
          <input value="Consultar" class="botonVerde" type="button" style="width: 200px; margin-left: 10px; margin-top: 10px;"  onclick="repo1()"></input> 
        </td>

      </table>
  </div>
<form method="post" action="pPrincipal">
      <input type="submit" value="Regresar" class="botonNaranja" style="width: 200px; margin-left: 585px; margin-top: 50px;"></input> 
</form>
</body>
</html>
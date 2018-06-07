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
<link href="Starter%20Template%20for%20Bootstrap_files/bootstrap.css" rel="stylesheet">
<link href="Starter%20Template%20for%20Bootstrap_files/starter-template.css" rel="stylesheet">
<script src="Starter%20Template%20for%20Bootstrap_files/jquery-1.js"></script>
<script src="Starter%20Template%20for%20Bootstrap_files/bootstrap.js"></script>
<link href="Starter%20Template%20for%20Bootstrap_files/bootstrap.css" rel="stylesheet">
<link href="Starter%20Template%20for%20Bootstrap_files/starter-template.css" rel="stylesheet">
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
    $.ajax({
        url:"http://localhost/final/index.php/ControladorPrincipal/generaRepo1",
        type:"POST",
        data:{tituloLibro:tituloLibro, nomBiblio:nomBiblio},
        success: function(respuesta){
             registros = eval(respuesta);
            //console.log(variable[0]['titulo']); aqui se obtiene el nombre
            //console.log(variable[0]['bibliotecas'][0]); accede al un dato de un biblioteca
            //console.log(variable[0]['bibliotecas'][0]['id_biblioteca']); accede al nombre de una biblioteca 
            //console.log(variable[0]['bibliotecas'][0]['noLibros']); accede al numero de libros que tiene una biblioteca 
            //console.log(registros[1]['bibliotecas'].length);
            //console.log(registros[0]["bibliotecas"][0]["id_biblioteca"]);
            console.log("Total: ");
            console.log(registros[0]['total']);
           if (registros!=""){
            html = "<table style='width: 700px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";
            html +="<tr><th>Titulo</th><th>Autores</th><th>Biblioteca</th><th>Unidades sisponibles</th></th>";//nombre de los campos a mostrar
            html += "</thead><tbody>";
            for (var i=0; i<registros.length; i++){
                for (var j=0; j<(registros[i]["bibliotecas"]).length; j++){
                console.log(i,j);
                html+="<tr><td></td><td>"+registros[0]['autores']+"</td><td>"+registros[i]["bibliotecas"][j]["id_biblioteca"]+"</td><td>"+registros[i]["bibliotecas"][j]["noLibros"]+"</td> ";
            }}}else{
                html="<table></thead><tbody><tr> <td>No se encontraron registros</td> </tr>";
            }
            html+="<tr><th align="+"center"+">Total</th><th> </th><th> </th><th>"+registros[0]['total']+"</th></th>"
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
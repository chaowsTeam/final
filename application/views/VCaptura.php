<!DOCTYPE html>
<html>

<?php
  $this->load->view('librerias');
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
<script lenguage="javascript" type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script lenguage="javascript" type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">

<style type="text/css">
div.row {
    
     height: 150px;
            margin: 0 auto;
            overflow: hidden;
            padding: 10px 0;
            align-items: center;
            justify-content: space-around;
            display: flex;
            float: none;
}

</style>
<script type="text/javascript">
  var registros;
    function buscaLibro(){
        var libro = document.getElementById('libro').value;
        var prestamo = document.getElementById('prestamo').value;
        alert("Borrado");

       $.ajax({
        url:"http://localhost/final/index.php/ControladorPrincipal/prestamo",
        type:"POST",
        data:{nombreLibro:libro, prestamo:prestamo},
        success: function(respuesta){
            
            //console.log(variable[0]['titulo']); aqui se obtiene el nombre
            //console.log(variable[0]['bibliotecas'][0]); accede al un dato de un biblioteca
            //console.log(variable[0]['bibliotecas'][0]['id_biblioteca']); accede al nombre de una biblioteca 
            //console.log(variable[0]['bibliotecas'][0]['noLibros']); accede al numero de libros que tiene una biblioteca 
            //console.log(registros[1]['bibliotecas'].length);
            //console.log(registros[0]["bibliotecas"][0]["id_biblioteca"]);
            console.log(registros[0]["bibliotecas"][0]);
           if (registros!=""){

            
            html = "<form action = "+"agregaCalificaciones"+" method="+"post"+"><table class='table table-responsive table-bordered'><thead>";
            html +="<tr><th align="+"center"+">Libro</th><th>Biblioteca</th><th>Disponibles</th></th>";//nombre de los campos a mostrar
            html += "</thead><tbody>";
            for (var i=0; i<registros.length; i++){
                for (var j=0; j<(registros[i]["bibliotecas"]).length; j++){
                console.log(i,j);
                html+="<tr> <input type = "+ "text "+" id  = "+"id_alumno "+" name = "+"id_alumno[] "+" value = "+registros[i]["id_alumno"]+" style = "+"visibility:hidden"+"> <input type = "+ "text "+" id  = "+"id_grupo "+" name = "+"id_grupo"+" value = "+registros[i]["titulo"]+" style = "+"visibility:hidden"+"> <td>"+registros[i]["titulo"]+"</td><td>"+registros[i]["bibliotecas"][j]["id_biblioteca"]+"</td><td>"+registros[i]["bibliotecas"][j]["noLibros"]+"</td> ";
            }}}else{
                html="<table> </thead><tbody><tr> <td>No se encontraron registros</td> </tr>";
            }
            $("#muestraDatos").html(html);
        }
    });
   }
</script>
<body>

<div class="content">
  <div class="content__container">
    <p class="content__container__text">
      Menú
    </p>
    
    <ul class="content__container__list">
      <li class="content__container__list__item">Principal !</li>
      <li class="content__container__list__item">Principal !</li>
      <li class="content__container__list__item">Principal !</li>
      <li class="content__container__list__item">Principal !</li>
    </ul>
  </div>
</div>


	<form method= "post" action="agregaAutor">
		<table align="center" style="margin-top: 170px">
  	  		<td align="center" style="padding: 10px" >
   		 		<input type="submit" value="Agregar autores" class="botonVerde" style="width: 200px;" >
   		 	   </td>
	</form>
   <form method= "post" action="agregaTemas">

    
          <td align="center" style="padding: 30px">
          <input   type="submit" value="Agregar temas" class="botonVerde" style="width: 200px;"></input>
        </td>
  </form>
   <form method= "post" action="agregarLibros">
   
    
          <td align="center" style="padding: 30px">
          <input   type="submit" value="Agregar libros" class="botonVerde" style="width: 200px;"></input>
        </td>
  </form>
  <form method= "post" action="agregarLibrosBiblioteca">
    
  
          <td align="center" style="padding: 30px">
          <input   type="submit" value="Agregar libros a bibliotecas" class="botonVerde" style="width: 200px;"></input>
        </td>
  </form>
  <form method= "post" action="pPrincipal">
		<table align="center">
	
  	  		<td align="center" style="padding: 30px">
   		 		<input   type="submit" value="Regresar" class="botonNaranja" style="width: 200px;"></input>
   		 	</td>
	</form>

</tr>
</table>

<div class="row" >
      <div class="col-lg-4" >
        <!--<table>
        <tr>
          <td><label for="libro"><span class="label label-default" for = "libro">Codigo del libro</span></td></label>
          <td>
            <input type="text" name="libro" id="libro" class="form-control" size="50">
          </td>
        </tr>
        
        <tr>
          <td>
            <label for="prestamo"><span class="label label-default" for = "libro">Codigo del prestamo</span></td></label>
            <td>
              <input type="text" name="prestamo" id="prestamo" class="form-control" size="50">
            </td>           
        </tr>

        <tr>
          <td>
            <input type="button" class="botonNaranja" value="Devolver" onclick="buscaLibro()">
          </td>
        </tr>        
        </table>
      -->
       
      </div>
  </div>
  <div id="muestraDatos"></div>
</body>
</html>

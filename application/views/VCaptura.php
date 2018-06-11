<!DOCTYPE html>
<html>
<head>
<?php
	$this->load->view('librerias');
?>
</head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">

<style type="text/css">
  
</style>

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
    <table align="center">
    <tr>
          <td align="center" style="padding: 30px">
          <input   type="submit" value="Agregar temas" class="botonVerde" style="width: 200px;"></input>
        </td>
  </form>
   <form method= "post" action="agregarLibros">
    <table align="center">
    <tr>
          <td align="center" style="padding: 30px">
          <input   type="submit" value="Agregar libros" class="botonVerde" style="width: 200px;"></input>
        </td>
  </form>
  <form method= "post" action="pPrincipal">
		<table align="center">
		<tr>
  	  		<td align="center" style="padding: 30px">
   		 		<input   type="submit" value="Regresar" class="botonRojo" style="width: 200px;"></input>
   		 	</td>
	</form>

</tr>
</table>
</body>
</html>

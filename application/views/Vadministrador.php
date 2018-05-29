<!DOCTYPE html>
<html>
<head>
<?php
	$this->load->view('librerias');
?>
</head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">

<style type="text/css">
	
body {
  width: 100%;
  height: 100%;
  position: fixed;
  background-color: #34495e;
}

.content {
  position: absolute;
  top: 18%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
  height: 160px;
  overflow: hidden;
  font-family: 'Lato', sans-serif;
  font-size: 35px;
  line-height: 40px;
  color: #626567;
}
.content__container {
  font-weight: 600;
  overflow: hidden;
  height: 40px;
  padding: 0 40px;
}
.content__container:before {
  content: '[';
  left: 0;
}
.content__container:after {
  content: ']';
  position: absolute;
  right: 0;
}
.content__container:after, .content__container:before {
  position: absolute;
  top: 0;
  color: #16a085;
  font-size: 42px;
  line-height: 40px;
  -webkit-animation-name: opacity;
  -webkit-animation-duration: 2s;
  -webkit-animation-iteration-count: infinite;
  animation-name: opacity;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
.content__container__text {
  display: inline;
  float: left;
  margin: 0;
}
.content__container__list {
  margin-top: 0;
  padding-left: 110px;
  text-align: left;
  list-style: none;
  -webkit-animation-name: change;
  -webkit-animation-duration: 10s;
  -webkit-animation-iteration-count: infinite;
  animation-name: change;
  animation-duration: 10s;
  animation-iteration-count: infinite;
}
.content__container__list__item {
  line-height: 40px;
  margin: 0;
}

@-webkit-keyframes opacity {
  0%, 100% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
}
@-webkit-keyframes change {
  0%, 12.66%, 100% {
    -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
  }
  16.66%, 29.32% {
    -webkit-transform: translate3d(0, -25%, 0);
            transform: translate3d(0, -25%, 0);
  }
  33.32%,45.98% {
    -webkit-transform: translate3d(0, -50%, 0);
            transform: translate3d(0, -50%, 0);
  }
  49.98%,62.64% {
    -webkit-transform: translate3d(0, -75%, 0);
            transform: translate3d(0, -75%, 0);
  }
  66.64%,79.3% {
    -webkit-transform: translate3d(0, -50%, 0);
            transform: translate3d(0, -50%, 0);
  }
  83.3%,95.96% {
    -webkit-transform: translate3d(0, -25%, 0);
            transform: translate3d(0, -25%, 0);
  }
}
@keyframes opacity {
  0%, 100% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
}
@keyframes change {
  0%, 12.66%, 100% {
    -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
  }
  16.66%, 29.32% {
    -webkit-transform: translate3d(0, -25%, 0);
            transform: translate3d(0, -25%, 0);
  }
  33.32%,45.98% {
    -webkit-transform: translate3d(0, -50%, 0);
            transform: translate3d(0, -50%, 0);
  }
  49.98%,62.64% {
    -webkit-transform: translate3d(0, -75%, 0);
            transform: translate3d(0, -75%, 0);
  }
  66.64%,79.3% {
    -webkit-transform: translate3d(0, -50%, 0);
            transform: translate3d(0, -50%, 0);
  }
  83.3%,95.96% {
    -webkit-transform: translate3d(0, -25%, 0);
            transform: translate3d(0, -25%, 0);
  }
}


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

	<form method= "post" action="CargaVAgregar">
		<table align="center" style="margin-top: 170px">
		
  	  		<td align="center" style="padding: 20px" >
   		 		<input type="submit" value="Agregar Al Catalogo" class="botonVerde" style="width: 200px;" >
   		 	</td>
	</form>


	<form method= "post" action="fGeneraVenta">
		<table align="center">
		<tr> 
  	  		<td align="center" style="padding: 10px">
   		 		<input type="submit" value="Hacer una Venta" class="botonVerde" style="width: 200px;"></input>
   		 	</td>
</form>


	<form method= "post" action="confirmacion">
		<table align="center">
		<tr>   		
  	  		<td align="center" style="padding: 10px">
   		 		<input type="submit" value="Hacer una Compra" class="botonVerde" style="width: 200px;"></input>
   		 	</td>
	</form>



	<form method= "post" action="CarvaVDecideRepo">
		<table align="center">
		<tr>
  	  		<td align="center" style="padding: 10px">
   		 		<input type="submit" value="Generar Reporte" class="botonVerde" style="width: 200px;"></input>
   		 	</td>
	</form>

	<form method= "post" action="login">
		<table align="center">
		<tr>
  	  		<td align="center" style="padding: 30px">
   		 		<input   type="submit" value="Salir" class="botonRojo" style="width: 200px;"></input>
   		 	</td>
	</form>

</tr>
</table>
</body>
</html>

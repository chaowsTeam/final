<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="http://getbootstrap.com/docs-assets/ico/favicon.png">
  <title>Biblioteca</title>
  <?php
    $this->load->view('librerias');
  ?>
  <link href="Starter%20Template%20for%20Bootstrap_files/bootstrap.css" rel="stylesheet">
  <link href="Starter%20Template%20for%20Bootstrap_files/starter-template.css" rel="stylesheet">
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Biblioteca</a>
      </div>

      <form method="post" action="fUserTipe">
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Busqueda</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><input placeholder="Usuario" type="text" required name="usr" style="margin-top: 10px; width: 190px;margin-left: 200px;" class="form-control"></li>
            <li><input placeholder="Contraseña" type="password" required name="psw" style="margin-top: 10px; width: 190px; margin-left: 20px; margin-bottom: 10px; margin-right: 20px;" class="form-control"></li>
            <li><input type="submit" value="Ingresar" class="botonVerde" style="margin-top: 10px;"></li>
          </ul>
        </div>
      </form>
    </div>
  </div>

  <div class="container">
    

  </div>

<script src="Starter%20Template%20for%20Bootstrap_files/jquery-1.js"></script>
<script src="Starter%20Template%20for%20Bootstrap_files/bootstrap.js"></script>
  
</body>
</html>
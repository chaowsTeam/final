<!DOCTYPE html>
<html lang="en"><head>
    <style>
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
    function buscaLibro(){
        var libro = document.getElementById('libro').value;
        console.log(libro);
       $.ajax({
        url:"http://localhost/final/index.php/ControladorPrincipal/obtenLibro",
        type:"POST",
        data:{nombreLibro:libro}, 
        success: function(respuesta){
            alert(respuesta);
            //console.log(respuesta);
        }
    })
    }
</script>
<script type="text/javascript" src="/final/js/jquery-3.3.1.min.js"></script>
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
    <!-- Bootstrap core CSS -->
    <link href="Starter%20Template%20for%20Bootstrap_files/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="Starter%20Template%20for%20Bootstrap_files/starter-template.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
            <li><input placeholder="Usuario" type="text" required name="usr"  id="usr" style="margin-top: 10px; width: 190px;margin-left: 200px;" class="form-control"></li>
            <li><input placeholder="Contraseña" type="password" required name="psw" id="psws" style="margin-top: 10px; width: 190px; margin-left: 20px; margin-bottom: 10px; margin-right: 20px;" class="form-control"></li>
            <li><input type="submit" value="Ingresar" class="botonVerde" style="margin-top: 10px;"></li>
            
            
          </ul>
        </div><!--/.nav-collapse -->


        </form>
      </div>
      <div class="container">

      </div>
    </div>
    </div>
    </div>
    <!-- /.container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
  
 <div class="row" style="margin-top: 50px;" >
      <div class="col-lg-4" >
        <table>
        <tr>
            <span class="label label-default" for = "xbi">Titulo del libro</span></td>
            <td><input type="text" name="libro" id="libro" class="form-control" size="50"></td>
             <td><input type="button" class="btn-control" value="Buscar" onclick="buscaLibro()"></td>
        </tr>
        <tr>
                        
        </tr>
        </table>
        <td>
           
        </td>
      </div>
  </div>
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="Starter%20Template%20for%20Bootstrap_files/jquery-1.js"></script>
    <script src="Starter%20Template%20for%20Bootstrap_files/bootstrap.js"></script>-->
      </body>
</html>
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

  function exportTableToExcel(tableID){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    // Nombre del Archivo
    filename = 'ReporteExcel'
    filename = filename?filename+'.xls':'excel_data.xls';
    // Crea la ligua de descarga
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Crea el path hacía el archivo
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        // Lo nombra
        downloadLink.download = filename;
        //tEjecuta la funcion, descargando automaticamente el excel
        downloadLink.click();
    }
  }

  function repo1(){
    var tituloLibro = document.getElementById('tituloLibro').value;
    var nomBiblio = document.getElementById('nomBiblio').value;
    console.log(tituloLibro);
    console.log(nomBiblio);
    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/generaRepo1",
      type:"POST",
      data:{tituloLibro:tituloLibro, nomBiblio:nomBiblio},
      success: function(respuesta){
        console.log(respuesta);
        var registros = JSON.parse(respuesta);
        console.log(registros);
        if(registros!=''){

          if (registros['indicador'] == 0) {
            alert('Selecciona algún filtro');
          }

          if(registros['indicador'] == 1){
            if (registros["autores"]==' '){
              registros["autores"] = 'No hay autor(es)'
            }
            html = "<table><td><label style='width: 50px; margin-left: 300px;' >Titulo: </label><input readonly value='"+registros["titulo"]+"' class='form-control' type='text' name='titulo' id='titulo' style='width: 260px; margin-left: 300px; margin-bottom: 30px;'></td><td></input><label style='width: 50px; margin-left: 50px;' >Autor(es): </label><input readonly value='"+registros["autores"]+"' class='form-control' type='text' name='autores' id='autores' style='width: 480px; margin-bottom: 30px; margin-left: 50px;'></td></table>";

            html += "<table style='width: 300px;' class='table table-responsive table-bordered' align="+"center"+" id='tablita' ><thead>";

            html +="<tr><th>Biblioteca</th><th>Unidades disponibles</th></th>";

            html += "<input type='hidden' value='"+registros[0]["titulo"]+", "+registros[0]["autores"]+"' name='header'></td>";

            for (var i=0; i<1; i++){
              for (var j=0; j<(registros[i]['bibliotecas']).length; j++){
                html+="<tr><td>"+registros[i]['bibliotecas'][j]['id_biblioteca']+"</td><td align='center'>"+registros[i]['bibliotecas'][j]['noLibros']+"</td> ";

                html += "<input type='hidden' value='"+registros[i]['bibliotecas'][j]['id_biblioteca']+"'name='biblioteca[]'></td>";
                html += "<input type='hidden' value='"+registros[i]['bibliotecas'][j]['noLibros']+"'name='cant[]'></td>";
              }
            }
            html+="<tr><th>Total</th><th align='center'>"+registros[0]['total']+"</th>";
            html += "<input type='hidden' value='"+registros[0]['total']+"'name='total'></td>";
          }

          if (registros['indicador'] == 2) {
              html = "<table><td><label style='width: 50px; margin-left: 365px;' >Biblioteca: </label><input readonly value='"+registros["biblioteca"]+"' class='form-control' type='text' name='bibliO' id='bibliO' style='width: 260px; margin-left: 365px; margin-bottom: 30px;'></td><td></input><td></table>";

              html += "<table id='tablita' style='width: 500px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";

              html +="<tr><th>Libro</th><th>Autor(es)</th><th>Unidades Disponibles</th></th>";

              for (var i=0; i<registros['libros'].length; i++){
                if (registros['libros'][i]['autores']==' ') {
                  registros['libros'][i]['autores'] = 'No hay autor(es)'
                }
                html+="<tr><td>"+registros['libros'][i]['titulo']+"</td><td align='center'>"+registros['libros'][i]['autores']+"</td><td>"+registros['libros'][i]['cantidad']+"</td> ";
                html+= "<input type='hidden' value='"+registros['libros'][i]['titulo']+"'name='libro[]'></td>";
                html+= "<input type='hidden' value='"+registros['libros'][i]['autores']+"'name='autores[]'></td>";
                html+= "<input type='hidden' value='"+registros['libros'][i]['cantidad']+"'name='unid[]'></td>";

              }

              html+="<tr><th>Total</th><th></th><th align='center'>"+registros['totalGlobal']+"</th>";
              html+= "<input type='hidden' value='"+registros['totalGlobal']+"'name='total'></td>";
          }

          if (registros['indicador'] == 3) {
            html = "<table id='tablita'><td><label style='margin-left: 250px;' >Hay: </label></td><td><input readonly value='"+registros["cantidad"]+"' class='form-control' type='text' name='cantidadL' id='cantidadL' style='width: 80px; margin-left: 30px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 15px;' >Ejemplares de: </label></td><td><input readonly value='"+registros["nomLibro"]+"' class='form-control' type='text' name='nomL' id='nomL' style='width: 250px; margin-bottom: 30px; margin-left: 20px;'></td><td><td><label style='margin-left: 15px;' >En la biblioteca: </label></td><td><input readonly value='"+registros["biblioteca"]+"' class='form-control' type='text' name='biblioteca' id='biblioteca' style='width: 150px; margin-left: 20px; margin-bottom: 30px;'></td></table>";
          }
        }
        html += "<input type='hidden' name='opcionhidden' id='opcionhidden' value="+registros['indicador']+">";
        //Mostrar la información en pantalla.
        $("#muestraDatos1").html(html);
      }      
    });
  }
//2222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222
  function repo2(){
    var tituloLibro2 = document.getElementById('tituloLibro2').value;
    var nomBiblio2 = document.getElementById('nomBiblio2').value;
    var D_ini = document.getElementById('D_ini').value;
    var D_fin = document.getElementById('D_fin').value;
    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/generaRepo2",
      type:"POST",
      data:{tituloLibro2:tituloLibro2, nomBiblio2:nomBiblio2, D_ini:D_ini, D_fin:D_fin},
      success: function(respuesta){
        var registros = JSON.parse(respuesta);
        if(registros!=''){

          if (registros['indicador'] == 0) {
            alert('Selecciona algún filtro (Titulo/Biblioteca) y !Fechas Obligatorias!');
          }

          if(registros['indicador'] == 1){
            html = "<table><td><label style='width: 50px; margin-left: 305px;' >Titulo: </label><input readonly value='"+registros["titulo"]+"' class='form-control' type='text' name='titulo' id='titulo' style='width: 260px; margin-left: 305px; margin-bottom: 30px;'></td><td></input><label style='width: 50px; margin-left: 50px;' >Prestamos de: </label><input readonly value='"+registros["D_ini"]+"' class='form-control' type='text' name='D_ini' id='D_ini' style='width: 180px; margin-bottom: 30px; margin-left: 50px;'></td><td><label style='width: 50px; margin-left: 50px;' >A: </label><input readonly value='"+registros["D_fin"]+"' class='form-control' type='text' name='D_fin' id='D_fin' style='width: 180px; margin-bottom: 30px; margin-left: 50px;'></td></table>";

            html += "<table style='width: 300px;' class='table table-responsive table-bordered' align="+"center"+" id='tablita' ><thead>";

            html +="<tr><th>Biblioteca</th><th>Cant. Prestamos</th></th>";

            for (var i=0; i<registros['cantB']; i++){
              html+="<tr><td>"+registros[i]['biblioteca']+"</td><td align='center'>"+registros[i]['cantPrestam']+"</td> ";
              html += "<input type='hidden' value='"+registros[i]['biblioteca']+"'name='biblioteca[]'></td>";
              html += "<input type='hidden' value='"+registros[i]['cantPrestam']+"'name='cant[]'></td>";
            }
            html+="<tr><th>Total</th><th align='center'>"+registros['TotalP']+"</th>";
            html += "<input type='hidden' value='"+registros['TotalP']+"'name='total'></td>";
          }

          if (registros['indicador'] == 2) {
              html = "<table><td><label style='width: 50px; margin-left: 365px;' >Biblioteca: </label><input readonly value='"+registros["biblioteca"]+"' class='form-control' type='text' name='bibliO' id='bibliO' style='width: 260px; margin-left: 370px; margin-bottom: 30px;'></td><td></input><td></table>";

              html += "<table id='tablita' style='width: 500px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";

              html +="<tr><th>Libro</th><th>Cant. Prestamos</th></th>";

              for (var i=0; i<registros['libros'].length; i++){
                html+="<tr><td>"+registros['libros'][i]['titulo']+"</td><td align='center'>"+registros['libros'][i]['cantPrestam']+"</td>";
                html+= "<input type='hidden' value='"+registros['libros'][i]['titulo']+"'name='libros[]'></td>";
                html+= "<input type='hidden' value='"+registros['libros'][i]['cantPrestam']+"'name='cantP[]'></td>";
              }

              html+="<tr><th>Total</th><th align='center'>"+registros['totalGlobal']+"</th>";
              html+= "<input type='hidden' value='"+registros['totalGlobal']+"'name='total'></td>";
          }

          if (registros['indicador'] == 3) {
            html = "<table id='tablita'><td><label style='margin-left: 35px;' >Hay: </label></td><td><input readonly value='"+registros["cantPrestam"]+"' class='form-control' type='text' name='cantidadL' id='cantPrestam' style='width: 80px; margin-left: 25px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 15px;' >Prestamos de: </label></td><td><input readonly value='"+registros["nomLibro"]+"' class='form-control' type='text' name='nomL' id='nomL' style='width: 250px; margin-bottom: 30px; margin-left: 20px;'></td><td><td><label style='margin-left: 15px;' >En la biblioteca: </label></td><td><input readonly value='"+registros["biblioteca"]+"' class='form-control' type='text' name='biblioteca' id='biblioteca' style='width: 130px; margin-left: 20px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 15px;' >Del: </label></td><td><input readonly value='"+registros["D_ini"]+"' class='form-control' type='text' name='D_i' id='D_i' style='width: 100px; margin-left: 25px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 15px;' >Al: </label></td><td><input readonly value='"+registros["D_fin"]+"' class='form-control' type='text' name='D_fin' id='D_fin' style='width: 100px; margin-left: 25px; margin-bottom: 30px;'></td></input></table>";
          }
        }
        html += "<input type='hidden' name='opcionhidden' id='opcionhidden' value="+registros['indicador']+">";
        //Mostrar la información en pantalla.
        $("#muestraDatos2").html(html);
      }      
    });
  }

//4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
function repo4(){
    var usr4 = document.getElementById('usr4').value;
    var D_ini4 = document.getElementById('D_ini4').value;
    var D_fin4 = document.getElementById('D_fin4').value;
    console.log(usr4);
    console.log(D_ini4);
    console.log(D_fin4);
    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/generaRepo4",
      type:"POST",
      data:{usr4:usr4, D_ini4:D_ini4, D_fin4:D_fin4},
      success: function(respuesta ){
        var registros = JSON.parse(respuesta);
        console.log('Registros: ');
        console.log(registros['indicador']);
        if(registros!=''){

          if (registros['indicador'] == 0) {
            alert('Selecciona algún filtro');
          }

          if(registros['indicador'] == 1){
            html = "<table><td><label style='margin-left: 473px;' >Cantidad de pestamos Del: </label><input readonly value='"+registros["D_ini"]+"' class='form-control' type='text' name='D_ini' id='D_ini' style='width: 200px; margin-left: 473px; margin-bottom: 30px;'></td></input><td><label style='width: 50px; margin-left: 50px;' >Al: </label><input readonly value='"+registros["D_fin"]+"' class='form-control' type='text' name='D_fin' id='D_fin' style='width: 200px; margin-left: 50px; margin-bottom: 30px;'></td></input></table>";

            html += "<table style='width: 400px;' class='table table-responsive table-bordered' align="+"center"+" id='tablita' ><thead>";

            html +="<tr><th>Usuario</th><th>Cant. Prestamos</th></tr>";

              for (var i=0; i< registros['length']; i++){
                html+="<tr><td>"+registros[i]['nomUsr']+"</td><td>"+registros[i]['cantPrestam']+"</td>";

                html += "<input type='hidden' value='"+registros[i]['nomUsr']+"'name='usrs[]'></td>";
                html += "<input type='hidden' value='"+registros[i]['cantPrestam']+"'name='cants[]'></td>";                                
              }

              html +="<tr><th>Total</th><th>"+registros['TotalP']+"</th></tr>";
              html +="<input type='hidden' value='"+registros['TotalP']+"'name='totalP'></td>";
            //html+="<tr><th>Total</th><th align='center'>"+registros[0]['total']+"</th>";
            //html += "<input type='hidden' value='"+registros[0]['total']+"'name='total'></td>";
          }

          if (registros['indicador'] == 2) {
            html = "<table id='tablita'><td><label style='margin-left: 200px;' >Cantidad Prestamos al usuario: </label></td><td><input readonly value='"+registros["nomUsr"]+"' class='form-control' type='text' name='nomUser' id='nomUser' style='width: 120px; margin-left: 15px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 15px;' >Del:  </label></td><td><input readonly value='"+registros["D_ini"]+"' class='form-control' type='text' name='D_ini' id='D_ini' style='width: 150px; margin-bottom: 30px; margin-left: 20px;'></td><td><label style='margin-left: 15px;' >Al:  </label></td><td><input readonly value='"+registros["D_fin"]+"' class='form-control' type='text' name='D_fin' id='D_fin' style='width: 150px; margin-bottom: 30px; margin-left: 20px;'></td><td><label style='margin-left:30px;'>--> </label></td><td><input readonly value='"+registros["cantPrestam"]+"' class='form-control' type='text' name='totaP' id='totalP' style='width: 150px; margin-bottom: 30px; margin-left: 20px;'></td></table>";
          }
        }
        html += "<input type='hidden' name='opcionhidden' id='opcionhidden' value="+registros['indicador']+">";
        //Mostrar la información en pantalla.
        $("#muestraDatos4").html(html);
      }      
    });
  }

//33333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333
function repo3(){
    var tituloLibro3 = document.getElementById('tituloLibro3').value;
    var nomBiblio3 = document.getElementById('nomBiblio3').value;
    var D_i3 = document.getElementById('D_in3').value;
    var D_f3 = document.getElementById('D_fin3').value;
    console.log(tituloLibro3);
    console.log(nomBiblio3);
    console.log(D_i3);
    console.log(D_f3);
    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/generaRepo3",
      type:"POST",
      data:{tituloLibro3:tituloLibro3, nomBiblio3:nomBiblio3, D_i3:D_i3, D_f3:D_f3},
      success: function(respuesta ){
        var registros = JSON.parse(respuesta);
        console.log('Registros: ');
        console.log(registros);
        if(registros!=''){

          if (registros['indicador'] == 0) {
            alert('Selecciona algún filtro (¡Fechas Obligatorias!)');
          }
          if(registros['indicador'] == 1){
            html = "<table><td><label style='margin-left: 340px;' >Libro: </label><input readonly value='"+registros["titulo"]+"' class='form-control' type='text' name='tituloL' id='tituloL' style='width: 200px; margin-left: 340px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 25px;' >Cantidad de pestamos Del: </label><input readonly value='"+registros["D_ini"]+"' class='form-control' type='text' name='D_ini' id='D_ini' style='width: 200px; margin-left: 25px; margin-bottom: 30px;'></td></input><td><label style='width: 50px; margin-left: 50px;' >Al: </label><input readonly value='"+registros["D_fin"]+"' class='form-control' type='text' name='D_fin' id='D_fin' style='width: 200px; margin-left: 50px; margin-bottom: 30px;'></td></input></table>";

            html += "<table style='width: 600px;' class='table table-responsive table-bordered' align="+"center"+" id='tablita' ><thead>";

            html +="<tr><th>Biblioteca</th><th>Nom. Empleado</th><th>Nom. Usuario</th><th>Fecha Prestamo</th><th>Fecha Devolución</th></tr>";

              for (var i=0; i< registros['cantB']; i++){
                html+="<tr><td>"+registros[i]['biblioteca']+"</td><td></td><td></td><td></td><td></td>";
                html += "<input type='hidden' value='"+registros[i]['biblioteca']+"'name='biblios[]'></td>";

                for (var j = 0; j < registros[i]['cantPrestam']; j++) {
                  html+="<tr><td></td><td>"+registros[i]['infoPrestamo'][j]['nom_empleado']+"</td><td>"+registros[i]['infoPrestamo'][j]['nom_usuario']+"</td><td>"+registros[i]['infoPrestamo'][j]['fecha_prest']+"</td><td>"+registros[i]['infoPrestamo'][j]['fecha_dev']+"</td>";

                  html += "<input type='hidden' value='"+registros[i]['infoPrestamo'][j]['nom_empleado']+"'name='empleados[]'></td>";
                  html += "<input type='hidden' value='"+registros[i]['infoPrestamo'][j]['nom_usuario']+"'name='usuarios[]'></td>";
                  html += "<input type='hidden' value='"+registros[i]['infoPrestamo'][j]['fecha_prest']+"'name='f_i[]'></td>";
                  html += "<input type='hidden' value='"+registros[i]['infoPrestamo'][j]['fecha_dev']+"'name='f_f[]'></td>";
                }

                html+="<tr><th>Total</th><td></td><td></td><td></td><th>"+registros[i]['cantPrestam']+"</th>";
                html += "<input type='hidden' value='"+registros[i]['cantPrestam']+"'name='cants[]'></td>";                                
              }

              html +="<tr><th>Total Global</th><td></td><td></td><td></td><td></td<th>"+registros['TotalP']+"</th></tr>";
              html +="<input type='hidden' value='"+registros['TotalP']+"'name='totalP'></td>";
            //html+="<tr><th>Total</th><th align='center'>"+registros[0]['total']+"</th>";
            //html += "<input type='hidden' value='"+registros[0]['total']+"'name='total'></td>";
          }

          if (registros['indicador'] == 2) {
            html = "<table><td><label style='margin-left: 340px;' >Biblioteca: </label><input readonly value='"+registros["biblioteca"]+"' class='form-control' type='text' name='biblio' id='biblio' style='width: 200px; margin-left: 340px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 25px;' >Cantidad de pestamos Del: </label><input readonly value='"+registros["D_i"]+"' class='form-control' type='text' name='D_ini' id='D_ini' style='width: 200px; margin-left: 25px; margin-bottom: 30px;'></td></input><td><label style='width: 50px; margin-left: 50px;' >Al: </label><input readonly value='"+registros["D_f"]+"' class='form-control' type='text' name='D_fin' id='D_fin' style='width: 200px; margin-left: 50px; margin-bottom: 30px;'></td></input></table>";

            html += "<table style='width: 600px;' class='table table-responsive table-bordered' align="+"center"+" id='tablita' ><thead>";

            html +="<tr><th>Libro</th><th>Nom. Empleado</th><th>Nom. Usuario</th><th>Fecha Prestamo</th><th>Fecha Devolución</th></tr>";
            
              for (var i=0; i< (registros['prestamos']).length; i++){
                html+="<tr><td>"+registros['prestamos'][i]['titulo']+"</td><td>"+registros['prestamos'][i]['nom_empleado']+"</td><td>"+registros['prestamos'][i]['nom_usuario']+"</td><td>"+registros['prestamos'][i]['fecha_prest']+"</td><td>"+registros['prestamos'][i]['fecha_dev']+"</td>";

                html += "<input type='hidden' value='"+registros['prestamos'][i]['titulo']+"'name='titulos[]'></td>";
                html += "<input type='hidden' value='"+registros['prestamos'][i]['nom_empleado']+"'name='empleados[]'></td>";
                html += "<input type='hidden' value='"+registros['prestamos'][i]['nom_usuario']+"'name='usuarios[]'></td>";
                html += "<input type='hidden' value='"+registros['prestamos'][i]['fecha_prest']+"'name='f_ps[]'></td>";
                html += "<input type='hidden' value='"+registros['prestamos'][i]['fecha_dev']+"'name='f_ds[]'></td>";
          }

          html +="<tr><th>Total</th><th></th><th></th><th></th><th>"+registros['totalGlobal']+"</th></tr>";
          html += "<input type='hidden' value='"+registros['totalGlobal']+"'name='totalG'></td>";

        }

        if (registros['indicador'] == 3) {
          html = "<table id='tablita'><td><label style='margin-left: 60px;' >Prestamos del libro: </label></td><td><input readonly value='"+registros["titulo"]+"' class='form-control' type='text' name='titulo' id='titulo' style='width: 220px; margin-left: 15px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 15px;' >En la biblioteca:  </label></td><td><input readonly value='"+registros["biblioteca"]+"' class='form-control' type='text' name='biblioteca' id='biblioteca' style='width: 150px; margin-bottom: 30px; margin-left: 20px;'></td><td><label style='margin-left: 15px;' >Del:  </label></td><td><input readonly value='"+registros["D_i"]+"' class='form-control' type='text' name='D_in' id='D_in' style='width: 150px; margin-bottom: 30px; margin-left: 20px;'></td><td><label style='margin-left:30px;'>Al:  </label></td><td><input readonly value='"+registros["D_f"]+"' class='form-control' type='text' name='D_f' id='D_f' style='width: 150px; margin-bottom: 30px; margin-left: 20px;'></td><td><label style='margin-left:30px;'> --->  </label></td><td><input readonly value='"+registros['prestamos'].length+"' class='form-control' type='text' name='totalG' id='totalG' style='width: 50px; margin-bottom: 30px; margin-left: 20px;'></td></table>";

           html += "<table style='width: 600px;' class='table table-responsive table-bordered' align="+"center"+" id='tablita' ><thead>";

            html +="<tr><th>Nom. Empleado</th><th>Nom. Usuario</th><th>Fecha Prestamo</th><th>Fecha Devolución</th></tr>";

          for (var i = 0; i < registros['prestamos'].length; i++) {
            html+="<tr><td>"+registros['prestamos'][i]['nom_empleado']+"</td><td>"+registros['prestamos'][i]['nom_usuario']+"</td><td>"+registros['prestamos'][i]['fecha_prest']+"</td><td>"+registros['prestamos'][i]['fecha_dev']+"</td>";

            html += "<input type='hidden' value='"+registros['prestamos'][i]['nom_empleado']+"'name='empleados[]'></td>";
            html += "<input type='hidden' value='"+registros['prestamos'][i]['nom_usuario']+"'name='usuarios[]'></td>";
            html += "<input type='hidden' value='"+registros['prestamos'][i]['fecha_prest']+"'name='f_ps[]'></td>";
            html += "<input type='hidden' value='"+registros['prestamos'][i]['fecha_dev']+"'name='f_ds[]'></td>";
          }

        }
        }
        html += "<input type='hidden' name='opcionhidden' id='opcionhidden' value="+registros['indicador']+">";
        //Mostrar la información en pantalla.
        $("#muestraDatos3").html(html);
      }      
    });
  }

//5555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555
function repo5(){
    var tituloLibro5 = document.getElementById('tituloLibro5').value;
    var usr = document.getElementById('usr').value;
    console.log(tituloLibro5);
    console.log(usr);
    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/generaRepo5",
      type:"POST",
      data:{tituloLibro5:tituloLibro5, usr:usr},
      success: function(respuesta){
        var registros = JSON.parse(respuesta);
        console.log('Registros: ');
        console.log(registros);
        console.log(registros['indicador']);
        if(registros!=''){

          if (registros['indicador'] == 0) {
            alert('Selecciona algún filtro');
          }

          if(registros['indicador'] == 1){
            html = "<table><td><label style='width: 50px; margin-left: 300px;' >Titulo: </label><input readonly value='"+registros["tituloLibro"]+"' class='form-control' type='text' name='titulo' id='titulo' style='width: 260px; margin-left: 300px; margin-bottom: 30px;'></td><td></input></table>";

            html += "<table style='width: 600px;' class='table table-responsive table-bordered' align="+"center"+" id='tablita' ><thead>";

            html +="<tr><th>Usuario</th><th>Biblioteca</th><th>Fecha Prestamo</th><th>Fecha Devolucion</th></tr>";

              for (var i=0; i< (registros['length']); i++){
                html+="<tr><td>"+registros[i]['nomUsr']+"</td><td></td><td></td><td></td>";

                html += "<input type='hidden' value='"+registros[i]['nomUsr']+"'name='usrs[]'></td>";

                for(var j=0; j< registros[i]['infoPrestamo'].length; j++){
                  html+="<tr><td></td><td>"+registros[i]['infoPrestamo'][j]['biblioteca']+"</td><td>"+registros[i]['infoPrestamo'][j]['fecha_prest']+"</td><td>"+registros[i]['infoPrestamo'][j]['fecha_dev']+"</td>";


                  html += "<input type='hidden' value='"+registros[i]['infoPrestamo'][j]['biblioteca']+"'name='bibliotecas[]'></td>";
                  html += "<input type='hidden' value='"+registros[i]['infoPrestamo'][j]['fecha_prest']+"'name='f_pres[]'></td>";
                  html += "<input type='hidden' value='"+registros[i]['infoPrestamo'][j]['fecha_dev']+"'name='f_dev[]'></td>";
                }
                html +="<tr><th>Total</th><th></th><th></th><th>"+registros[i]['totalPrestam']+"</th></tr>";
                html +="<input type='hidden' value='"+registros[i]['totalPrestam']+"'name='totalP[]'></td>";
                
              }
            //html+="<tr><th>Total</th><th align='center'>"+registros[0]['total']+"</th>";
            //html += "<input type='hidden' value='"+registros[0]['total']+"'name='total'></td>";
          }

          if (registros['indicador'] == 2) {
              html = "<table><td><label style='width: 50px; margin-left: 365px;' >Usuario: </label><input readonly value='"+registros["nomUsr"]+"' class='form-control' type='text' name='usuario' id='usuario' style='width: 260px; margin-left: 365px; margin-bottom: 30px;'></td><td></input><td></table>";

              html += "<table id='tablita' style='width: 500px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";

              html +="<tr><th>Libro</th><th>Biblioteca</th><th>Fecha Prestamo</th><th>Fecha Devolución</th></th>";

              for (var i=0; i< (registros['length']); i++){
                html+="<tr><td>"+registros['infoPrestamo'][i]['tituloLibro']+"</td><td>"+registros['infoPrestamo'][i]['biblioteca']+"</td><td>"+registros['infoPrestamo'][i]['fecha_prest']+"</td><td>"+registros['infoPrestamo'][i]['fecha_dev']+"</td>";

                html += "<input type='hidden' value='"+registros['infoPrestamo'][i]['tituloLibro']+"'name='titulos[]'></td>";
                html += "<input type='hidden' value='"+registros['infoPrestamo'][i]['biblioteca']+"'name='biblios[]'></td>";
                html += "<input type='hidden' value='"+registros['infoPrestamo'][i]['fecha_prest']+"'name='f_pres[]'></td>";
                html += "<input type='hidden' value='"+registros['infoPrestamo'][i]['fecha_dev']+"'name='f_dev[]'></td>";                
              }

              html +="<tr><th>Total</th><th></th><th></th><th>"+registros['totalPrestam']+"</th></tr>";

              html +="<input type='hidden' value='"+registros['totalPrestam']+"'name='totalP'></td>";
          }

          if (registros['indicador'] == 3) {
            html = "<table id='tablita'><td><label style='margin-left: 250px;' >Prestamos del libro: </label></td><td><input readonly value='"+registros["nomLibro"]+"' class='form-control' type='text' name='nomL' id='nomL' style='width: 300px; margin-left: 15px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 15px;' >Al usuario: </label></td><td><input readonly value='"+registros["usr"]+"' class='form-control' type='text' name='usr' id='usr' style='width: 150px; margin-bottom: 30px; margin-left: 20px;'></td><td><td></table>";

            html += "<table id='tablita' style='width: 500px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";

            html +="<tr><th>Biblioteca</th><th>Fecha Prestamo</th><th>Fecha Devolución</th></th>";

            for (var i = 0; i < registros['infoPrestamo'].length; i++ ) {
              html+="<tr><td>"+registros['infoPrestamo'][i]['biblioteca']+"</td><td>"+registros['infoPrestamo'][i]['fecha_prest']+"</td><td>"+registros['infoPrestamo'][i]['fecha_dev']+"</td>";

                html += "<input type='hidden' value='"+registros['infoPrestamo'][i]['biblioteca']+"'name='biblios[]'></td>";
                html += "<input type='hidden' value='"+registros['infoPrestamo'][i]['fecha_prest']+"'name='f_pres[]'></td>";
                html += "<input type='hidden' value='"+registros['infoPrestamo'][i]['fecha_dev']+"'name='f_dev[]'></td>";
            }

            html +="<tr><th>Total</th><th></th><th>"+registros['totalP']+"</th></th>";
            html +="<input type='hidden' value='"+registros['totalP']+"'name='totalP'></td>";

          }
        }
        html += "<input type='hidden' name='opcionhidden' id='opcionhidden' value="+registros['indicador']+">";
        //Mostrar la información en pantalla.
        $("#muestraDatos5").html(html);
      }      
    });
  }


//666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666
  function repo6(){
    var nomBiblio6 = document.getElementById('nomBiblio6').value;
    var mes = document.getElementById('mes').value;
    console.log('NomBiblio: ');
    console.log(nomBiblio6);
    console.log('Mes: ');
    console.log(mes);
    $.ajax({
      url:"http://localhost/final/index.php/ControladorPrincipal/generaRepo6",
      type:"POST",
      data:{nomBiblio6:nomBiblio6, mes:mes},
      success: function(respuesta){
        var registros = JSON.parse(respuesta);
        console.log('Los registros son: ');
        console.log(registros);
        if(registros!=''){

          if (registros['indicador'] == 0) {
            alert('Selecciona algún filtro');
          }

          if(registros['indicador'] == 1){
            html = "<table><td><label style='width: 50px; margin-left: 420px;' >Biblioteca: </label><input readonly value='"+registros['biblioteca']+"' class='form-control' type='text' name='header' id='header' style='width: 260px; margin-left: 420px; margin-bottom: 30px;'></td><td></input></table>";

            html += "<table id='tablita' style='width: 500px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";

            html +="<tr><th>Mes</th><th>Cant. Prestamos</th></th>";

              for (var i=1; i<13; i++){
                html+="<tr><td>"+registros[i]['mes']+"</td><td>"+registros[i]['cantPrestam']+"</td>";
                html += "<input type='hidden' value='"+registros[i]['mes']+"'name='meses[]'></td>";
                html += "<input type='hidden' value='"+registros[i]['cantPrestam']+"'name='cantP[]'></td>";
              }

            html+="<tr><th>Total</th><th align='center'>"+registros['TotalP']+"</th>";
            html += "<input type='hidden' value='"+registros['TotalP']+"'name='total'></td>";
          }

          if (registros['indicador'] == 2) {
              html = "<table><td><label style='width: 50px; margin-left: 415px;' >Mes: </label><input readonly value='"+registros['mes']+"' class='form-control' type='text' name='month' id='month' style='width: 260px; margin-left: 420px; margin-bottom: 30px;'></td><td></input><td></table>";

              html += "<table id='tablita' style='width: 500px;' class='table table-responsive table-bordered' align="+"center"+"><thead>";

              html +="<tr><th>Biblioteca</th><th>Prestamos</th>";

              for (var i=0; i<registros['length']; i++){
                html+="<tr><td>"+registros[i]['biblioteca']+"</td><td align='center'>"+registros[i]['cantPrestam']+"</td>";
                html+= "<input type='hidden' value='"+registros[i]['biblioteca']+"'name='biblios[]'></td>";
                html+= "<input type='hidden' value='"+registros[i]['cantPrestam']+"'name='cantP[]'></td>";
              }

              html+="<tr><th>Total</th><th align='center'>"+registros['TotalP']+"</th>";
              html+= "<input type='hidden' value='"+registros['TotalP']+"'name='total'></td>";
          }

          if (registros['indicador'] == 3) {
            html = "<table id='tablita'><td><label style='margin-left: 315px;' >Hay: </label></td><td><input readonly value='"+registros["noPrestamos"]+"' class='form-control' type='text' name='noPrestamos' id='noPrestamos' style='width: 80px; margin-left: 30px; margin-bottom: 30px;'></td></input><td><label style='margin-left: 15px; width:200px;' >Prestamos en el mes de: </label></td><td><input readonly value='"+registros["mes"]+"' class='form-control' type='text' name='mes' id='mes' style='width: 250px; margin-bottom: 15px; margin-left: 10px;'></td><td><td><label style='margin-left: 15px;' >En la biblioteca: </label></td><td><input readonly value='"+registros["biblioteca"]+"' class='form-control' type='text' name='biblioteca' id='biblioteca' style='width: 150px; margin-left: 20px; margin-bottom: 30px;'></td></table>";
          }
        }
        html += "<input type='hidden' name='opcionhidden' id='opcionhidden' value="+registros['indicador']+">";
        //Mostrar la información en pantalla.
        $("#muestraDatos6").html(html);
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
      <option>Selecciona tipo de Reporte ...</option>
      <option value="1">Titulo libro, Autor(es), Biblioteca, Total</option>
      <option value="2">Titulo libo, Biblioteca, Total de prestamos</option>
      <option value="3">Biblioteca, Titulo libro, Total de prestamos</option>
      <option value="4">Usuario, Total de prestamos</option>
      <option value="5">Usuario, Titulo libro, Biblioteca, No. ejemplar</option>
      <option value="6">Biblioteca, Mes, Total de prestamos</option>
    </select>
  </td>
</table>



  <div id="div_1" class="contenido" class="container">
    <form method="post" action="fPDFRepo1" target="_blank" >
      <table style="margin-top: 30px; margin-left: 420px;" >
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

      <div id="muestraDatos1" name="muestraDatos1">
        <!-- Este es el div en que se desplegara la consulta-->
      </div>

      <table style="margin-top: 30px; margin-left: 407px;" >
        <td>
          <input type="submit" value="GenerarPDF" class="botonRojo" style="width: 150px; margin-top: 10px;"></input> 
    </form>
        </td>
        <td>
          <input value="Consultar" class="botonVerde" type="button" style="width: 250px; margin-left: 10px; margin-top: 10px;"  onclick="repo1()"></input> 
        </td>
        <td>
            <button class="botonVerde" style="margin-left: 10px; margin-top: 10px; width: 150px;" onclick="exportTableToExcel('tablita')">Generar Excel</button>
        </td>
      </table>
  </div>
<!--22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222-->
  <div id="div_2" class="contenido" class="container">
    <form method="post" action="fPDFRepo2" target="_blank" >
      <table style="margin-top: 30px; margin-left: 205px;" >
        <td>
          <select class="form-control" id="tituloLibro2" name="tituloLibro2" style="width: 200px;  margin-bottom: 50px; margin-right: 20px; margin-left: 24px;">
          <option value="vacio">Elige Titulo ... </option>
          <?php
          for ($i=0; $i < count($this->titulos); $i++) {?>
            <option><?php echo $this->titulos[$i]['titulo'] ?></option>
          <?php } ?>
          </select>
        </td>

        <td>
          <select class="form-control" name="nomBiblio2" id="nomBiblio2" style="width: 200px; margin-bottom: 50px;">
            <option value="vacio">Elige Biblioteca ... </option>
            <?php
            for ($i=0; $i < count($this->biblios); $i++) {?>
              <option><?php echo $this->biblios[$i]['nom_biblioteca'] ?></option>
            <?php } ?>
          </select>
        </td>
        <td>
          <label style='margin-left: 25px; margin-bottom: 50px;' >De: </label>
        </td>
        <td>
          <input required type="date" id="D_ini" name="D_ini" class="form-control" style="margin-left: 15px; margin-bottom: 50px;"></input>
        </td>
        <td>
          <label style='margin-left: 25px; margin-bottom: 50px;' >A: </label>
        </td>
        <td>
          <input required type="date" id="D_fin" name="D_fin" class="form-control" style="margin-left: 25px; margin-bottom: 50px;"></input>
        </td>
      </table>

      <div id="muestraDatos2" name="muestraDatos2">
        <!-- Este es el div en que se desplegara la consulta-->
      </div>

      <table style="margin-top: 30px; margin-left: 412px;" >
        <td>
          <input type="submit" value="GenerarPDF" class="botonRojo" style="width: 150px; margin-top: 10px;"></input> 
    </form>
        </td>
        <td>
          <input value="Consultar" class="botonVerde" type="button" style="width: 250px; margin-left: 10px; margin-top: 10px;"  onclick="repo2()"></input> 
        </td>
        <td>
            <button class="botonVerde" style="margin-left: 10px; margin-top: 10px; width: 150px;" onclick="exportTableToExcel('tablita')">Generar Excel</button>
        </td>
      </table>
  </div>
<!--3333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333-->
<div id="div_3" class="contenido" class="container">
    <form method="post" action="fPDFRepo3" target="_blank" >
      <table style="margin-top: 30px; margin-left: 200px;" >
        <td>
          <select class="form-control" id="tituloLibro3" name="tituloLibro3" style="width: 200px;  margin-bottom: 50px; margin-right: 20px; margin-left: 24px;">
          <option value="vacio">Elige Titulo ... </option>
          <?php
          for ($i=0; $i < count($this->titulos); $i++) {?>
            <option><?php echo $this->titulos[$i]['titulo'] ?></option>
          <?php } ?>
          </select>
        </td>

        <td>
          <select class="form-control" name="nomBiblio3" id="nomBiblio3" style="width: 200px; margin-bottom: 50px;">
            <option value="vacio">Elige Biblioteca ... </option>
            <?php
            for ($i=0; $i < count($this->biblios); $i++) {?>
              <option><?php echo $this->biblios[$i]['nom_biblioteca'] ?></option>
            <?php } ?>
          </select>
        </td>
        <td>
          <label style='margin-left: 25px; margin-bottom: 50px;' >De: </label>
        </td>
        <td>
          <input required type="date" id="D_in3" name="D_in3" class="form-control" style="margin-left: 15px; margin-bottom: 50px;"></input>
        </td>
        <td>
          <label style='margin-left: 25px; margin-bottom: 50px;' >A: </label>
        </td>
        <td>
          <input required type="date" id="D_fin3" name="D_fin3" class="form-control" style="margin-left: 25px; margin-bottom: 50px;"></input>
        </td>
      </table>

      <div id="muestraDatos3" name="muestraDatos3">
        <!-- Este es el div en que se desplegara la consulta-->
      </div>

      <table style="margin-top: 30px; margin-left: 400px;" >
        <td>
          <input type="submit" value="GenerarPDF" class="botonRojo" style="width: 150px; margin-top: 10px;"></input> 
    </form>
        </td>
        <td>
          <input value="Consultar" class="botonVerde" type="button" style="width: 250px; margin-left: 10px; margin-top: 10px;"  onclick="repo3()"></input> 
        </td>
        <td>
            <button class="botonVerde" style="margin-left: 10px; margin-top: 10px; width: 150px;" onclick="exportTableToExcel('tablita')">Generar Excel</button>
        </td>
      </table>
  </div>

<!--4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444-->
<div id="div_4" class="contenido" class="container">
    <form method="post" action="fPDFRepo4" target="_blank" >
      <table style="margin-top: 30px; margin-left: 340px;" >
        <td>
          <select class="form-control" name="usr4" id="usr4" style="width: 200px; margin-bottom: 50px;">
            <option value="vacio">Elige Usuarios ... </option>
            <?php
            for ($i=0; $i < count($this->usrs); $i++) {?>
              <option><?php echo $this->usrs[$i]['nom_usuario'] ?></option>
            <?php } ?>
          </select>
        </td>
        <td>
          <label style='margin-left: 25px; margin-bottom: 50px;' >De: </label>
        </td>
        <td>
          <input required type="date" id="D_ini4" name="D_ini4" class="form-control" style="margin-left: 15px; margin-bottom: 50px;"></input>
        </td>
        <td>
          <label style='margin-left: 25px; margin-bottom: 50px;' >A: </label>
        </td>
        <td>
          <input required type="date" id="D_fin4" name="D_fin4" class="form-control" style="margin-left: 25px; margin-bottom: 50px;"></input>
        </td>
      </table>

      <div id="muestraDatos4" name="muestraDatos4">
        <!-- Este es el div en que se desplegara la consulta-->
      </div>

      <table style="margin-top: 30px; margin-left: 407px;" >
        <td>
          <input type="submit" value="GenerarPDF" class="botonRojo" style="width: 150px; margin-top: 10px;"></input> 
    </form>
        </td>
        <td>
          <input value="Consultar" class="botonVerde" type="button" style="width: 250px; margin-left: 10px; margin-top: 10px;"  onclick="repo4()"></input> 
        </td>
        <td>
            <button class="botonVerde" style="margin-left: 10px; margin-top: 10px; width: 150px;" onclick="exportTableToExcel('tablita')">Generar Excel</button>
        </td>
      </table>
  </div>
<!--5555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555-->
<div id="div_5" class="contenido" class="container">
    <form method="post" action="fPDFRepo5" target="_blank" >
      <table style="margin-top: 30px; margin-left: 425px;" >
        <td>
          <select class="form-control" name="tituloLibro5" id="tituloLibro5" style="width: 200px;  margin-bottom: 50px; margin-right: 20px; margin-left: 54px;">
          <option value="vacio">Elige Titulo ... </option>
          <?php
          for ($i=0; $i < count($this->titulos); $i++) {?>
            <option><?php echo $this->titulos[$i]['titulo'] ?></option>
          <?php } ?>
          </select>
        </td>

        <td>
          <select class="form-control" name="usr" id="usr" style="width: 200px; margin-bottom: 50px;">
            <option value="vacio">Elige Usuario ... </option>
            <?php
            for ($i=0; $i < count($this->usrs); $i++) {?>
              <option><?php echo $this->usrs[$i]['nom_usuario'] ?></option>
            <?php } ?>
          </select>
        </td>
      </table>

      <div id="muestraDatos5" name="muestraDatos5">
        <!-- Este es el div en que se desplegara la consulta-->
      </div>

      <table style="margin-top: 30px; margin-left: 407px;" >
        <td>
          <input type="submit" value="GenerarPDF" class="botonRojo" style="width: 150px; margin-top: 10px;"></input> 
    </form>
        </td>
        <td>
          <input value="Consultar" class="botonVerde" type="button" style="width: 250px; margin-left: 10px; margin-top: 10px;"  onclick="repo5()"></input> 
        </td>
        <td>
            <button class="botonVerde" style="margin-left: 10px; margin-top: 10px; width: 150px;" onclick="exportTableToExcel('tablita')">Generar Excel</button>
        </td>
      </table>
  </div>
<!-- 6666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666-->
  <div id="div_6" class="contenido" class="container">
    <form method="post" action="fPDFRepo6" target="_blank">
    <table style="margin-top: 30px; margin-left: 465px;" >
        <td>
          <select class="form-control" name="nomBiblio6" id="nomBiblio6" style="width: 200px; margin-bottom: 50px;">
            <option value="vacio">Elige Biblioteca ... </option>
            <?php
            for ($i=0; $i < count($this->biblios); $i++) {?>
              <option><?php echo $this->biblios[$i]['nom_biblioteca'] ?></option>
            <?php } ?>
          </select>
        </td>
        <td>
          <select class="form-control" name="mes" id="mes" style="width: 200px;  margin-bottom: 50px; margin-right: 20px; margin-left: 50px;">
            <option value="vacio">Elige Mes ... </option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select>
        </td>
      </table>
      <div id="muestraDatos6" name="muestraDatos6">
        <!-- Este es el div en que se desplegara la consulta-->
      </div>
      <table>
        <td>
            <input type="submit" value="GenerarPDF" class="botonRojo" style="width: 150px; margin-top: 10px; margin-left: 407px;"></input> 
          </form>
        </td>
        <td>
          <button class="botonVerde" type="button" style="width: 250px; margin-left: 10px; margin-top: 10px;"  onclick="repo6()">Consultar</button>
        </td>
        <td>
          <button class="botonVerde" style="margin-left: 10px; margin-top: 10px; width: 150px;" onclick="exportTableToExcel('tablita')">Generar Excel</button>
        </td>
      </table>
  </div>

<form method="post" action="pPrincipal">
      <input type="submit" value="Regresar" class="botonNaranja" style="width: 200px; margin-left: 585px; margin-top: 50px;"></input> 
</form>
</body>
</html>
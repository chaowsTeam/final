<!DOCTYPE html>
<html>

<?php
  $this->load->view('librerias');
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
<script lenguage="javascript" type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script lenguage="javascript" type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">

<script type="text/javascript">
    var registros;
    function agregaLibro(){
        var titulo = document.getElementById('titulo').value;
        var ISBN = document.getElementById('ISBN').value;
        var tema = document.getElementById('tema').value;
        var editorial = document.getElementById('editorial').value;
        //console.log(editorial);
        //console.log(libro);
       $.ajax({
        url:"http://localhost/final/index.php/ControladorPrincipal/agregaNombreLibros",
        type:"POST",
        data:{nombreLibro:titulo, isbn:ISBN, tema:tema, edit:editorial},
        success: function(respuesta){
             registros = eval(respuesta);
             alert(respuesta);

        }
    });
   }
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
      <th>Titulo</th>
      <th>ISBN</th>
      <th>Clasficación</th>
      <th>Editorial</th>
    </tr>
  </thead>

  <tbody>
        <tr>
         <td><input required type="text" id="titulo" name="titulo" class="form-control" style="width: 200px" ></td>

         <td><input required type="text" id="ISBN" name="ISBN" class="form-control" style="width: 80px" ></td>
         <td><select id="tema" class="selectpicker" data-style="btn-primary">
              <?php for ($i=0; $i < count($this->temas); $i++) {?> 
              <option value="<?php echo $this->temas[$i]['id_tema'];?>"><?php echo $this->temas[$i]['nom_tema'];?></option>
              <?php }?>           
             </select>
          </td>
         <td>
            <select id="editorial" class="selectpicker" data-style="btn-primary">
              <?php for ($i=0; $i < count($this->editoriales); $i++) {?> 
              <option value="<?php echo $this->editoriales[$i]['id_editorial'];?>" ><?php echo $this->editoriales[$i]['nom_editorial'];?></option>
              <?php } ?>           
            </select>
         </td>
        </tr>
  </tbody>
  </table>
<tr align="center">
<td>
<input type="button" class="botonVerde" value="Guardar libro" onclick="agregaLibro()" style="width: 200px; margin-left: 540px; margin-top: 25px;">
</form>
</td>
<td>
<form method= "post" action="fVCapturaLibros">
  <input type="submit" value="Regresar" class="botonNaranja" style="width: 200px; margin-left: 540px; margin-top: 25px;"></input>
</form>
</td>
</tr>

</div>
</html>

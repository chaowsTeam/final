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
    
    function agregaLibro(){
        
        var bibliotecas = document.getElementById('bibliotecas').value;
        var libros = document.getElementById('libros').value;
        console.log(bibliotecas, libros);
       $.ajax({
        url:"http://localhost/final/index.php/ControladorPrincipal/guardaLibroBiblioteca",
        type:"POST",
        data:{bibliotecas:bibliotecas,libros: libros},
        success: function(respuesta){
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
     
      <th>Biblioteca</th>
       <th>Libro</th>
    </tr>
  </thead>

  <tbody>
        <tr>
         <td><select id="bibliotecas" class="selectpicker" data-style="btn-primary">
              <?php for ($i=0; $i < count($this->bibliotecas); $i++) {?> 
              <option value="<?php echo $this->bibliotecas[$i]['id_biblioteca'];?>"><?php echo $this->bibliotecas[$i]['nom_biblioteca'];?></option>
              <?php }?>           
             </select>
          </td>
         <td>
            <select id="libros" class="selectpicker" data-style="btn-primary">
              <?php for ($i=0; $i < count($this->libros); $i++) {?> 
              <option value="<?php echo $this->libros[$i]['id_libro'];?>" ><?php echo $this->libros[$i]['titulo'];?></option>
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

$(document).on("ready", inicio);

function mostrarDatos(valor){
	$.ajax({
		url:"http://localhost/final/index.php/ControladorPrincipal/mostrar",
		type:"POST",
		data:{buscar:valor},
		success:function(respuesta){
			alert(respuesta);
		}
	})
}

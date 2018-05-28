<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body>
<div align="center">
	<h1>Bienvenido!</h1>
	<form action="fUserTipe" method="post">
		<div align="center">
		Usuario: <input type="text" required name="usr" style="margin-top: 10px; width: 150px;"><br>
		Contraseña: <input type="password" required name="psw" style="margin-top: 10px; width: 150px;"><br>
		<input type="submit" value="Ingresar"> <input type="Reset" value="Limpiar">
		</div>
	</form>
</div>
</body>
</html>

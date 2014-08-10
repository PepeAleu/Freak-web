<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Error</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta name="description" content="Aplicación web de la base de datos friki" />
	<meta name="keywords" content="friki web" />
	<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
</head>

<body background="pics/fondo2.jpg">
<?php 
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
?>

	<div class="general">
		<div class="contenido">
			<b class="tituloDetalles">
			ERROR 404
			</b>
			<div class="titulo"></div>
				<div class="detalles"> 
					<div class="fotoobjetos">
						<img src="pics/error404.png">
					</div>
					<div class = "detallestableobjetos">
					<table class="detallestableobjetos">
					<tr>
						<td class = "datos">
							<center><b>	No se ha encontrado la p&aacute;gina</b><br><br>
							 <img align = "center" width = "170px" src="pics/error4042.png"><br>
							<h6>(Te damos permiso para asesinar lentamente al webmaster o, en su defecto, quitarte la vida por el sufrimiento)</h6></center>
						</td>
					</tr>
					</table>

					</div>
				</div>
			<hr>
		</div>
	</div>
<?

?>
</body>
</html>
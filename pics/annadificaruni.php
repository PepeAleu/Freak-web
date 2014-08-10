<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Personajes</title>
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
get_header();
$id="";
$nom="";
$tip="";
$padre=null;

if(isset($_GET['id_uni'])){
$id=$_GET['id_uni'];
$nom=$_GET['nombre'];
$tip=$_GET['tipo'];
$padre=$_GET['padre'];
}
?>
	<div class="general">
		<div class="contenido">
			<b class="tituloDetalles">
			<?php
			if($padre == 0 or (isset($_POST['padre']) and $_POST['padre'] == 0))
			{ 
				echo'A&ntilde;adir Universo'; 
			}
			else if($padre = 1 or (isset($_POST['padre']) and $_POST['padre'] == 1))
			{ 
				echo'A&ntilde;adir Universo'; 
			}
			echo'<a href="univ_lista.php" style="position:absolute;left:700px;">volver</a>';
			?>
			</b>
			<div class="titulo"></div>
			<div class="detalles"> 
<?php
$idUni="";
$nombre="";
$tipo="";
if(isset($_POST['idUni'])){
	include("librerias/connect.php");
	$idUni = $_POST['idUni'];
	$nombre = $_POST['nombreUni'];
	$tipo = $_POST['tipoUni'];
	$link = conectarse();
	$sql = "SELECT * from universos WHERE id_uni = '".$idUni."' ";
	$result = mysql_query($sql,$link);
	if (mysql_num_rows($result)>0)
	{
	$sql= "UPDATE universos SET nombre = '".$nombre."',tipo = '".$tipo."' where id_uni = '".$idUni."' ";
	} else {
	$sql= "INSERT INTO universos (nombre,tipo) VALUES('".$nombre."','".$tipo."')";
	}
	
	if (!mysql_query($sql,$link))
	  {
	  die('Error: ' . mysql_error());
	  }
	if ($_POST['padre'] == 0)
		echo "<div style='position:relative;margin-top:50px;padding-bottom:50px;left:300px;'>1 universo a&ntilde;adido</div>";
	else if ($_POST['padre'] == 1)
		echo "<div style='position:relative;margin-top:50px;padding-bottom:50px;left:300px;'>1 universo modificado</div>";
	mysql_close($link);
}
?>
				
<?php
if (!isset($_POST['idUni'])){
printf('
				<table style="margin:40px 0px 0px 30px;padding-bottom:20px;">
				<form name="formAMuniversos" action="annadificaruni.php" method="POST">
					<tr>
						<td>Nombre:</td> 
						<td> <input name="nombreUni" value="'.$nom.'" type="text"></td> 
					</tr>
					<tr>
						<td>Tipo:</td> 
						<td><input name="tipoUni" value="'.$tip.'" type="text"></td>
					</tr>
					<tr>
						<td colspan=2><input type="submit"><td>
					</tr>
					<input name="idUni" type="hidden" value="'.$id.'" type="text">
					<input name="padre" type="hidden" value="'.$padre.'" type="text">
				</form>
				</table>
');
}
?>				
			</div>
		</div>
	</div>

</body>
</html>
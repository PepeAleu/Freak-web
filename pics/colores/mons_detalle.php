<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Monstruos</title>
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
$link=Conectarse();
 
$id = $_POST['id'];
$result =mysql_query("select * from monstruos where id_mon = ".$id.";");
$row = mysql_fetch_array($result);
$id_obj = $row['id_obj'];
if ($row['id_obj']==null){
	$objeto="Nada";
	$probabilidad="0";
}else{
	$result = mysql_query("Select nombre from objetos where id_obj =".$row['id_obj'].";");
	$objeto_asociado = mysql_fetch_array($result);
	$objeto = $objeto_asociado['nombre'];
	$probabilidad = $row['posibilidad'];
}
?>

	<div class="general">
		<div class="contenido">
			<b class="tituloDetalles"><?php echo $row['nombre']?> </b>
				<div class="titulo"> </div>
				
				<div class="detalles"> 
					<div class="foto">
						<img src="pics/Monstruos/Resized/JPEG/<?php echo $row['id_mon']?>.jpg">
					</div>	
					<table class="detallestable">
						<tr>
							<td>
								<b>Nombre:</b> 
							</td>
							<td class="datos">
								<?php echo $row['nombre']?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Color:</b>
							</td>
							<td class="datos">
								<img src="pics/Colores/<?php echo $row['color']?>.png">
							</td>
						</tr>
						<tr>
							<td>
								<b>Dificultad:</b>
							</td>
							<td class="datos">
								<?php 
									echo "<img src='pics/Dificultades/1Baja.png'>";
									if ($row['dificultad'] != "Baja") {
										echo "<img src='pics/Dificultades/2Media.png'>";
										if ($row['dificultad'] != "Media") {
											echo "<img src='pics/Dificultades/3Alta.png'>";
											if ($row['dificultad'] != "Alta") {
												echo "<img src='pics/Dificultades/4Extrema.gif'>";
											}
										}
									}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Tesoro:</b>
							</td>
							<td class="datos">
								<?php echo $objeto?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Posibilidad:</b>
							</td>
							<td class="datos">
								<?php echo $probabilidad;?>%
							</td>
						</tr>
					</table>
					
					<hr>	
				</div>
		</div>
	</div>
<?

?>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Universos</title>
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
$result =mysql_query("select * from objetos where id_obj = ".$id.";");
$row = mysql_fetch_array($result);
?>

	<div class="general">
		<div class="contenido">
			<b class="tituloDetalles"><?php echo $row['nombre']?> </b>
				<div class="titulo"> Objetos </div>
				
				<div class="detalles"> 
					<div class="fotoobjetos">
						<img src="pics/objetos/Resized/JPEG/<?php echo $row['id_obj']?>.jpg">
					</div>	
					<table class="detallestableobjetos">
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
								<b>Tipo:</b>
							</td>
							<td class="datos">
								<?php echo $row['tipo']?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Peso:</b>
							</td>
							<td class="datos">
								<?php echo $row['peso']?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Descripcion:</b>
							</td>
							<td class="datos">
								<?php echo $row['descripcion']?>
							</td>
						</tr>
					</table>
					
					<hr>
				</div>
				<div class="detalles">
				<h3>Personajes que participan en esta aventura </h3>
				
					<table>
						<tr>
				
							<?php
							
								$result = mysql_query("select personajes.id_per, personajes.nombre 
														from personajes, objetos, inventario 
														where objetos.id_obj = ".$id." AND
														personajes.id_per = inventario.id_per AND
														objetos.id_obj = inventario.id_obj
														group by personajes.id_per, personajes.nombre
														order by personajes.id_per, personajes.nombre ASC;");
													
								$i = 0;
								
								while($row = mysql_fetch_array($result)){
								
									$i = $i + 1;
									
									echo "<td>";
									echo "<form action=\"pers_detalle.php\" method=\"POST\">";
									echo "<input type=\"image\" class=\"miniatura\" src=\"pics/personajes/75/".$row['id_per'].".jpg\" alt=\"".$row['nombre']."\"/>";
									echo "<input type=\"Hidden\" name=\"id\" value=".$row['id_per'].">";
									echo "</form>";
									echo "</td>";
									
									if($i == 8){
									
										$i=0;
										
										echo "</tr>";
										echo "<tr>";
									
									}
								}
							
							?>
				
						</tr>
					</table>
				</div>
		</div>
	</div>
<?

?>
</body>
</html>
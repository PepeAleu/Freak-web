<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Aventuras</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta name="description" content="Aplicación web de la base de datos friki" />
	<meta name="keywords" content="friki web" />
	<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
	
	<script language="JavaScript" >
		function mostrar(capa){ 
			var ave = document.getElementById("pregunta_borrado2") 
			if(ave.style.visibility== "hidden") 
				ave.style.visibility= "visible"; 
			else 
				ave.style.visibility= "hidden"; 
			}
	</script>
</head>

<body background="pics/fondo2.jpg">
<?php 
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();
$vuelve = $_SERVER['HTTP_REFERER'];

if (isset($_POST['id'])){
$id = $_POST['id'];
}else{
   header('Location: http://www.saphire-universe.com/2DAI/error404.php' ) ;
}
 
$id = $_POST['id'];
$result =mysql_query("Select aventuras.id_ave, aventuras.id_esc, aventuras.nombre, aventuras.descripcion, aventuras.id_obj, aventuras.cantidad, objetos.nombre as ob_nom from aventuras, objetos where aventuras.id_ave =".$id." and aventuras.id_obj = objetos.id_obj;");
/*$result =mysql_query("select * from aventuras where id_ave = ".$id.";");*/
$row = mysql_fetch_array($result);
$id_objeto = $row['id_obj'];
$nom_objeto = $row['ob_nom'];
	$result2 = mysql_query("Select nombre from escenarios where id_esc =".$row['id_esc'].";");
	$escenario_asociado = mysql_fetch_array($result2);

$consul = mysql_query("select id_ave from aventuras order by id_ave asc limit 1;");
$primero = mysql_fetch_array($consul);

$consul = mysql_query("select id_ave from aventuras order by id_ave desc limit 1;");
$ultimo = mysql_fetch_array($consul);

	
if ($row['id_obj']==null){
	$objeto="Nada";
	$cantidad="0";
	}
	
else{
	$result = mysql_query("Select nombre from objetos where id_obj =".$row['id_obj'].";");
	$objeto_asociado = mysql_fetch_array($result);
	$objeto = $objeto_asociado['nombre'];
	$cantidad = $row['cantidad'];
}

	

?>

	<div class="general">
	
		<div class="ant">
		<?php if ($row['id_ave'] > $primero['id_ave'])	{
				$consul = mysql_query("select id_esc, id_ave from aventuras where id_ave < ". $row['id_ave'] ." order by id_ave desc limit 1");
				$ant = mysql_fetch_array($consul); 
				?>
							
				<form name="enlace1" method="POST" action="aven_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" type="image" src="pics/escenarios/<?php echo $ant['id_esc']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $ant['id_ave']?>"/>
				</form>
				<?php
			}
		?>
		</div>
		<div class="sig">
		<?php
		if ($row['id_ave'] < $ultimo['id_ave']){

				$consul2 = mysql_query("select id_esc, id_ave from aventuras where id_ave >  ". $row['id_ave'] ." order by id_ave asc limit 1");
				$sig = mysql_fetch_array($consul2);
				?>
				<form name="enlace2" method="POST" action="aven_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" type="image" src="pics/escenarios/<?php echo $sig['id_esc']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $sig['id_ave']?>"/>
				</form>
				<?php
			}
			?>
		</div>
	
		<div class="contenido">
		
			<b class="tituloDetalles"><?php echo $row['nombre']?> </b>
			<div class="pregunta_borrado" id="pregunta_borrado2" style="visibility:hidden;">
					<br>
					<center><b>&iquest;Estas seguro?</b></center>
					<br><br>
					<FORM method="POST" align="center" action="aven_lista.php">
						<center><INPUT TYPE="submit" value="Aceptar">
						<INPUT TYPE="text" name="id_aveb" value="<?php echo $row['id_ave'] ?>" style="visibility:hidden;position:absolute;left:0;">
						<INPUT TYPE="Reset" value="Cancelar" onClick="mostrar();"></center>
					</FORM>
				</div>
			
				<div class="botoncitos">
					<a href="#" onClick="mostrar();"><img src="pics/borrar.gif" style="float:right; margin-top:-10px; margin-right:10px;"></a>
					<form name="enlace4" method="POST" style="float:right; margin-top:-10px; margin-right:10px;" action="aven_anyadificar.php">
						<input type="image" src="pics/modificar.png" />
						<input type="hidden" name="id" value="<?php echo $row['id_ave']?>"/>
					</form>
					
								<a href='aven_lista.php'><img src='pics/volver.png' style='position:absolute;right:45px;margin:15px 15px 30px 0px;'></a>
				</div>
			<div class="titulo">
			</div>
			
			<div class="detalles"> 
			
				<div class="foto3">
				
					<img onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" src="pics/escenarios/<?php echo $row['id_esc']?>.jpg">
					
				</div>
					
				<?php 
					if($row['id_obj']!= null){
						echo 		"<form action=\"obje_detalle.php\" method=\"POST\">";
						echo 		"<input onerror=\"this.onerror=null;this.src='pics/monstruos/0.jpg';\" type=\"image\" class=\"miniatura2\" title=\"".$nom_objeto."\" src=\"pics/objetos/".$id_objeto.".jpg\" alt=\"\" \"/>";
						echo 		"<input type=\"Hidden\" name=\"id\" value=".$row['id_obj'].">";
						echo 		"</form>";	
					}
				?>	
					
				<table class="detallestable2">
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
							<b>Escenario:</b>
						</td>
						<td class="datos">
							<?php echo $escenario_asociado['nombre']?>
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
							<b>Cantidad:</b>
						</td>
						<td class="datos">
							<?php echo $cantidad?>
						</td>
					</tr>
				</table>
				
			</div>
			
			<hr>
			
			<?php
						$result = mysql_query("select count(*) as cantidad from bitacora where id_ave = ".$id);
						$cont = mysql_fetch_array($result);
						$result2 = mysql_query("select count(*) as cantidad from duelo where id_ave = ".$id);
						$cont2 = mysql_fetch_array($result2);
						if ($cont['cantidad'] != 0 OR $cont2['cantidad'] != 0) {
					?>
			<div class="detalles">
				<h3>Personajes que participan en esta aventura </h3>
				
					<table>
						<tr>
				
							<?php
							
								$result = mysql_query("SELECT personajes.id_per, personajes.nombre
													   FROM personajes, bitacora, duelo, aventuras
													   WHERE aventuras.id_ave = ".$id."
													   AND ((bitacora.id_ave = aventuras.id_ave AND personajes.id_per = bitacora.id_per)
													   OR (aventuras.id_ave = duelo.id_ave
													   AND (personajes.id_per = duelo.id_per1 OR personajes.id_per = duelo.id_per2)))
													   GROUP BY personajes.id_per, personajes.nombre
													   ORDER BY personajes.id_per, personajes.nombre ASC;;");
													
								$i = 0;
								
								while($row = mysql_fetch_array($result)){
								
									$i = $i + 1;
									
									echo "<td>";
									echo "<form action=\"pers_detalle.php\" method=\"POST\">";
									echo "<input type=\"image\" class=\"miniatura\" src=\"pics/personajes/".$row['id_per'].".jpg\" title=\"".$row['nombre']."\"/>";
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
			<?php
						}
				?>
			<hr>
				<?php
						if ($cont['cantidad'] != 0) {
					?>
			<div class="detalles">
				<h3>Monstruos que aparecen en esta aventura </h3>
				
					<table>
						<tr>
				
							<?php
							
								$result = mysql_query("select monstruos.id_mon, monstruos.nombre 
														from monstruos, aventuras, bitacora 
														where aventuras.id_ave = ".$id." AND
														monstruos.id_mon = bitacora.id_mon AND
														aventuras.id_ave = bitacora.id_ave
														group by monstruos.id_mon, monstruos.nombre
														order by monstruos.id_mon, monstruos.nombre ASC;");
													
								$i = 0;
								
								while($row = mysql_fetch_array($result)){
								
									$i = $i + 1;
									
									echo "<td>";
									echo "<form action=\"mons_detalle.php\" method=\"POST\">";
									echo "<input onerror=\"this.onerror=null;this.src='pics/monstruos/0.jpg';\" type=\"image\" class=\"miniatura\" src=\"pics/monstruos/".$row['id_mon'].".jpg\" title=\"".$row['nombre']."\"/>";
									echo "<input type=\"Hidden\" name=\"id\" value=".$row['id_mon'].">";
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
				<?php
						}
				?>
		</div>	
		
	</div>		
		
<?

?>
</body>
</html>
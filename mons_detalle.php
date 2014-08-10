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
	
	<script language="JavaScript" >
		function mostrar(capa){ 
			var obj = document.getElementById("pregunta_borrado2") 
			if(obj.style.visibility== "hidden") 
				obj.style.visibility= "visible"; 
			else 
				obj.style.visibility= "hidden"; 
			}
	</script>
</head>

<body background="pics/fondo2.jpg">
<?php 
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();
if (isset($_POST['id'])){
$id = $_POST['id'];
}else{
   header('Location: http://www.saphire-universe.com/2DAI/error404.php' ) ;
}
 
$id = $_POST['id'];
$result =mysql_query("select * from monstruos where id_mon = ".$id.";");
$row = mysql_fetch_array($result);

$consul = mysql_query("select id_mon from monstruos order by id_mon asc limit 1;");
$primero = mysql_fetch_array($consul);

$consul = mysql_query("select id_mon from monstruos order by id_mon desc limit 1;");
$ultimo = mysql_fetch_array($consul);

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
	<div class="ant">
		<?php if ($row['id_mon'] > $primero['id_mon'])	{
				$consul = mysql_query("select id_mon from monstruos where id_mon < ". $row['id_mon'] ." order by id_mon desc limit 1");
				$ant = mysql_fetch_array($consul); 
				?>
							
				<form name="enlace1" method="POST" action="mons_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/monstruos/0.jpg';" type="image" src="pics/monstruos/<?php echo $ant['id_mon']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $ant['id_mon']?>"/>
				</form>
				<?php
			}
		?>
		</div>
		<div class="sig">
		<?php
		if ($row['id_mon'] < $ultimo['id_mon']){

				$consul2 = mysql_query("select id_mon from monstruos where id_mon >  ". $row['id_mon'] ." order by id_mon asc limit 1");
				$sig = mysql_fetch_array($consul2);
				?>
				<form name="enlace2" method="POST" action="mons_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/monstruos/0.jpg';" type="image" src="pics/monstruos/<?php echo $sig['id_mon']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $sig['id_mon']?>"/>
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
					<FORM method="POST" align="center" action="mons_lista.php">
						<center><INPUT TYPE="submit" value="Aceptar">
						<INPUT TYPE="text" name="id_monb" value="<?php echo $row['id_mon'] ?>" style="visibility:hidden;position:absolute;left:0;">
						<INPUT TYPE="Reset" value="Cancelar" onClick="mostrar();"></center>
					</FORM>
				</div>
			
				<div class="botoncitos">
					<a href="#" onClick="mostrar();"><img src="pics/borrar.gif" style="float:right; margin-top:-10px; margin-right:10px;"></a>
					<form name="enlace4" method="POST" style="float:right; margin-top:-10px; margin-right:10px;" action="mons_anyadificar.php">
						<input type="image" src="pics/modificar.png" />
						<input type="hidden" name="id" value="<?php echo $row['id_mon']?>"/>
					</form>
					<a href='mons_lista.php'><img src='pics/volver.png' style='float:right; margin-top:-10px; margin-right:10px;'></a>
				</div>
				
				<div class="titulo"></div>
				<div class="detalles"> 
					<div class="fotoobjetos">
						<img src="pics/monstruos/<?php echo $row['id_mon']?>.jpg">
					</div>
					<div style="clear:both;"></div>					
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
								<b>Color:</b>
							</td>
							<td class="datos">
								<img src="pics/colores/<?php echo $row['color']?>.png">
							</td>
						</tr>
						<tr>
							<td>
								<b>Dificultad:</b>
							</td>
							<td class="datos">
								<?php 
									if ($row['dificultad'] == "Baja") {
										echo "<img title = 'Baja' src='pics/dificultades/Baja.png'>";
										}
									if ($row['dificultad'] == "Media"){
										echo "<img title = 'Media' src='pics/dificultades/Media.png'>";
									}	
									if ($row['dificultad'] == "Alta"){
										echo "<img title = 'Alta' src='pics/dificultades/Alta.png'>";
									}	
									if ($row['dificultad'] == "Extrema"){
										echo "<img title = 'Extrema' src='pics/dificultades/Extrema.png'>";
									
									}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Tesoro:</b>
							</td>
							<td class="datos">
								<?php 
									If ($objeto == "Nada"){
									echo "<img width = '20' src = 'pics/escenarios/x.png'>";
									}
									else{
									echo $objeto;
									}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Posibilidad:</b>
							</td>
							<td class="datos">
								<?php 
									If ($probabilidad == "0"){
									echo "-";
									}
									else{
									echo $probabilidad."%";
									}
								?>

							</td>
						</tr>
					</table>
						<div style="clear:both;"></div>

					<hr>
				</div>



					<?php
					if ($objeto != "Nada"){
					?>
				<div class="detalles">
					<h3>Objeto</h3>
					<?php
						$result2 = mysql_query("select nombre from objetos where id_obj = ".$row['id_obj']);
						$row2 = mysql_fetch_array($result2);
						?>
						
					<form name="enlace" method="POST" action="obje_detalle.php">
						<input title = "<?php echo $row2['nombre'] ?>" class = "miniatura" type="image" height = "80px" width = "80px" src="pics/objetos/<?php echo $row['id_obj']?>.jpg" />
						<input type="hidden" name="id" value="<?php echo $row['id_obj']?>"/>
					</form>
					<hr>
				</div>
					<?php
					}?>

					<?php
						$result = mysql_query("select count(*) as cantidad from bitacora where id_mon = ".$id);
						$cont = mysql_fetch_array($result);
						if ($cont['cantidad'] != 0) {
					?>
				<div class="detalles">
					<h3>Aventuras</h3>
						<table>
						<tr>
							<?php
								$result = mysql_query("select aventuras.id_ave, aventuras.nombre, aventuras.id_esc 
														from monstruos, aventuras, bitacora 
														where monstruos.id_mon = ".$id." AND
														monstruos.id_mon = bitacora.id_mon AND
														aventuras.id_ave = bitacora.id_ave
														group by aventuras.id_ave, aventuras.nombre
														order by aventuras.id_ave, aventuras.nombre ASC;");
								$i = 0;
								while($row = mysql_fetch_array($result)){
									$i = $i + 1;
									echo "<td>";
									echo "<form action=\"aven_detalle.php\" method=\"POST\">";
									echo "<input onerror=\"this.onerror=null;this.src='pics/escenarios/00.jpg';\" type=\"image\" class=\"miniatura\" src=\"pics/escenarios/".$row['id_esc'].".jpg\" title=\"".$row['nombre']."\"/>";
									echo "<input type=\"Hidden\" name=\"id\" value=".$row['id_ave'].">";
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
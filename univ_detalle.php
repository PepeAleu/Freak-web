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
$result =mysql_query("select * from universos where id_uni = ".$id.";");
$row = mysql_fetch_array($result);
$id_uni = $row['id_uni'];


$consul = mysql_query("select id_uni from universos order by id_uni asc limit 1;");
$primero = mysql_fetch_array($consul);

$consul = mysql_query("select id_uni from universos order by id_uni desc limit 1;");
$ultimo = mysql_fetch_array($consul);


?>
<div class="general">
	<div class="ant">
		<?php if ($row['id_uni'] > $primero['id_uni'])	{
				$consul = mysql_query("select id_uni from universos where id_uni < ". $row['id_uni'] ." order by id_uni desc limit 1");
				$ant = mysql_fetch_array($consul); 
				?>
							
				<form name="enlace1" method="POST" action="univ_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" type="image" src="pics/universos/<?php echo $ant['id_uni']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $ant['id_uni']?>"/>
				</form>
				<?php
			}
		?>
		</div>
		<div class="sig">
		<?php
		if ($row['id_uni'] < $ultimo['id_uni']){

				$consul2 = mysql_query("select id_uni from universos where id_uni >  ". $row['id_uni'] ." order by id_uni asc limit 1");
				$sig = mysql_fetch_array($consul2);
				?>
				<form name="enlace2" method="POST" action="univ_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" type="image" src="pics/universos/<?php echo $sig['id_uni']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $sig['id_uni']?>"/>
				</form>
				<?php
			}
			?>
		</div>
	
		<div class="contenido">
			<b class="tituloDetalles"><?php echo $row['nombre']?></b>
			<div class="pregunta_borrado" id="pregunta_borrado2" style="visibility:hidden;">
				<br>
				<center><b>&iquest;Est&aacute;s seguro?</b></center>
				<br><br>
				<FORM method="POST" align="center" action="univ_lista.php">
					<center><INPUT TYPE="submit" value="Aceptar">
					<INPUT TYPE="text" name="id_unib" value="<?php echo $row['id_uni'] ?>" style="visibility:hidden;position:absolute;left:0;">
					<INPUT TYPE="Reset" value="Cancelar" onClick="mostrar();"></center>
				</FORM>
			</div>
			<a href="#" onClick="mostrar();"><img src="pics/borrar.gif" style="float:right;margin:15px 15px 0px 0px;"></a>
			<?php
			echo'<a href="annadificaruni.php?id_uni='.$row['id_uni'].'&nombre='.$row['nombre'].'&tipo='.$row['tipo'].'&padre=1" ><img src="pics/modificar.png" style="float:right;margin:15px 15px 0px 0px;"></a>';
			?>
				<div class="titulo"></div>
				
				<div class="detalles"> 
					<div class="fotoobjetos">
						<img onerror="this.onerror=null;this.src='pics/universos/0.jpg';" src="pics/universos/<?php echo $row['id_uni']?>.jpg">
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

								<?php 
								$unitip = $row['tipo'];
								if ($unitip == "Televisi&oacute;n") {
									$unitip = "Television";
									}
								echo "<img width = '50px' title=".$unitip." src = pics/tipouni/".$unitip.".png>"; 
								
								?>
							</td>
						</tr>
					</table>
				</div>
				<hr>
				<?php
					$result = mysql_query("select count(*) as cantidad from personajes where id_uni = ".$id);
					$cont = mysql_fetch_array($result);
					if ($cont['cantidad'] != 0) {
				?>

				<div class = "detalles">
				
					<h3>Personajes de este universo </h3>
				
					<table>
						<tr>
				
							<?php
							
								$result = mysql_query("select id_per, nombre, alias, apellidos 
														from personajes 
														where id_uni = ".$row['id_uni']."
														group by id_per, nombre
														order by id_per, nombre ASC;");
													
								$i = 0;
								
								while($row = mysql_fetch_array($result)){
								
									$i = $i + 1;
									
									echo "<td>";
									echo "<form action=\"pers_detalle.php\" method=\"POST\">";
									echo "<input type=\"image\" class=\"miniatura\" src=\"pics/personajes/".$row['id_per'].".jpg\" title=\"".$row['nombre']." ".$row['alias']." ".$row['apellidos']."\"/>";
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

				<hr>
				</div>
					<?php
						}
				?>				
				</div>
		</div>
	</div>
<?

?>
</body>
</html>
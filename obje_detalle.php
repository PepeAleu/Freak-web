<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Objetos</title>
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
$result =mysql_query("select * from objetos where id_obj = ".$id.";");
$row = mysql_fetch_array($result);
$peso = $row['peso'];

$consul = mysql_query("select id_obj from objetos order by id_obj asc limit 1;");
$primero = mysql_fetch_array($consul);

$consul = mysql_query("select id_obj from objetos order by id_obj desc limit 1;");
$ultimo = mysql_fetch_array($consul);


?>

	<div class="general">
	
	<div class="ant">
		<?php if ($row['id_obj'] > $primero['id_obj'])	{
				$consul = mysql_query("select id_obj from objetos where id_obj < ". $row['id_obj'] ." order by id_obj desc limit 1");
				$ant = mysql_fetch_array($consul); 
				?>
							
				<form name="enlace1" method="POST" action="obje_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/objetos/0.jpg';" type="image" src="pics/objetos/<?php echo $ant['id_obj']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $ant['id_obj']?>"/>
				</form>
				<?php
			}
		?>
		</div>
		<div class="sig">
		<?php
		if ($row['id_obj'] < $ultimo['id_obj']){

				
				$consul2 = mysql_query("select id_obj from objetos where id_obj >  ". $row['id_obj'] ." order by id_obj asc limit 1");
				$sig = mysql_fetch_array($consul2);
				?>
				<form name="enlace1" method="POST" action="obje_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/objetos/0.jpg';" type="image" src="pics/objetos/<?php echo $sig['id_obj']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $sig['id_obj']?>"/>
				</form>
				<?php
			}
			?>
		</div>
	
		<div class="contenido">
			<b class="tituloDetalles"><?php echo $row['nombre']?> </b>
				<div class="pregunta_borrado" id="pregunta_borrado2" style="visibility:hidden;">
				<br>
				<center><b>&iquest;Est&aacute;s seguro?</b></center>
				<br><br>
				<FORM method="POST" align="center" action="obje_lista.php">
					<center><INPUT TYPE="submit" value="Aceptar">
					<INPUT TYPE="text" name="id_objb" value="<?php echo $row['id_obj'] ?>" style="visibility:hidden;position:absolute;left:0;">
					<INPUT TYPE="Reset" value="Cancelar" onClick="mostrar();"></center>
				</FORM>
			</div>
			<a href="#" onClick="mostrar();"><img src="pics/borrar.gif" style="float:right;margin:15px 15px 0px 0px;"></a>
			<form name="enlace4" method="POST" style="float:right;margin:15px 15px 0px 0px;" action="obje_anyadificar.php">
				<input type="image" src="pics/modificar.png" />
				<input type="hidden" name="id" value="<?php echo $row['id_obj']?>"/>
			</form>
		<div style="clear:both;"></div>
				<div class="titulo"> Objetos </div>
				
				<div class="detalles"> 
					<div class="fotoobjetos">
						<img onerror="this.onerror=null;this.src='pics/objetos/0.jpg';" src="pics/objetos/<?php echo $row['id_obj']?>.jpg">
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
								<?php echo "<img align = 'middle' title = '".$row['tipo']."' width = '50px' src = 'pics/tipoobj/".$row['tipo'].".png'>"?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Peso:</b>
							</td>
							<td class="datos">
								<?php 
								while($peso > 0)
								{
									
									if ($peso == 1000)
									{
										
										echo "<div class='peso'> <img  src ='pics/PesoM.png' border = 0></div>";
										$peso = $peso - 1000;
										
									}
									
									else if ($peso >= 500)
									{
										echo "<div class='peso'> <img ' src ='pics/PesoD.png' border = 0></div>";
										$peso = $peso - 500;

									}
									
									else if ($peso >= 100)
									{
										echo "<div class='peso'> <img  src ='pics/PesoC.png' border = 0></div>";
										$peso = $peso - 100;

									}
									
									else if ($peso >= 50)
									{
										echo "<div class='peso'> <img  src ='pics/PesoL.png' border = 0></div>";
										$peso = $peso - 50;

									}
									
									else if ($peso >= 10)
									{
										echo "<div class='peso'> <img  src ='pics/PesoX.png' border = 0></div>";
										$peso = $peso - 10;

									}
									
									else if ($peso >= 5)
									{
										echo "<div class='peso'> <img  src ='pics/PesoV.png' border = 0></div>";
										$peso = $peso - 5;

									}
									
									else if ($peso >= 1)
									{
										echo "<div class='peso'> <img  src ='pics/PesoI.png' border = 0></div>";
										$peso = $peso - 1;

									}
									
								}	

									?>
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
				<div style="clear:both;"></div>

				<?php
						$result = mysql_query("select count(*) as cantidad from inventario where id_obj = ".$id);
						$cont = mysql_fetch_array($result);
						if ($cont['cantidad'] != 0) {
					?>
				<div class="detalles">
				<h3>Personajes que llevan este objeto </h3>
				
					<table>
						<tr>
				
							<?php
							
								$result = mysql_query("select personajes.id_per, personajes.nombre, personajes.alias, personajes.apellidos 
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
									echo "<input onerror=\"this.onerror=null;this.src='pics/personajes/0.jpg';\" width =\"50px\" type=\"image\" class=\"miniatura\" src=\"pics/personajes/".$row['id_per'].".jpg\" title=\"".$row['nombre']." ".$row['alias']." ".$row['apellidos']."\"/>";
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

					<?php
						$result = mysql_query("select count(*) as cantidad from monstruos where id_obj = ".$id);
						$cont = mysql_fetch_array($result);
						if ($cont['cantidad'] != 0) {
					?>
				<div class="detalles">
				<h3>Monstruos que llevan este objeto </h3>
				
					<table>
						<tr>
				
							<?php
							
								$result = mysql_query("select monstruos.id_mon, monstruos.nombre 
														from monstruos, objetos 
														where objetos.id_obj = ".$id." AND
														monstruos.id_obj = objetos.id_obj
														group by monstruos.id_obj, monstruos.nombre
														order by monstruos.id_obj, monstruos.nombre ASC;");
													
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
				<hr>
				</div>
					<?php
						}
				?>
				<?php
						$result = mysql_query("select count(*) as cantidad from aventuras where id_obj = ".$id);
						$cont = mysql_fetch_array($result);
						if ($cont['cantidad'] != 0) {
					?>

				<div class="detalles">
				<h3>Aventuras en las que est&aacute; este objeto </h3>
				
					<table>
						<tr>
				
							<?php
							
								$result = mysql_query("select escenarios.id_esc, aventuras.id_ave, escenarios.nombre, aventuras.nombre 
														from aventuras, objetos, escenarios 
														where objetos.id_obj = ".$id." AND
														aventuras.id_obj = objetos.id_obj AND
														escenarios.id_esc = aventuras.id_esc
														group by escenarios.id_esc, aventuras.id_ave, escenarios.nombre
														order by escenarios.id_esc, escenarios.nombre ASC;");
													
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
				<hr>
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
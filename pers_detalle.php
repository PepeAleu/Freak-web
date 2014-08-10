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

$result =mysql_query("select * from personajes where id_per = ".$id.";");
/*$id="";*/
$row = mysql_fetch_array($result);
$id_uni = $row['id_uni'];

$consul = mysql_query("select id_per from personajes order by id_per asc limit 1;");
$primero = mysql_fetch_array($consul);

$consul = mysql_query("select id_per from personajes order by id_per desc limit 1;");
$ultimo = mysql_fetch_array($consul);

?>

	<div class="general">
		<div class="ant">
		<?php if ($row['id_per'] > $primero['id_per'])	{
				$consul = mysql_query("select id_per from personajes where id_per < ". $row['id_per'] ." order by id_per desc limit 1");
				$ant = mysql_fetch_array($consul); 
				?>
							
				<form name="enlace1" method="POST" action="pers_detalle.php">
				<input width = "300px" height = "300px"  onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" type="image" src="pics/personajes/<?php echo $ant['id_per']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $ant['id_per']?>"/>
				</form>
				<?php
			}
		?>
		</div>
		<div class="sig">
		<?php
		if ($row['id_per'] < $ultimo['id_per']){

				$consul2 = mysql_query("select id_per from personajes where id_per >  ". $row['id_per'] ." order by id_per asc limit 1");
				$sig = mysql_fetch_array($consul2);
				?>
				<form name="enlace2" method="POST" action="pers_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" type="image" src="pics/personajes/<?php echo $sig['id_per']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $sig['id_per']?>"/>
				</form>
				<?php
			}
			?>
		</div>
		<div class="contenido">
			<b class="tituloDetalles">
			<?php echo $row['nombre']." ";
			if($row['alias']!= null)
			{
				echo "\"".$row['alias']."\" ";
			}
				echo "".$row['apellidos'];
			?></b>
			<div class="pregunta_borrado" id="pregunta_borrado2" style="visibility:hidden;">
				<br>
				<center><b>&iquest;Est&aacute;s seguro?</b></center>
				<br><br>
				<FORM method="POST" align="center" action="pers_lista.php">
					<center><INPUT TYPE="submit" value="Aceptar">
					<INPUT TYPE="text" name="id_perb" value="<?php echo $row['id_per'] ?>" style="visibility:hidden;position:absolute;left:0;">
					<INPUT TYPE="Reset" value="Cancelar" onClick="mostrar();"></center>
				</FORM>
			</div>
			<a href="#" onClick="mostrar();"><img src="pics/borrar.gif" style="float:right;margin:15px 15px 0px 0px;"></a>
			<form name="enlace4" method="POST" style="float:right;margin:15px 15px 0px 0px;" action="pers_anyadificar.php">
				<input type="image" src="pics/modificar.png" />
				<input type="hidden" name="id" value="<?php echo $row['id_per']?>"/>
			</form>
			<div style="clear:both;"></div>
			<div class="titulo"></div>
			<div class="detalles"> 
				<div class="fotoobjetos">
					<img onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" src="pics/personajes/<?php echo $row['id_per']?>.jpg">
				</div>	
				<div class="statsdetalle">
					<img style="border: 0px;" src='pics/heart.png'><?php echo ($row['fuerza']*10+$row['agilidad']*7+$row['inteligencia']*3); ?>
					<img style="border: 0px;" src='pics/armor2.png'><?php echo ($row['fuerza']*3+$row['agilidad']*10+$row['inteligencia']*7); ?>
					<img style="border: 0px;" src='pics/mana.png'><?php echo ($row['fuerza']*7+$row['agilidad']*3+$row['inteligencia']*10); ?>
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
							<b>Alias:</b>
						</td>
						<td class="datos">
							<?php echo $row['alias']?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Apellidos:</b>
						</td>
						<td class="datos">
							<?php echo $row['apellidos']?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Raza:</b> 
						</td>
						<td class="datos">
							<?php echo $row['raza']?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Clase:</b> 
						</td>
						<td class="datos">
							<?php echo $row['clase']?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Alineamiento:</b> 
						</td>
						<td class="datos">
							<?php 
							if ($row['alineamiento']=='Malvado'){
							echo "<img src='pics/Malo.png'>";
							}
							elseif ($row['alineamiento']=='Neutral'){
							echo "<img src='pics/Neutral.png'>";
							}
							else{
							echo "<img src='pics/Bueno.png'>";
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Fecha de <br>nacimiento:</b> 
						</td>
						<td class="datos">
							<?php echo fecha($row['fecnac']);?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Sexo:</b> 
						</td>
						<td class="datos">
							<?php 
							if ($row['sexo']=='Masculino'){
							echo "<img src='pics/Hombre.png'>";
							}
							elseif ($row['sexo']=='Asexuado'){
							echo "<img src='pics/Neutro.png'>";
							}
							else{
							echo "<img src='pics/Mujer.png'>";
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Fuerza:</b>
						</td>
						<td class="datos"><?php mostrar_stat("fuerza", $row['fuerza']); ?></td>
					</tr>
					<tr>
						<td>
							<b>Agilidad:</b> 
						</td>
						<td class="datos"><?php mostrar_stat("agilidad", $row['agilidad']); ?></td>
					</tr>
					<tr>
						<td>
							<b>Inteligencia:</b> 
						</td>
						<td class="datos"><?php mostrar_stat("inteligencia", $row['inteligencia']); ?></td>
					</tr>
				</table>
			</div>
			<hr>
			<div class="detalles">
				<h2>Universo</h2>
				<?php
					$universo =mysql_query("select * from universos where id_uni = ".$id_uni.";");
					$rowniverso = mysql_fetch_array($universo);
					$uninom = $rowniverso['nombre'];
					$unitip = $rowniverso['tipo'];
					if ($unitip == "Televisi&oacute;n") {
						$unitip = "Television";
					}
					
				?>
				<table>
					<tbody>
					<tr>
						<td><?php echo "<img class = 'unipersonaje' width = '30px' title=".$unitip." src = pics/tipouni/".$unitip.".png>"; ?></td>
						<td>
							<form name="enlace" method="POST" action="univ_detalle.php">
								<input class="miniatura" type="image" title="<?php echo $uninom ?>" src="pics/universos/<?php echo $rowniverso['id_uni']?>.jpg" />
								<input type="hidden" name="id" value="<?php echo $id_uni?>"/>
							</form>
						</td>
					</tr>
					</tbody>
				</table>
				<?php $personajes = mysql_query("select * from personajes where id_uni = ".$id_uni.";");
				$lal = mysql_num_rows($personajes);
				if ($lal > 1) {?>
				<h3>Otros personajes de este universo</h3>
				<span>
					<?php
						$count = 0;
						while ( ($rowsonaje = mysql_fetch_array($personajes)) && ($count < 9) )
						{
							if ($rowsonaje['id_per'] != $id) {?>
								<form name="enlace" method="POST" action="pers_detalle.php">
								<input title="<?php echo $rowsonaje['nombre'];
									if($rowsonaje['alias']!= null)
									{
										echo " ''".$rowsonaje['alias']."''";
									}
									echo " ".$rowsonaje['apellidos'];
								?>" style = "float: left;" class="miniatura" type="image" src="pics/personajes/<?php echo $rowsonaje['id_per']?>.jpg" />
								<input type="hidden" name="id" value="<?php echo $rowsonaje['id_per']?>"/>
								</form>
						<?php $count++; } } ?>
				</span>
				<div style="clear:both;"></div>
				<hr>
				<?php }?>
			</div>
			<?php $inventario = mysql_query("select inventario.id_obj as id_obj, inventario.cantidad as cantidad, objetos.nombre as nombre from inventario, objetos where objetos.id_obj = inventario.id_obj AND inventario.id_per = ".$id.";");
			$lol = mysql_num_rows($inventario);
			if ($lol > 0) {?>
			<div class="detalles"> 
				<h2>Objetos</h2>
					<span>
					<?php
					$count = 0;
					while ($rowventario = mysql_fetch_array($inventario) )
					{
						if  ($count == 9)
						{
							echo "</tr><tr>";
							$count = 0;
						}
						?>
						<form name="enlace" method="POST" action="obje_detalle.php">
							<input title="<?php echo $rowventario['nombre']?>" style = "float: left;" class="miniatura" type="image" src="pics/objetos/<?php echo $rowventario['id_obj']?>.jpg" />
							<input type="hidden" name="id" value="<?php echo $rowventario['id_obj']?>"/>
							<label for="cantidad" style="position: absolute; margin-left:-75px; margin-top:3px;"><?php echo $rowventario['cantidad'];?></label>
						</form>
					<?php $count++; } ?>
					</span>
				<div style="clear:both;"></div>
				<hr>
			</div>
			<?php }
			$aventuras = mysql_query("Select aventuras.id_ave as id_ave, aventuras.id_esc AS id_esc, aventuras.nombre as nombre, bitacora.fecha as fecha, bitacora.modo AS modo, bitacora.id_mon as id_mon from bitacora, aventuras where aventuras.id_ave = bitacora.id_ave and bitacora.id_per= ".$id.";");
			$numBit = mysql_num_rows($aventuras);
			if ($numBit <> 0) {
			?>
				<div class="detalles"> 
				<h2>Aventuras</h2>
					<span>
						<?php $count = 0;
							while ($rowventuras = mysql_fetch_array($aventuras))
							{
								if ($count == 9){
									echo "</tr>";
									echo "<tr>";
								}
								$count++;
								?>
						<form name="enlace" method="POST" action="aven_detalle.php">
							<input title="<?php echo $rowventuras['nombre']." fue un ".strtolower($rowventuras['modo'])." el d&iacute;a ".fecha($rowventuras['fecha']) ;?>"
							<input title="<?php echo $rowventuras['nombre']." fue un ".strtolower($rowventuras['modo'])." el d&iacute;a ".fecha($rowventuras['fecha']) ;?>"
							style = "float: left;" class="miniatura" type="image" src="pics/escenarios/<?php echo $rowventuras['id_esc']; ?>.jpg"
							onmouseover="this.src ='pics/monstruos/<?php echo $rowventuras['id_mon'];?>.jpg'" onmouseout="this.src ='pics/escenarios/<?php echo $rowventuras['id_esc']; ?>.jpg'"/>
							<input type="hidden" name="id" value="<?php echo $rowventuras['id_ave']?>"/>
						</form>
					<?php $count++; } ?>
					</span>
				<div style="clear:both;"></div>
				<hr>
			</div>
		<?php }
		$duelo = mysql_query("select aventuras.id_obj, aventuras.nombre as nombre, duelo.id_ave as id_ave, duelo.id_per1 as id_per1, duelo.id_per2 as id_per2, duelo.fecha as fecha, duelo.modo as modo from duelo, aventuras where (id_per1 = ".$id." OR id_per2 = ".$id.") and duelo.id_ave = aventuras.id_ave");
		$lol = mysql_num_rows($duelo);
		if ($lol <> 0) {		?>
				<div class="detalles"> 
				<h2>Duelos</h2>
					<span>
						<?php $count = 0;
						while ($rowelos = mysql_fetch_array($duelo))
						{
							if ($count == 9){
								echo "</tr>";
								echo "<tr>";
							}
							$count++;
							?>
							<?php if ($id==$rowelos['id_per1']) { ?>
								<form name="enlace" method="POST" action="duel_detalle.php">
									<input class="miniatura" style="float: left; border-color:
								    <?php if ($rowelos['modo'] == "Victoria1") echo "blue";
									if ($rowelos['modo'] == "Empate") echo "orange"; 
									if ($rowelos['modo'] == "Victoria2") echo "red"; ?>;"
									onmouseover = "this.src ='pics/objetos/<?php echo $rowelos['id_obj'];?>.jpg'"
									onmouseout = "this.src ='pics/personajes/<?php echo $rowelos['id_per2'];?>.jpg'"
									type="image" src="pics/personajes/<?php echo $rowelos['id_per2']?>.jpg"
									title = "El personaje <?php if ($rowelos['modo'] == "Victoria1") echo " gan&oacute; este duelo";
									if ($rowelos['modo'] == "Empate") echo " empat&oacute; este duelo"; 
									if ($rowelos['modo'] == "Victoria2") echo " perdi&oacute; este duelo"?>"/>
									<input type="hidden" name="idave" value="<?php echo $rowelos['id_ave']?>"/>
									<input type="hidden" name="idper1" value="<?php echo $rowelos['id_per1']?>"/>
									<input type="hidden" name="idper2" value="<?php echo $rowelos['id_per2']?>"/>
									<!-- a la espera de correccion en duelo <input type="hidden" name="fecha" value="<?php echo $rowelos['fecha']?>"/> -->
								</form>
							<?php }
							else { ?>
								<form name="enlace" method="POST" action="duel_detalle.php">
									<input class="miniatura" style=" float: left; border-color:
								    <?php if ($rowelos['modo'] == "Victoria1") echo "blue";
									if ($rowelos['modo'] == "Empate") echo "orange";
									if ($rowelos['modo'] == "Victoria2") echo "red"; ?> ;"
									onmouseover = "this.src ='pics/objetos/<?php echo $rowelos['id_obj'];?>.jpg'"
									onmouseout = "this.src ='pics/personajes/<?php echo $rowelos['id_per1'];?>.jpg'"
									type="image" src="pics/personajes/<?php echo $rowelos['id_per1']?>.jpg"
									title = "El personaje <?php if ($rowelos['modo'] == "Victoria2") echo " gan&oacute; este duelo";
									if ($rowelos['modo'] == "Empate") echo " empat&oacute; este duelo"; 
									if ($rowelos['modo'] == "Victoria1") echo " perdi&oacute; este duelo"?>"/>
									<input type="hidden" name="idave" value="<?php echo $rowelos['id_ave']?>"/>
									<input type="hidden" name="idper1" value="<?php echo $rowelos['id_per1']?>"/>
									<input type="hidden" name="idper2" value="<?php echo $rowelos['id_per2']?>"/>
									<!-- <input type="hidden" name="fecha" value="<?php echo $rowelos['fecha']?>"/> -->
								</form>
							<?php } 
						$count++;
						} ?>
					</span>
				<div style="clear:both;"></div>
				<hr>
			</div>
		<?php } ?>
		</div>
	</div>
<?

?>
</body>
</html>
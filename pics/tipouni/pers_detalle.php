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
include("librerias/connect.php");
get_header();
$link=Conectarse();
if (isset($_POST['id'])){
$id = $_POST['id'];
}else{
$id = 1;
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
				<input type="image" src="pics/personajes/cuadradas300/<?php echo $ant['id_per']?>.jpg" />
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
				<input type="image" src="pics/personajes/cuadradas300/<?php echo $sig['id_per']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $sig['id_per']?>"/>
				</form>
				<?php
			}
			?>
		</div>
		<div class="contenido">
			<b class="tituloDetalles"><?php echo $row['nombre']?> </b>
			<div class="titulo"></div>
			<div class="detalles"> 
				<div class="foto">
					<img src="pics/personajes/cuadradas300/<?php echo $row['id_per']?>.jpg">
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
					
							
						
				</table>
				<div class = 'estadisticas'>
					<?php /*get_stats($row['fuerza'],$row['agilidad'],$row['inteligencia']);*/
					mostrar_stat("fuerza", $row['fuerza']);
					mostrar_stat("agilidad", $row['agilidad']);
					mostrar_stat("inteligencia", $row['inteligencia']);?>
					
					<div class='titulostatlista' ><img src='pics/heart.png'></div>
					<div>
						<?php echo $row['fuerza']*10; ?>
					</div>
					<div class='titulostatlista' ><img src='pics/armor2.png'></div>
					<div>
						<?php echo $row['agilidad']*5; ?> 
					</div>
					<div class='titulostatlista' ><img src='pics/mana.png'></div>
					<div>
						<?php echo $row['inteligencia']*3; ?>
					</div>
				</div>	

				<hr>	
			</div>
			<div class="detalles">
				<h2>Universo</h2>
				<?php
					$universo =mysql_query("select * from universos where id_uni = ".$id_uni.";");
					$rowniverso = mysql_fetch_array($universo);
					$uninom = $rowniverso['nombre'];
					$unitip = $rowniverso['tipo'];
					if (true) 
						{
						$unitip = "Tele";
						}
					
				?>
				<table>
					<tbody>
					<tr>
						<td><?php echo "<img title=O".$unitip." src = pics/tipouni/".$unitip.".jpg>"; ?></td>
						<td>
							<form name="enlace" method="POST" action="univ_detalle.php">
								<input type="image" title="<?php echo $uninom ?>" src="pics/universos/75/<?php echo $rowniverso['id_uni']?>.jpg" />
								<input type="hidden" name="id" value="<?php echo $id_uni?>"/>
							</form>
						</td>
					</tr>
					</tbody>
				</table>
				<h3>Otros personajes de este universo</h3>
				<?php $personajes = mysql_query("select * from personajes where id_uni = ".$id_uni.";"); ?>
				<table class="lol" border="1px black">
					<tbody>
						<tr>
						<?php
						$count = 0;
						while ( ($rowsonaje = mysql_fetch_array($personajes)) && ($count < 9) )
						{
							if ($rowsonaje['id_per'] != $id) {?>
							<td title="<?php echo $rowsonaje['nombre']; if ($rowsonaje['alias'] != ""){
							?> &#34;<?php echo $rowsonaje['alias']; ?>&#34;<?php } ?> <?php echo $rowsonaje['apellidos']; ?>" width="75px" style="text-align: center;">
								<form name="enlace" method="POST" action="pers_detalle.php">
								<input width = "70px" type="image" src="pics/personajes/cuadradas300/<?php echo $rowsonaje['id_per']?>.jpg" />
								<input type="hidden" name="id" value="<?php echo $rowsonaje['id_per']?>"/>
								</form>
							</td>
						<?php $count++; } } ?>
						<td>insetar la flechita</td>
						</tr>
					</tbody>
				</table>
				<hr>
			</div>
			<?php echo $id_per; ?>
			<?php $cuentainventario = mysql_query("select count (*) from inventario where id_per = ".$id_per.";");
			echo $cuentainventario;
			$hayobjetos = mysql_fetch_array($cuentainventario);
			echo $hayobjetos;
			if ($hayobjetos > 0) { ?>
				<div class="detalles"> 
					<h2>Objetos</h2>
					<?php $inventario = mysql_query("select inventario.id_obj as id_obj, inventario.cantidad as cantidad, objetos.nombre as nombre from inventario, objetos where objetos.id_obj = inventario.id_obj AND inventario.id_per = ".$id.";"); ?>
					<table class="lol" border="1px black">
						<tbody>
							<tr>
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
								
								<td title="<?php echo $rowventario['nombre']; ?>" width="75px" height="75px" valign="bottom" style="color: blue; font-size:200%; align: right; background:#000 url(pics/objetos/75/<?php echo $rowventario['id_obj']?>.jpg)" >
									<form name="enlace" method="POST" action="obje_detalle.php">
										<input type="hidden" name="id" value="<?php echo $rowventario['id_obj']?>"/>
									</form>
									<?php echo $rowventario['cantidad'];?>
								</td>
							<?php $count++; } ?>
							</tr>
						</tbody>
					</table>
					<hr>
				</div>
	<?php } ?>
			<div class="detalles"> 
			<h2>Aventuras</h2>
				<table class="lffol" border="1px black" style="border-style: none;">
					<tbody>
					<?php
								$consult = mysql_query("Select aventuras.id_esc AS idEsc, bitacora.modo AS modo, bitacora.id_mon as id_mon from bitacora, aventuras where aventuras.id_ave = bitacora.id_ave and bitacora.id_per= ".$id.";");
								$numBit = mysql_num_rows($consult);
								
								$vueltabit = $numBit / 10;
								if ($vueltabit % 10 <> 0){
									$vueltabit++;
								}
								$count=0;
								while ($rowbit = mysql_fetch_array($consult))
								{
									if ($count == 9){
										echo "</tr>";
										echo "<tr>";
									}
									$count++;
									?>
									<td style="width: 75px; height:75px; padding:0px;">
									<img src="pics/escenarios/75/<?php echo $rowbit['idEsc']?>.jpg" title="Resultado: <?php echo $rowbit['modo']?>"
									onmouseover="this.src ='pics/monstruos/75/<?php echo $rowbit['idEsc']?>.jpg'" onmouseout="this.src ='pics/escenarios/75/<?php echo $rowbit['idEsc']?>.jpg'">
									</td>
									<?php
								}
					?>
						<tr>
							
						</tr>
					</tbody>
				</table>
				<hr>
			</div>
			<div class="detalles"> 
				<h2>Duelos</h2>
				<?php $duelo = mysql_query("select * from duelo where id_per1 = ".$id." OR id_per2 = ".$id); ?>
				<table class="lol" border="0px">
					<tbody>
						<tr>
						<?php
						$count = 0;
						while ($rowelos = mysql_fetch_array($duelo) )
						{
							if  ($count == 9)
							{
								echo "</tr><tr>";
								$count = 0;
							}
							?>
							<td style="width:75px; max-width: 75px; height: 75px; max-height: 75px; overflow:hidden;">
							<?php if ($id==$rowelos['id_per1']) { ?>
								<form name="enlaceduelo" method="POST" action="duelo_detalle.php">
									<fieldset style="width:75px; max-width: 75px; height: 75px; max-height: 75px; border: 2px solid
										<?php if ($rowelos['modo'] == "Victoria1") echo "blue"; 
										if ($rowelos['modo'] == "Empate") echo "orange"; 
										if ($rowelos['modo'] == "Victoria2") echo "red"; ?> ;">
											<input width = "70px" type="image" src="pics/personajes/cuadradas300/<?php echo $rowelos['id_per2']?>.jpg" />
									</fieldset>
								</form>
							<?php }
							else { ?>
								<form name="enlaceduelo" method="POST" action="duelo_detalle.php">
									<fieldset style="width:75px; max-width: 75px; height: 75px; max-height: 75px; border: 2px solid
										<?php if ($rowelos['modo'] == "Victoria2") echo "blue"; 
										if ($rowelos['modo'] == "Empate") echo "orange"; 
										if ($rowelos['modo'] == "Victoria1") echo "red"; ?> ;">
											<input width = "50px" type="image" src="pics/personajes/cuadradas300/<?php echo $rowelos['id_per2']?>.jpg" />
									</fieldset>
								</form>
							</td>
						<?php } 							
						$count++;
						} ?>
						</tr>
					</tbody>
				</table>
				<hr>
			</div>
		</div>
	</div>
<?

?>
</body>
</html>
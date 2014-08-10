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


/*Funcion para comprobar fecha */
function cambiarFormatoFecha($fecha){
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $dia."-".$mes."-".$anio;
}  


	
/*Empieza a conectar*/	
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();

/*Comprueba si se ha añadido alguno o es la primera carga*/

if (isset($_POST['accion'])){
	if ($_POST['accion']=='a'){
				if ($_POST['ctraza']!=""){
					$raza=$_POST['ctraza'];
				}else{
					$raza=$_POST['cbraza'];
				}
				if ($_POST['ctclase']!=""){
					$clase=$_POST['ctclase'];
				}else{
					$clase=$_POST['cbclase'];
				}
				$fecha = $_POST['fecha2'];
				$nombre = $_POST['nombre'];
				$alias = $_POST['alias'];
				$apellidos = $_POST['apellidos'];
				$alineamiento = $_POST['alineamiento'];
				$sexo =$_POST['sexo'];
				$agilidad = $_POST['agilidad'];
				$inteligencia = $_POST['inteligencia'];
				$fuerza = $_POST['fuerza'];
				$fecha = cambiarFormatoFecha($fecha);
				$universo = $_POST['cbuniverso'];
		if ($raza == "" or $clase == "" or $fecha == "" or $alineamiento == "" or $sexo == "" or ($nombre=="" and $alias=="" and $apellidos=="") or $universo == ""){
			echo "no pueden haber campos vacios";
		}else{
			$insert = "insert into personajes (nombre, alias, apellidos, raza, alineamiento, clase, sexo, fecnac, fuerza, agilidad, inteligencia, id_uni) values ('$nombre','$alias','$apellidos','$raza','$alineamiento','$clase','$sexo','$fecha',$fuerza,$agilidad,$inteligencia, $universo);";
			mysql_query($insert,$link);
			
			$buscarid = mysql_query("select max(id_per) as id_per from personajes");
			/*$rowid = mysql_num_rows($buscarid,$link);*/
			/*echo"\n".$rowid;*/
			$rowid = mysql_fetch_array($buscarid);
			$uploaddir = './pics/personajes/';  // Es importante que la ruta acabe con una barra sino no funca
			/*$uploadfile = $uploaddir . basename($_FILES['fichero']['name']);*/
			$uploadfile = $uploaddir . $rowid['id_per'] . ".jpg";
			
			echo "<p>";

			if (move_uploaded_file($_FILES['fichero']['tmp_name'], $uploadfile)) {
				echo "Se produjo la inserción.\n".$rowid['id_mon'];
			} else {
				echo "Upload failed";
				echo $_FILES['fichero']['error'];
				$delete = "delete personajes where id_per =".$rowid['id_per'];
				mysql_query($delete,$link);
			}
			header('refresh:3; url = pers_lista.php');
		}
	}elseif($_POST['accion']=='m'){
				$id=$_POST['id'];
				if ($_POST['ctraza']!=""){
					$raza=$_POST['ctraza'];
				}else{
					$raza=$_POST['cbraza'];
				}
				if ($_POST['ctclase']!=""){
					$clase=$_POST['ctclase'];
				}else{
					$clase=$_POST['cbclase'];
				}

				$fecha = $_POST['fecha2'];
				$nombre = $_POST['nombre'];
				$alias = $_POST['alias'];
				$apellidos = $_POST['apellidos'];
				$alineamiento = $_POST['alineamiento'];
				$sexo =$_POST['sexo'];
				$agilidad = $_POST['agilidad'];
				$inteligencia = $_POST['inteligencia'];
				$fuerza = $_POST['fuerza'];
				$fecha = cambiarFormatoFecha($fecha);
				$universo = $_POST['cbuniverso'];
				if ($raza == "" or $clase == "" or $fecha == "" or $alineamiento == "" or $sexo == "" or ($nombre=="" and $alias=="" and $apellidos=="") or $universo == ""){
					echo "no pueden haber campos vacios";
					echo ($raza.$clase.$fecha.$alineamiento.$sexo.$nombre.$alias.$apellidos.$universo);
				
				}else{
					$update = "update personajes set nombre='$nombre' , alias='$alias', apellidos='$apellidos', raza='$raza', alineamiento='$alineamiento', clase='$clase', sexo='$sexo', fecnac='$fecha', fuerza=$fuerza, agilidad=$agilidad, inteligencia=$inteligencia, id_uni=$universo where id_per=$id;";
					mysql_query($update,$link);
					echo "Personaje Actualizado";
					header('refresh:3; url= pers_lista.php');
						
				}
		}

}elseif(isset($_POST['id'])){
	$id=$_POST['id'];
	$result =mysql_query("select * from personajes where id_per = ".$id.";");
	$row = mysql_fetch_array($result);
	?>
		<div class="general">
				<div class="contenido">
					<b class="tituloDetalles">
						<?php echo $row['nombre']." ";
						if($row['alias']!= null)
						{
							echo "\"".$row['alias']."\" ";
						}
							echo "".$row['apellidos'];
					?></b>
					<div class="titulo"></div>
					<div class="detalles"> 
					<form name=modificar action="pers_anyadificar.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000"> 
					<input type="Hidden" name="accion" value="m">
					<input type="Hidden" name="id" value="<?echo $row['id_per']?>">
						<div class="fotoobjetos">
							<img src="pics/personajes/<?php echo $row['id_per']?>.jpg"><br>
							<input name="fichero" type="file"> 
						</div>	
						<table class="detallestableobjetos">
							<tr>
								<td>
									<b>Nombre:</b> 
								</td>
								<td class="datos">
									<input type="text" name="nombre" value="<?php echo $row['nombre']?>">
								</td>
							</tr>
							<tr>
								<td>
									<b>Alias:</b>
								</td>
								<td class="datos">
									<input type="text" name="alias" value="<?php echo $row['alias']?>">
								</td>
							</tr>
							<tr>
								<td>
									<b>Apellidos:</b>
								</td>
								<td class="datos">
									<input type="text" name="apellidos" value="<?php echo $row['apellidos']?>">
								</td>
							</tr>
							<tr>
								<td>
									<b>Raza:</b> 
								</td>
								<td class="datos">
																	
									<select name="cbraza">
									<option>Seleccione una opcion...</option>
									<?php
									$consultCombo=mysql_query("select raza from personajes group by raza");
									while ($combo=mysql_fetch_array($consultCombo)){
										?>
										<option value="<?echo $combo['raza']?>"<?if ($row['raza']== $combo['raza']){ echo "selected";}?>><?echo $combo['raza']?></option>
										<?
									}
									?>														
									</select>
									<input type="text" name="ctraza">
								</td>
							</tr>
							<tr>
								<td>
									<b>Clase:</b> 
								</td>
								<td class="datos">
									<select name="cbclase">
									<option>Seleccione una opcion...</option>
									<?php
									$consultCombo=mysql_query("select clase from personajes group by clase");
									while ($combo=mysql_fetch_array($consultCombo)){
										?>
										<option value="<?echo $combo['clase']?>"<?if ($row['clase']== $combo['clase']){ echo "selected";}?>><?echo $combo['clase']?></option>
										<?
									}
									?>														
									</select>
									<input type="text" name="ctclase">
								</td>
							</tr>
							<tr>
								<td>
									<b>Alineamiento:</b> 
								</td>
								<td class="datos">
									<select name="alineamiento">
									<option>Seleccione una opcion...</option>
									<?php
									$consultCombo=mysql_query("select alineamiento from personajes group by alineamiento");
									while ($combo=mysql_fetch_array($consultCombo)){
										?>
										<option value="<?echo $combo['alineamiento']?>"<?if ($row['alineamiento']== $combo['alineamiento']){ echo "selected";}?>><?echo $combo['alineamiento']?></option>
										<?
									}
									?>														
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<b>Fecha de <br>nacimiento:</b> 
								</td>
								<td class="datos">
									
									<!--<input type="hidden" name="fecha1" value="<?php echo cambiarFormatoFecha($row['fecnac']);?>">-->
									<input type="text" name="fecha2" value="<?php echo cambiarFormatoFecha($row['fecnac']);?>">
									
								</td>
							</tr>
							<tr>
								<td>
									<b>Sexo:</b> 
								</td>
								<td class="datos">
									<select name="sexo">
									<option>Seleccione una opcion...</option>
									<?php
									$consultCombo=mysql_query("select sexo from personajes group by sexo");
									while ($combo=mysql_fetch_array($consultCombo)){
										?>
										<option value="<?echo $combo['sexo']?>"<?if ($row['sexo']== $combo['sexo']){ echo "selected";}?>><?echo $combo['sexo']?></option>
										<?
									}
									?>														
									</select>
								</td>
								</tr>
								</tr>
								<td>
									<b>Fuerza:</b>
								</td>
								<td class="datos">
									<select name="fuerza">
									<!--<option>Seleccione una opcion...</option>-->
									<?php
									for($i=1;$i<10;$i++){
										?>
										<option value="<?echo $i?>"<?if ($row['fuerza']== $i){ echo "selected";}?>><?echo $i?></option>
										<?
									}
									?>														
									</select>
								</td>
								</tr>
								</tr>
								<td>
									<b>Agilidad:</b>
								</td>
								<td class="datos">
									<select name="agilidad">
									<!--<option>Seleccione una opcion...</option>-->
									<?php
									for($i=1;$i<10;$i++){
										?>
										<option value="<?echo $i?>"<?if ($row['agilidad']== $i){ echo "selected";}?>><?echo $i?></option>
										<?
									}
									?>														
									</select>
								</td>
								</tr>
								</tr>
								<td>
									<b>Inteligencia:</b>
								</td>
								<td class="datos">
									<select name="inteligencia">
									<!--<option>Seleccione una opcion...</option>-->
									<?php
									for($i=1;$i<10;$i++){
										?>
										<option value="<?echo $i?>"<?if ($row['inteligencia']== $i){ echo "selected";}?>><?echo $i?></option>
										<?
									}
									?>														
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<b>Universo:</b> 
								</td>
								<td class="datos">
									<select name="cbuniverso">
									<option>Seleccione una opcion...</option>
									<?php
									$consultCombo=mysql_query("select id_uni, nombre from universos order by nombre asc");
									while ($combo=mysql_fetch_array($consultCombo)){
										?>
										<option value="<?echo $combo['id_uni']?>"<?if ($row['id_uni']== $combo['id_uni']){ echo "selected";}?>><?echo $combo['nombre']?></option>
										<?
									}
									?>														
									</select>
								</td>
							</tr>
							<tr>
								<td>
									
									<input type="submit" value="Modificar">
								</td>
							</tr>
							</form>
						</table>
						<div style="clear:both;"></div>
						
						<hr>	
					</div>
				</div>
			</div>
<?php
}else{
	?>
				<div class="general">
			<div class="contenido">
				<b class="tituloDetalles"><?php echo "Nuevo personaje"?> </b>
				<div class="titulo"></div>
				<div class="detalles"> 
				<form name="anadir" action="pers_anyadificar.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="MAX_FILE_SIZE" value="10000000"> 
				<input type="Hidden" name="accion" value="a">
					<div class="fotoobjetos">
						<img src="pics/personajes/0.jpg"><br>
						<input name="fichero" type="file"> 
					</div>
					<table class="detallestableobjetos">
						<tr>
							<td>
								<b>Nombre:</b> 
							</td>
							<td class="datos">
								<input type="text" name="nombre" value="">
							</td>
						</tr>
						<tr>
							<td>
								<b>Alias:</b>
							</td>
							<td class="datos">
								<input type="text" name="alias" value="">
							</td>
						</tr>
						<tr>
							<td>
								<b>Apellidos:</b>
							</td>
							<td class="datos">
								<input type="text" name="apellidos" value="">
							</td>
						</tr>
						<tr>
							<td>
								<b>Raza:</b> 
							</td>
							<td class="datos">
																
								<select name="cbraza">
								<?php
								$consultCombo=mysql_query("select raza from personajes group by raza");
								while ($combo=mysql_fetch_array($consultCombo)){
									?>
									<option value="<?echo $combo['raza']?>"> <? echo $combo['raza']?> </option>
									<?
								}
								?>														
								</select>
								<input type="text" name="ctraza" value="">
							</td>
						</tr>
						<tr>
							<td>
								<b>Clase:</b> 
							</td>
							<td class="datos">
								<select name="cbclase">
								<?php
								$consultCombo=mysql_query("select clase from personajes group by clase");
								while ($combo=mysql_fetch_array($consultCombo)){
									?>
									<option value="<?echo $combo['clase']?>"><?echo $combo['clase']?></option>
									<?
								}
								?>														
								</select>
								<input type="text" name="ctclase" value="">
							</td>
						</tr>
						<tr>
							<td>
								<b>Alineamiento:</b> 
							</td>
							<td class="datos">
								<select name="alineamiento">
								<?php
								$consultCombo=mysql_query("select alineamiento from personajes group by alineamiento");
								while ($combo=mysql_fetch_array($consultCombo)){
									?>
									<option value="<?echo $combo['alineamiento']?>"><?echo $combo['alineamiento']?></option>
									<?
								}
								?>														
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<b>Fecha de <br>nacimiento:</b> 
							</td>
							<td class="datos">
								<input type="text" name="fecha2" value=""> Ej:dd-MM-yyyy
							</td>
						</tr>
						<tr>
							<td>
								<b>Sexo:</b> 
							</td>
							<td class="datos">
								<select name="sexo">
								<?php
								$consultCombo=mysql_query("select sexo from personajes group by sexo");
								while ($combo=mysql_fetch_array($consultCombo)){
									?>
									<option value="<?echo $combo['sexo']?>"><?echo $combo['sexo']?></option>
									<?
								}
								?>														
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<b>Fuerza:</b> 
							</td>
							<td class="datos">
								<select name="fuerza">
								<?php
								for($i=1;$i<10;$i++){
									?>
									<option value="<?echo $i?>"><?echo $i?></option>
									<?
								}
								?>														
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<b>Agilidad:</b> 
							</td>
							<td class="datos">
								<select name="agilidad">
								<?php
								for($i=1;$i<10;$i++){
									?>
									<option value="<?echo $i?>"><?echo $i?></option>
									<?
								}
								?>														
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<b>Inteligencia:</b> 
							</td>
							<td class="datos">
								<select name="inteligencia">
								<?php
								for($i=1;$i<10;$i++){
									?>
									<option value="<?echo $i?>"><?echo $i?></option>
									<?
								}
								?>														
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<b>Universo:</b> 
							</td>
							<td class="datos">
								<select name="cbuniverso">
								<option>Seleccione una opcion...</option>
								<?php
								$consultCombo=mysql_query("select id_uni, nombre from universos order by nombre asc");
								while ($combo=mysql_fetch_array($consultCombo)){
									?>
									<option value="<?echo $combo['id_uni']?>"><?echo $combo['nombre']?></option>
									<?
								}
								?>														
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" value="Guardar">
							</td>
						</tr>
						</form>
					</table>
					<div style="clear:both;"></div>
					
					<hr>	
				</div>
			</div>
		</div>

<?php
}
?>
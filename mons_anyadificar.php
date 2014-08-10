<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
<?php 
if (isset($_POST['accion'])){
	if ($_POST['accion']=='a'){?>
	<title>A&ntilde;adir monstruo</title>
	<?php }elseif($_POST['accion']=='m'){ ?>
	<title>Modificar monstruo</title>
	<?php 		}
}elseif(isset($_POST['id'])){?>
	<title>Modificar monstruo</title>
<?php }else{ ?>
	<title>A&ntilde;adir monstruo</title>
<?php } ?>
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

/*Funcion para comprobar fecha */
/*function cambiarFormatoFecha($fecha){
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $dia."-".$mes."-".$anio;
}  */


	
/*Empieza a conectar*/	
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();

/*Comprueba si se ha añadido alguno o es la primera carga*/

if (isset($_POST['accion'])){
	if ($_POST['accion']=='a'){
		$nombre = $_POST['nombre'];
		$color = $_POST['color'];
		$dificultad = $_POST['dificultad']; 
		$id_obj = $_POST['cbobjeto'];
		$posibilidad =$_POST['posibilidad'];
		if ($nombre == "" or $color == "" or $dificultad == ""){
			echo "no puede haber campos vacios";
		}else{
			$insert = "insert into monstruos (nombre, color, dificultad, id_obj, posibilidad) values ('".$nombre."','".$color."','".$dificultad."',".$id_obj.",".$posibilidad.")";
			if ($id_obj == "Seleccione un objeto..."){
				$insert = "insert into monstruos (nombre, color, dificultad) values ('".$nombre."','".$color."','".$dificultad."')";
			}
			elseif ($posibilidad == ""){
				$insert = "insert into monstruos (nombre, color, dificultad, id_obj, posibilidad) values ('".$nombre."','".$color."','".$dificultad."', ".$id_obj.", 50)";
			}
			mysql_query($insert,$link);
			echo $insert;
			//Hacer el insert
			$buscarid = mysql_query("select max(id_mon) as id_mon from monstruos");
			/*$rowid = mysql_num_rows($buscarid,$link);*/
			/*echo"\n".$rowid;*/
			$rowid = mysql_fetch_array($buscarid);
			$uploaddir = './pics/monstruos/';  // Es importante que la ruta acabe con una barra sino no funca
			/*$uploadfile = $uploaddir . basename($_FILES['fichero']['name']);*/
			$uploadfile = $uploaddir . $rowid['id_mon'] . ".jpg";
			
			echo "<p>";

			if (move_uploaded_file($_FILES['fichero']['tmp_name'], $uploadfile)) {
				echo "Se produjo la inserción.\n".$rowid['id_mon'];
			} else {
				echo "Upload failed";
				echo $_FILES['fichero']['error'];
				$delete = "delete monstruos where id_mon =".$rowid['id_mon'];
				mysql_query($delete,$link);
			}
			header('refresh:3; url= mons_lista.php');
		}
			
	}elseif($_POST['accion']=='m'){
		$id=$_POST['id'];
		$nombre = $_POST['nombre'];
		$color = $_POST['color'];
		$dificultad = $_POST['dificultad'];
		$id_obj = $_POST['id_obj'];
		$posibilidad =$_POST['posibilidad'];	
		if ($nombre == "" or $color == "" or $dificultad == ""){
			echo "no pueden haber campos vacios";
		}else{
			$update = "update monstruos set nombre='".$nombre."', color='".$color."', dificultad='".$dificultad."', id_obj=".$id_obj.", posibilidad=".$posibilidad." where id_mon=".$id.";";
			if ($id_obj = "Seleccione un objeto..."){
				$update = "update monstruos set nombre='".$nombre."', color='".$color."', dificultad='".$dificultad."', id_obj= NULL, posibilidad= NULL where id_mon=".$id.";";
			}
			elseif ($posibilidad = ""){
				$update = "unpdate monstruos set nombre='".$nombre."', color='".$color."', dificultad='".$dificultad."', id_obj=".$id_obj.", posibilidad= 50 where id_mon=".$id.";";
			}
			mysql_query($update,$link);
			echo "Monstruo Actualizado";
			
			/*Esto falla hay que depurarlo*/
			if (isset($_FILES)){
				$uploaddir = './pics/monstruos/';  // Es importante que la ruta acabe con una barra sino no funca
				$uploadfile = $uploaddir . $id . ".jpg";
			
				if (move_uploaded_file($_FILES['fichero']['tmp_name'], $uploadfile)) {
					echo "Se actualizó el monstruo.\n".$id;
				} else {
					echo "Ha fallado la subida de la imagen";
					echo $_FILES['fichero']['error'];
				}
			}
			header('refresh:3; url= mons_lista.php');
		}
	}
}elseif(isset($_POST['id'])){
	$id=$_POST['id'];
	$result =mysql_query("select * from monstruos where id_mon = ".$id.";");
	$row = mysql_fetch_array($result);
	?>
	<!-- MODIFICAR -->
		<div class="general">
				<div class="contenido">
					<b class="tituloDetalles">
						<?php echo $row['nombre']." ";?>
					</b>
					<div class="titulo"></div>
					<div class="detalles"> 
						<form name=modificar action="mons_anyadificar.php" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="MAX_FILE_SIZE" value="10000000"> 
							<input type="Hidden" name="accion" value="m">
							<input type="Hidden" name="id" value="<?echo $row['id_mon']?>">
							<form enctype="multipart/form-data" action="mons_anyadificar.php" method="POST">
								<div class="fotoobjetos">
									<img src="pics/monstruos/<?php echo $row['id_mon']?>.jpg"><br>
								</div>
														<div style="clear:both;"></div>
								<div class="statsdetalle">
									<input type="hidden" name="MAX_FILE_SIZE" value="51200000" />
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
										<b>Color:</b>
									</td>
									<td class="datos">
										<input type="text" name="color" value="<?php echo $row['color']?>">
									</td>
								</tr>
								<tr>
									<td>
										<b>Dificultad:</b>
									</td>
									<td class="datos">
										<input type="text" name="dificultad" value="<?php echo $row['dificultad']?>">
									</td>
								</tr>
								<tr>
									<td>
										<b>Objetos:</b> 
									</td>							
									<td class="datos">
										<select name="cbobjeto">
											<option>Seleccione un objeto...</option>
											<?php
											$consultCombo=mysql_query("select id_obj, nombre from objetos");
											while ($combo=mysql_fetch_array($consultCombo)){
											?>
											<option value="<?echo $combo['id_obj']?>"<?if ($row['id_obj']== $combo['id_obj']){ echo "selected";}?>><?echo $combo['nombre']?></option>
											<?
											}
											?>											
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<b>Probabilidad:</b>
									</td>
									<td class="datos">
										<input type="text" name="posibilidad" value="<?php echo $row['posibilidad']?>">
									</td>
								</tr>
						</table>
						<div style="clear:both;"></div>
										<div class = "botonguardar">
					<input type="submit" value="Modificar" onClick="mostrar();">
				</div>
				</form>
						<hr>	
					</div>
				</div>
			</div>
<?php
}else{
	?>
	<!-- Añadir -->
	<div class="general">
		<div class="contenido">
			<b class="tituloDetalles"><?php echo "Nuevo monstruo"?> </b>
				<div class="titulo"></div>
				<div class="detalles"> 
					<form name="anadir" action="mons_anyadificar.php" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="MAX_FILE_SIZE" value="10000000"> 
						<input type="Hidden" name="accion" value="a">
						<div class="foto">
							<img src="pics/monstruos/0.jpg"><br>
							<input name="fichero" type="file"> 
						</div>
						<table class="detallestable">
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
								<b>Color:</b>
							</td>
							<td class="datos">
								<input type="text" name="color" value="">
							</td>
						</tr>
						<tr>
							<td>
								<b>Dificultad:</b>
							</td>
							<td class="datos">
								<input type="text" name="dificultad" value="">
							</td>
						</tr>
						<tr>
							<td>
								<b>Objetos:</b> 
							</td>							
							<td class="datos">
								<select name="cbobjeto">
									<option>Seleccione un objeto...</option>
									<?php
									$consultCombo=mysql_query("select id_obj, nombre from objetos");
									while ($combo=mysql_fetch_array($consultCombo)){
									?>
									<option value="<?echo $combo['id_obj']?>"><?echo $combo['nombre']?></option>
									<?
									}
									?>											
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<b>Probabilidad:</b>
							</td>
							<td class="datos">
								<input type="text" name="posibilidad">
							</td>
						</tr>
				</table>
				<div style="clear:both;"></div>
				<div class = "botonguardar">
					<input type="submit" value="Guardar">
				</div>
				</form>
			</div>
		</div>
	</div>
<?php
}
?>
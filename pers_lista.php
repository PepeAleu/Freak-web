<html>

<head>
	<title>Listado de personajes</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
	<script type="text/javascript">
		var obj
		var tam = 0;
		function mostrarBuscar(capa){ 
			obj = document.getElementById(capa) 
			if(obj.style.visibility== "hidden"){ 
				obj.style.visibility= "visible";
				obj.style.height = "200px";
			}
			else {
				obj.style.visibility= "hidden"; 
				obj.style.height = "0px";
			}
		}
	</script>
</head>

<body background="pics/fondo2.jpg">
<?php 
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();
echo "<br><br>";


if(isset($_GET['buscar'])){
$buscar = $_GET['buscar'];
}else{
$buscar = "select * from personajes where id_per = id_per";
}
if(isset($_POST['nomPer'])){
$nom = $_POST['nomPer'];
$ali = $_POST['aliPer'];
$ape = $_POST['apePer'];
$raz = $_POST['razPer'];
$cla = $_POST['cla'];
if (isset($_POST['alin1'])){
$alin1 = $_POST['alin1'];
}else{$alin1="";}
if (isset($_POST['alin2'])){
$alin2 = $_POST['alin2'];
}else{$alin2="";}
if (isset($_POST['alin3'])){
$alin3 = $_POST['alin3'];
}else{$alin3="";}
if (isset($_POST['sex1'])){
$sex1 = $_POST['sex1'];
}else{$sex1="";}
if (isset($_POST['sex2'])){
$sex2 = $_POST['sex2'];
}else{$sex2="";}
if (isset($_POST['sex3'])){
$sex3 = $_POST['sex3'];
}else{$sex3="";}

	
	if($nom != "" && $nom != null){			
		$buscar = $buscar." and nombre like '%".$nom."%'";
	}
	if($ali != "" && $ali != null){
		$buscar = $buscar." and alias like '%".$ali."%'";
	}
	if($ape != "" && $ape != null){
		$buscar = $buscar." and apellidos = '%".$ape."%'";
	}
	if($raz != "" && $raz != null){
		$buscar = $buscar." and raza = '".$raz."'";
	}
	if($cla != "" && $cla != null){
		$buscar = $buscar." and clase = '".$cla."'";
	}
	if(($alin1 != "" && $alin1 != null) or ($alin2 != "" && $alin2 != null) or ($alin3 != "" && $alin3 != null)){
		$buscar = $buscar." and alineamiento IN ('".$alin1."','".$alin2."','".$alin3."')";
	}
	if(($sex1 != "" && $sex1 != null) or ($sex2 != "" && $sex2 != null) or ($sex3 != "" && $sex3 != null)){
		$buscar = $buscar." and sexo IN ('".$sex1."','".$sex2."','".$sex3."')";
	}	
}	
$result = mysql_query($buscar);
$count = mysql_num_rows($result);
$vueltas = $count / 10.0;
if($count%10 != 0){
	$vueltas++;
}
if (isset($_POST['id_perb']))
{
		if (!mysql_query("Delete from personajes where id_per = '".$_POST['id_perb']."';",$link)){
			echo 'Error al borrar';
		}
}

if (isset($_GET['pag'])) {
	$pag = $_GET['pag'];
	$inicio = (($pag-1) *10);
	$fin = 10;
	$result =mysql_query($buscar." order by id_per asc LIMIT ".$inicio.",".$fin.";");
	
}else{
	$pag = 1;
	$result =mysql_query($buscar." order by id_per asc LIMIT 0,10;");
}
?>
<div class="general">
	<div id="buscarDiv" class="buscar" style="margin-left:-130px;width:260px;visibility:hidden;padding-bottom:70px;">
		<h3>Buscar</h3>
	
			<form action="pers_lista.php" method="POST">
				Nombre <input  type="text" name="nomPer"></input>
				<br>
				Alias <input  type="text" name="aliPer"></input>
				<br>
				Apellidos <input  type="text" name="apePer"></input>
				<br>
				Razas <select name="razPer">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT distinct(raza) FROM personajes order by raza; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['raza'].'">'.$rowb['raza'].'</option>';
				}
				?>
				</select>
				<br>
				Alineamiento 
				<input type="checkbox" name="alin1" value="Bueno"> <img src="pics/Bueno.png"></input></img> 
				<input type="checkbox" name="alin2" value="Neutral" > <img src="pics/Neutral.png"></input></img> 
				<input type="checkbox" name="alin3" value="Malvado"> <img src="pics/Malo.png"></input></img> 
				<br>
				Clases <select name="cla">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT distinct(clase) FROM personajes order by clase; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['clase'].'">'.$rowb['clase'].'</option>';
				}
				?>
				</select>
				<br>
				Sexo 
				<input type="checkbox" name="sex1" value="Masculino" ></input> <img src="pics/Hombre.png"></img> 
				<input type="checkbox" name="sex2" value="Femenino" > </input><img src="pics/Mujer.png"></img>
				<input type="checkbox" name="sex3" value="Asexuado" > </input><img src="pics/Neutro.png"></img>				
				<br>
				<input value="Buscar" type="submit"></input>
			</form>
		</div>
		<div class="contenido">
		<b class="tituloDetalles">Listado de personajes</b>
		<a href='#' onClick="mostrarBuscar('buscarDiv');"><img src='pics/lupa.png' style='position:absolute;right:30px;margin:15px 15px 30px 0px;'></a>
		<a href='pers_anyadificar.php'><img src='pics/add.png' style='position:absolute;right:10px;margin:15px 15px 30px 0px;'></a>
				
						<hr style="margin-top:20px;position:relative;">
						<?php 
							while($row = mysql_fetch_array($result))
							{
							$lvl=($row['fuerza']+$row['agilidad']+$row['inteligencia'])/3;
							$lvl++;
							$lvl=round($lvl);
						?>
								
								<div class='lista'>									
									<div class='titulolista'>
									<?php echo "	<b style=\"position:absolute;left:120px; \">".$row['nombre']." ";
									if($row['alias']!= null)
									{
										echo "\"".$row['alias']."\" ";
									}
									echo "".$row['apellidos']." </b><div class='level'>lvl.".$lvl."</div> ";
									?>
										<div class='titulolistaimg'>
                                        <?php
											printf("
											<form name=\"enlace\" method=\"POST\" action=\"pers_detalle.php\">
												<input onerror=\"this.onerror=null;this.src='pics/personajes/0.jpg';\" class='fotolistaper' type=\"image\" src=\"pics/personajes/".$row['id_per'].".jpg\" />
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_per']."\"/>
											</form>
											");
										?>
										</div>
										
									</div>
									
									<?php get_stats($row['fuerza'],$row['agilidad'],$row['inteligencia']); ?>
									<?php get_stats2($row['fuerza'],$row['agilidad'],$row['inteligencia']); ?>
									<div class='icon_sex'>
										<?php 
										if($row['alineamiento']== "Bueno")
										{
											echo "<img src='pics/Bueno.png'>";
										}
										else if ($row['alineamiento']== "Malvado")
										{
											echo "<img src='pics/Malo.png'>";
										}
										else
										{
											echo "<img src='pics/Neutral.png'>";
										}
										?>
									</div>
									<div class='icon_alin'>
										<?php 
											if($row['sexo']== "Masculino")
											{
												echo "<img src='pics/Hombre.png'>";
											}
											else if ($row['sexo']== "Femenino")
											{
												echo "<img src='pics/Mujer.png'>";
											}
											else
											{
												echo "<img src='pics/Neutro.png'>";
											}
										?>
									</div>


																		
								</div>
									
									<hr>
							<?php	
						}
						?>
<div class='paginaslista'>
<?php
/*for ($i=1;$i<=$vueltas;$i++){

	if($pag==$i){
?>	
		<A style="color:#fff;font-size:small;" HREF="pers_lista.php?pag=<? echo $i ?>""><? echo $i." " ?></A>
	<?	
	}else{
	
	?>
		<A HREF="pers_lista.php?pag=<? echo $i ?>""><? echo $i." " ?></A>
	<?	
	}
}*/
	if (isset($_GET['pag'])){
	$i=$_GET['pag'];
	}else{
	$i=1;
	}
mostrar_nav($i, $vueltas, $buscar)
?>

</div>



			</div>

		</div>



</body>
</html>
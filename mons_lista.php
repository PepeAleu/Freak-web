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
	<script type="text/javascript">
		function mostrarBuscar(capa){ 
			var obj = document.getElementById(capa) 
			if(obj.style.visibility== "hidden"){ 
				obj.style.visibility= "visible";
			}
			else {
				obj.style.visibility= "hidden"; 
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
$buscar = "select * from monstruos where id_mon = id_mon ";
}
if(isset($_POST['nomMon'])){
$nom = $_POST['nomMon'];
$col = $_POST['colMon'];
$obj = $_POST['Obj'];
$pos = $_POST['posObj'];

if (isset($_POST['nomMon'])){
$nom = $_POST['nomMon'];
}else{$nom="";}
if (isset($_POST['colMon'])){
$col = $_POST['colMon'];
}else{$col="";}
if (isset($_POST['Obj'])){
$obj = $_POST['Obj'];
}else{$obj="";}
if (isset($_POST['posObj'])){
$pos = $_POST['posObj'];
}else{$pos="";}
if (isset($_POST['sig'])){
$sig = $_POST['sig'];
}else{$sig="=";}

	
	if($nom != "" && $nom != null){			
		$buscar = $buscar." and nombre like '%".$nom."%'";
	}
	if($col != "" && $col != null){
		$buscar = $buscar." and color = '".$col."'";
	}
	if($obj != "" && $obj != null){
		$buscar = $buscar." and id_obj = ".$obj." ";
	}
	if($pos != "" && $pos != null){
		$buscar = $buscar." and posibilidad ".$sig." ".$pos." ";
	}

}	
$result = mysql_query($buscar,$link);
$count = mysql_num_rows($result);
$vueltas = $count / 10.0;
if($count%10 != 0){
	$vueltas++;
}

if (isset($_GET['pag'])) {
	$pag = $_GET['pag'];
	$inicio = (($pag-1) *10);
	$fin = 10;
	$result =mysql_query($buscar." order by id_mon asc LIMIT ".$inicio.",".$fin.";");
	
}else{
	$pag = 1;
	$result =mysql_query($buscar." order by id_mon asc LIMIT 0,10;");
}
if (isset($_POST['id_monb']))
{
		if (!mysql_query("Delete from monstruos where id_mon = '".$_POST['id_monb']."';",$link)){
			echo 'Error al borrar';
		}
}

?>
<div class="general">
	<div id="buscarDiv" class="buscar" style="visibility:hidden;width:250px;margin-left:-125px;">
		<h3>Buscar</h3>

			<form action="mons_lista.php" method="POST">
				Nombre <input  type="text" name="nomMon"></input>
				<br>
				Color <select name="colMon">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT distinct(color) FROM monstruos order by color; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['color'].'">'.$rowb['color'].'</option>';
				}
				?>
				</select>
				<br>
				Objetos <select name="Obj">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT id_obj, nombre FROM objetos order by nombre; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['id_obj'].'">'.$rowb['nombre'].'</option>';
				}
				?>
				</select>
				<br>
				Posibilidad <input  type="text" name="posObj"></input><br></input><input type="radio" value="=" name="sig" checked />=<br /></input><input type="radio" value=">" name="sig"/>><br /></input><input type="radio" value="<" name="sig" /><<br /></input>
				<br>
				<input value="Buscar" type="submit"></input>
			</form>
	</div>
		<div class="contenido">
		<b class="tituloDetalles">Listado de monstruos</b>
			<a href='#' onClick="mostrarBuscar('buscarDiv');"><img src='pics/lupa.png' style='position:absolute;right:30px;margin:15px 15px 30px 0px;'></a>
			<a href='mons_anyadificar.php'><img src='pics/add.png' style='position:absolute;right:10px;margin:15px 15px 30px 0px;'></a>
				<div class="titulo"></div>
						<hr style="margin-top:20px;position:relative;">
						<?php 
							if ($count < 1){
									echo "<h2 style='margin-left:140px;'>No se encontr&oacute; ning&uacute;n monstruo</h2>";
									echo "<hr>";
							}
							while($row = mysql_fetch_array($result))
							{
								if ($row['id_obj']==null){
								$objeto="Nada";
								$probabilidad="0";
								}else{
								$result2 = mysql_query("Select nombre from objetos where id_obj =".$row['id_obj'].";");
								$objeto_asociado = mysql_fetch_array($result2);
								$objeto = $objeto_asociado['nombre'];
								$probabilidad = $row['posibilidad'];
								}
								echo
								"<div class='lista'>									
									<div class='titulolista'>
										<b style=\"position:absolute;left:120px; \">".$row['nombre']."</b>
										<div class='titulolistaimg'>
											<form name=\"enlace\" method=\"POST\" action=\"mons_detalle.php\">
												<input class='fotolista' type=\"image\" src=\"pics/monstruos/".$row['id_mon'].".jpg\" />
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_mon']."\"/>
											</form>
												
										</div>
										
									</div>
										<img class = 'listamonstruoscolor' width = '25px'  src = 'pics/colores/".$row['color'].".png'>

									<div class='listamonstruos'>
										<img align = 'middle' title = '".$row['dificultad']."' width = '50px' src = 'pics/dificultades/".$row['dificultad'].".png'>
									";
									if ($objeto =="Nada"){
										echo "<img title = 'Nada' width = '50px' align = 'middle' src = 'pics/escenarios/x2.png'>";
									}
									else{
										echo "<img title = '".$objeto." ".$probabilidad."%' align = 'middle' width = '50px' src = 'pics/objetos/".$row['id_obj'].".jpg'>";
									}
									

									echo"</div>
								</div>
									
									<hr>
								";
						}?>
					<div class='paginaslista'>
					<?php
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
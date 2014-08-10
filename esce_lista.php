<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Escenarios</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta name="description" content="Aplicación web de la base de datos friki" />
	<meta name="keywords" content="friki web" />
	<meta name="robots" content="index, follow" />
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
$buscar = " id_esc = id_esc ";
}
if(isset($_POST['nomEsc'])){
$nom = $_POST['nomEsc'];

if(isset($_POST['esp1'])){
$esp1 = $_POST['esp1'];
}else{
$esp1 = "";
}
if(isset($_POST['esp0'])){
$esp0 = $_POST['esp0'];
}else{
$esp0 = "";
}

$escpa = $_POST['escpa'];
$pob = $_POST['pob'];
$sig = $_POST['sig'];


	
	if($nom != "" && $nom != null){			
		$buscar = $buscar." and nombre like '%".$nom."%'";
	}
	if(($esp1 != "" && $esp1 != null) ){
		$buscar = $buscar." and esplaneta = ".$esp1."";
	}
	if ($esp0 != "" && $esp0 != null){
		$buscar = $buscar." and esplaneta = ".$esp0."";
	}
	if($escpa != "" && $escpa != null){
		$buscar = $buscar." and esc_padre = ".$escpa."";
	}
	if($pob != "" && $pob != null){
		$buscar = $buscar." and poblacion ".$sig." ".$pob."";
	}
}	
$result = mysql_query("Select * from escenarios where ".$buscar.";");
$count = mysql_num_rows($result);
$vueltas = $count / 10.0;
if($count%10 != 0){
	$vueltas++;
}

if (isset($_POST['id_escb']))
{
		if (!mysql_query("Delete from escenarios where id_esc = '".$_POST['id_escb']."';",$link)){
			echo 'Error al borrar';
		}
		
	
}

if (isset($_GET['pag'])) {
	$pag = $_GET['pag'];
	$inicio = (($pag-1) *10);
	$fin = 10;
	$result =mysql_query("select * from escenarios where ".$buscar." order by id_esc asc LIMIT ".$inicio.",".$fin.";");
	
}else{
	$pag = 1;
	$result =mysql_query("select * from escenarios where ".$buscar." order by id_esc asc LIMIT 0,10;");
}
?>
<div class="general">
<div id="buscarDiv" class="buscar" style="margin-left:-130px;width:260px;visibility:hidden;padding-bottom:70px;">
		<h3>Buscar</h3>
	
			<form action="esce_lista.php" method="POST">
				Nombre <input  type="text" name="nomEsc"></input>
				<br>
				Es planeta? 
				<input type="checkbox" name="esp1" value="1" ></input> Si
				<input type="checkbox" name="esp0" value="0" > </input> No			
				<br>
				Escenario padre <select name="escpa">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT id_esc, nombre FROM escenarios where id_esc IN (SELECT esc_padre FROM escenarios)  order by nombre; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['id_esc'].'">'.$rowb['nombre'].'</option>';
				}
				?>
				</select>
				<br>
				Poblaci&oacute;n <input  type="text" name="pob"></input><br></input><input type="radio" value="=" name="sig" checked />=<br /></input><input type="radio" value=">" name="sig"/>><br /></input><input type="radio" value="<" name="sig" /><<br /></input>
				<br>
				
				<input value="Buscar" type="submit"></input>
			</form>
		</div>
		<div class="contenido">
		<b class="tituloDetalles">Listado de escenarios</b>
		<a href='#' onClick="mostrarBuscar('buscarDiv');"><img src='pics/lupa.png' style='position:absolute;right:30px;margin:15px 15px 30px 0px;'></a>
		<a href='esce_anyadificar.php'><img src='pics/add.png' style='position:absolute;right:10px;margin:15px 15px 30px 0px;'></a>
				<div class="titulo"></div>
						<hr style="margin-top:20px;position:relative;">
						<?php 
							if ($count < 1){
									echo "<h2 style='margin-left:140px;'>No se encontr&oacute; ning&uacute; escenario</h2>";
									echo "<hr>";
							}
							while($row = mysql_fetch_array($result))
							{
								$poblacion = $row['poblacion'];
								$poblacion = number_format($poblacion, 0, ',', '.');
								
								printf("
								<div class='lista'>									
									<div class='titulolista'>
										<b style=\"position:absolute;left:120px; \">".$row['nombre']."</b>
										<div class='titulolistaimg'>
											<form name=\"enlace\" method=\"POST\" action=\"esce_detalle.php\">
												<input class='fotolista' type=\"image\" src=\"pics/escenarios/".$row['id_esc'].".jpg\" 
												onerror=\"this.onerror=null;this.src='pics/escenarios/00.jpg';\"/>
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_esc']."\"/>
											</form>
												
										</div>
										
									</div>
									
									<div class='stats'>
										
								");
										echo "<div class='titulostatlista2' >Poblacion: ".$poblacion." habitantes</div><br>";
										if ($row['esplaneta'] == 1) {
										
											echo "<div class='titulostatlista2' > <img src='pics/planeta.png' width='20' height='20'> </div><br>";
										}	
										else{
																				
										}
										echo "<div class='barritastatlista' >";
										echo "</div>";
								echo"</div>";	
								/* STATS DERIVADOS */
									echo"<div class='stats2'>";
									echo"</div>";
								printf("	
								</div>
									
									<hr>
								");
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>universos</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta name="duniription" content="Aplicación web de la base de datos friki" />
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

echo "<br><br>";
$result = mysql_query("Select * from universos");
$count = mysql_num_rows($result);
$vueltas = $count / 10.0;
if($count%10 != 0){
	$vueltas++;
}

if (isset($_POST['id_unib']))
{
		if (!mysql_query("Delete from universos where id_uni = '".$_POST['id_unib']."';",$link)){
			echo 'Error al borrar';
		}
		
	
}

if (isset($_GET['pag'])) {
	$pag = $_GET['pag'];
	$inicio = (($pag-1) *10);
	$fin = 10;
	$result =mysql_query("SELECT universos.id_uni, universos.nombre, tipo, count(id_per) as cantidad FROM universos, personajes WHERE personajes.id_uni = universos.id_uni group by universos.id_uni, universos.nombre, universos.tipo
UNION
SELECT id_uni, nombre, tipo, 0 as cantidad FROM universos WHERE id_uni NOT IN 
(SELECT id_uni FROM personajes) order by id_uni asc LIMIT ".$inicio.",".$fin.";", $link);
	
}else{
	$pag = 1;
	$result =mysql_query("SELECT universos.id_uni, universos.nombre, tipo, count(id_per) as cantidad FROM universos, personajes WHERE personajes.id_uni = universos.id_uni group by universos.id_uni, universos.nombre, universos.tipo
UNION
SELECT id_uni, nombre, tipo, 0 as cantidad FROM universos WHERE id_uni NOT IN 
(SELECT id_uni FROM personajes) LIMIT 0,10;", $link);
}
?>
<div class="general">
		<div class="contenido">
		<b class="tituloDetalles">Listado de universos</b><a href='annadificaruni.php?padre=0'><img src='pics/add.png' style='position:absolute;right:10px;margin:15px 15px 30px 0px;'></a>
				<div class="titulo"></div>
						<hr style="margin-top:20px;position:relative;">
						<?php 
							while($row = mysql_fetch_array($result))
							{
								$cantidad = $row['cantidad'];
								if ($cantidad > 1 AND $cantidad < 6){
									$cantidad = "5";
								}
								elseif ($cantidad > 5 AND $cantidad < 11){
									$cantidad = "10";
								}
								elseif ($cantidad > 11 AND $cantidad < 16){
									$cantidad = "15";
								}
								elseif ($cantidad > 16 AND $cantidad < 21){
									$cantidad = "20";
								}elseif ($cantidad > 20){
									$cantidad = "25";
								}
								$tipo = $row['tipo'];
								if ($tipo == "Televisi&oacute;n") {
									$tipo = "Television";
									}
								echo
								"<div class='lista'>									
									<div class='titulolista'>
										<b style=\"position:absolute;left:120px; \">".$row['nombre']."</b>
										<div class='titulolistaimg'>
											<form name=\"enlace\" method=\"POST\" action=\"univ_detalle.php\">
												<input onerror='this.onerror=null;this.src=\"pics/universos/0.jpg\";'  class='fotolista' type=\"image\" src=\"pics/universos/".$row['id_uni'].".jpg\" />
												<input type=\"hidden\" name=\"id\" value=\"".$row['id_uni']."\"/>
											</form>	
										</div>	
										<div class='stats'>
											Tipo: ".$row['tipo']."
										</div>
									</div>	
									<div class = 'listamonstruos'>
										<img align = 'middle' title = '".$tipo."' width = '50px' src = 'pics/tipouni/".$tipo.".png'>
										<img align = 'middle' title = '".$row['cantidad']."' width = '50px' src = 'pics/genteuni/".$cantidad.".png'>
									</div>
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
					mostrar_nav($i, $vueltas)
					?>
					</div>

				<div class="Botones">
				

				</div>
			</div>

		</div>



</body>
</html>
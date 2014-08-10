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
</head>

<body background="pics/fondo2.jpg">
<?php 
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();
echo "<br><br>";
$result = mysql_query("Select * from escenarios");
$count = mysql_num_rows($result);
$vueltas = $count / 10.0;
if($count%10 != 0){
	$vueltas++;
}

if (isset($_GET['pag'])) {
	$pag = $_GET['pag'];
	$inicio = (($pag-1) *10);
	$fin = 10;
	$result =mysql_query("select * from escenarios order by id_esc asc LIMIT ".$inicio.",".$fin.";");
	
}else{
	$pag = 1;
	$result =mysql_query("select * from escenarios order by id_esc asc LIMIT 0,10;");
}
?>
<div class="general">
		<div class="contenido">
		<b class="tituloDetalles">Listado de escenarios</b>
				<div class="titulo"></div>
						<hr style="margin-top:20px;position:relative;">
						<?php 
							while($row = mysql_fetch_array($result))
							{
								printf("
								<div class='lista'>									
									<div class='titulolista'>
										<b style=\"position:absolute;left:120px; \">".$row['nombre']."</b>
										<div class='titulolistaimg'>
											<form name=\"enlace\" method=\"POST\" action=\"esce_detalle.php\">
												<input class='fotolista' type=\"image\" src=\"pics/escenarios/75/".$row['id_esc'].".jpg\" />
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_esc']."\"/>
											</form>
												
										</div>
										
									</div>
									
									<div class='stats'>
										
								");
										echo "<div class='titulostatlista2' >Poblacion: ".$row['poblacion']." habitantes</div><br>";
										if ($row['esplaneta'] == 0) {
										
											echo "<div class='titulostatlista2' > No es planeta </div><br>";
										}	
										else{
										
											echo "<div class='titulostatlista2' > Planeta </div><br>";
										
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
						}
echo "<div class='paginaslista'>";
for ($i=1;$i<=$vueltas;$i++){

	if($pag==$i){
	?>
		<A style="color:#fff;font-size:small;" HREF="esce_lista.php?pag=<?echo $i?>""><?echo $i." "?></A>
	<?	
	}else{
	
	?>
		<A HREF="esce_lista.php?pag=<?echo $i?>""><?echo $i." "?></A>
	<?	
	}
}
echo "</div>";
?>

				<div class="Botones">
				
					<input type="Button" name="Anyadir" Value="A&ntilde;adir"><br>
					<input type="Button" name="Eliminar" Value="Eliminar"><br>
					<input type="Button" name="Seleccionar" Value="Seleccionar todo">
				
				</div>
			</div>

		</div>



</body>
</html>
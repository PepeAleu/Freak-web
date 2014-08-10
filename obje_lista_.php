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
</head>

<body background="pics/fondo2.jpg">
<?php 
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();
echo "<br><br>";
$result = mysql_query("Select * from objetos");


$count = mysql_num_rows($result);

$vueltas = $count / 10.0;

if($count%10 != 0){
	$vueltas++;
}

if (isset($_POST['id_objb']))
{
		if (!mysql_query("Delete from objetos where id_obj = '".$_POST['id_objb']."';",$link)){
			echo 'Error al borrar';
		}
}

if (isset($_GET['pag'])) {
	$pag = $_GET['pag'];
	$inicio = (($pag-1) *10);
	$fin = 10;
	$result =mysql_query("select * from objetos order by id_obj asc LIMIT ".$inicio.",".$fin.";");

}else{
	$pag = 1;
	$result =mysql_query("select * from objetos order by id_obj asc LIMIT 0,10;");

}

?>

<div class="general">
		<div class="contenido">
		<b class="tituloDetalles">Listado de objetos</b>
			<a href='obje_anyadificar.php'><img src='pics/add.png' style='position:absolute;right:10px;margin:15px 15px 30px 0px;'></a>
				<div class="titulo"></div>
						<hr style="margin-top:20px;position:relative;">
						<?php 
							while($row = mysql_fetch_array($result))
							{
								$tipo = $row['tipo'];
								$peso = $row['peso'];
								echo
								"								
								<div class='lista'>									
									<div class='titulolista'>
										<b style=\"position:absolute;left:120px; \">".$row['nombre']."</b>								
										<div class='titulolistaimg'>
											<form name=\"enlace\" method=\"POST\" action=\"obje_detalle.php\">
												<input class='fotolista' type=\"image\" src=\"pics/objetos/".$row['id_obj'].".jpg\" />
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_obj']."\"/>
											</form>	
										</div>";
								echo	
								"
									<div class = 'listamonstruos'>
										<img align = 'middle' title = '".$row['tipo']."' width = '50px' src = 'pics/tipoobj/".$tipo.".png'>
									</div>
								";


								echo "<div class='pesototal'>";		
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
								echo	"</div>";
								
								echo	"</div>
								
									<div class='listamonstruos'>";
								
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
					mostrar_nav($i, $vueltas)
					?>
					</div>
							

				<div class="Botones">
				
					<input type="Button" name="Anyadir" Value="A&ntilde;adir"><br>
					<input type="Button" name="Eliminar" Value="Eliminar"><br>
					<input type="Button" name="Seleccionar" Value="Seleccionar todo">
				
				</div>
				
			</div>

		</div>



</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Duelo</title>
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
function cambiarFormatoFecha($fecha){
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $dia."-".$mes."-".$anio;
}  

include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();
/*if (isset($_POST['idmon'])){
$id = $_POST['idmon'];
}else{
   header('Location: http://www.saphire-universe.com/2DAI/error404.php' ) ;
}*/
 
$id_per2 = $_POST['idper2'];
$id_per1 = $_POST['idper1'];
$id_ave = $_POST['idave'];
$result =mysql_query("select modo, fecha, escenarios.id_esc as escenario, p1.nombre, p2.nombre, aventuras.nombre as aventura from escenarios, personajes p2, personajes p1, aventuras, duelo where duelo.id_per1 = p1.id_per AND escenarios.id_esc = aventuras.id_esc AND p2.id_per = duelo.id_per2 AND aventuras.id_ave = duelo.id_ave AND duelo.id_per2 = ".$id_per2." AND duelo.id_per1 = ".$id_per1." AND duelo.id_ave = ".$id_ave.";");
$row = mysql_fetch_array($result);
$fecha = cambiarFormatoFecha($row['fecha']);
?>

	<div class="general">
			<div class="contenido">
			<b class="tituloDetalles"><?php echo $row['aventura']?> </b>
				<div class="pregunta_borrado" id="pregunta_borrado2" style="visibility:hidden;">
					<br>
					<center><b>¿Estas seguro?</b></center>
					<br><br>
					<FORM method="POST" align="center" action="mons_lista.php">
						<center><INPUT TYPE="submit" value="Aceptar">
						<INPUT TYPE="text" name="id_monb" value="<?php echo $row['id_mon'] ?>" style="visibility:hidden;position:absolute;left:0;">
						<INPUT TYPE="Reset" value="Cancelar" onClick="mostrar();"></center>
					</FORM>
				</div>
			
				<div class="botoncitos">
					<a href="#" onClick="mostrar();"><img src="pics/borrar.gif" style="float:right; margin-top:-10px; margin-right:10px;"></a>
					<form name="enlace4" method="POST" style="float:right; margin-top:-10px; margin-right:10px;" action="mons_anyadificar.php">
						<input type="image" src="pics/modificar.png" />
						<input type="hidden" name="id" value="<?php echo $row['id_mon']?>"/>
					</form>
				</div>
				
				<div class="titulo"></div>
				<div class="detalles"> 

					<div class="bitacoradetalle">
					<form name="enlace" method="POST" action="pers_detalle.php">
						<input type="image" class = "bitacoradetallefoto1" width = "150px" src="pics/personajes/<?php echo $id_per1?>.jpg" />
						<input type="hidden" name="id" value="<?php echo $id_per1?>"/>
					</form>
					<form name="enlace" method="POST" action="mons_detalle.php">
						<input type="image" class = "bitacoradetallefoto2"  height = "150px" width = "150px" src="pics/personajes/<?php echo $id_per2?>.jpg" />
						<input type="hidden" name="id" value="<?php echo $id_per2?>"/>
					</form>														

					<img class = "bitacoraresuldetalle" width= "75px" src="pics/<?php echo $row['modo']?>.png">
					<img class = "bitacoraresulfecha" width= "100px" src="pics/datescroll.png">
					<img  class = "bitacoraswords1" width= "100px" src="pics/swords.png">
					<img  class = "bitacoraswords2" width= "100px" src="pics/swords.png">
					<span class = "bitacoraresulfecha"><?php echo $fecha?></span>
					</div>
					
					<hr>
				</div>



				<div class="detalles">
						<table>
						<tr>
							<?php

									echo "<td>";
									echo "<form action=\"aven_detalle.php\" method=\"POST\">";
									echo "<input onerror=\"this.onerror=null;this.src='pics/escenarios/00.jpg';\" type=\"image\" class=\"miniatura\" src=\"pics/escenarios/".$row['escenario'].".jpg\" title=\"".$row['aventura']."\"/>";
									echo "<input type=\"Hidden\" name=\"id\" value=".$id_ave.">";
									echo "</form>";
									echo "</td>";
							?>
						</tr>
					</table>
				</div>

		</div>
	</div>
<?

?>
</body>
</html>
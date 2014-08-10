<html>

<head>
	<title>Bitacora</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
	<script type="text/javascript">
		var tam = 0;
		function mostrarBuscar(capa){ 
			obj = document.getElementById(capa) 
			if(obj.style.visibility== "hidden"){ 
				obj.style.visibility= "visible";
				obj.style.height = "130px";
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
/*Funcion para comprobar fecha */
function cambiarFormatoFecha($fecha){
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $dia."-".$mes."-".$anio;
}  



include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();
echo "<br><br>";
if(isset($_GET['buscar'])){
$buscar = $_GET['buscar'];
}else{
$buscar = " bitacora.id_ave = bitacora.id_ave ";
}
if(isset($_POST['ave'])){
	$ave = $_POST['ave'];
	$per = $_POST['per'];
	$mon = $_POST['mon'];
	$mod = $_POST['mod'];
	if($ave != "" && $ave != null){			
		$buscar = $buscar." and bitacora.id_ave = ".$ave."";
	}
	if($mon != "" && $mon != null){			
		$buscar = $buscar." and bitacora.id_mon = ".$mon."";
	}
	if($per != "" && $per != null){			
		$buscar = $buscar." and bitacora.id_per = ".$per."";
	}
	if($mod != "" && $mod != null){			
		$buscar = $buscar." and bitacora.modo = '".$mod."'";
	}
}
$result = mysql_query("SELECT id_per, id_mon, aventuras.nombre as aventura, Modo, fecha, bitacora.id_ave FROM bitacora, aventuras WHERE ".$buscar." and aventuras.id_ave = bitacora.id_ave order by fecha asc");
$count = mysql_num_rows($result);
$vueltas = $count / 10.0;
if($count%10 != 0){
	$vueltas++;
}


if (isset($_POST['id_perb']) AND isset($_POST['id_monb']) AND isset($_POST['id_aveb']))
{
	if (!mysql_query("Delete from bitacora where id_per = ".$_POST['id_perb']." AND id_mon = ".$_POST['id_monb']." AND id_ave = ".$_POST['id_aveb'].";",$link)){
			echo 'Error al borrar';
		}
}


if (isset($_GET['pag'])) {
	$pag = $_GET['pag'];
	$inicio = (($pag-1) *10);
	$fin = 10;
	$result =mysql_query("select id_per, id_mon, aventuras.nombre as aventura, Modo, fecha, bitacora.id_ave FROM bitacora, aventuras WHERE ".$buscar." and aventuras.id_ave = bitacora.id_ave order by fecha asc LIMIT ".$inicio.",".$fin.";");
	
}else{
	$pag = 1;
	$result =mysql_query("select id_per, id_mon, aventuras.nombre as aventura, Modo, fecha, bitacora.id_ave FROM bitacora, aventuras WHERE ".$buscar." and aventuras.id_ave = bitacora.id_ave order by fecha asc LIMIT 0,10;");
}
?>
<div class="general">
<div id="buscarDiv" class="buscar" style="visibility:hidden;with:400px;margin-left:-200px;padding-bottom:80px;">
		<h3>Buscar</h3>
	
			<form action="bita_lista.php" method="POST">
				Personajes <select name="per">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT  p.id_per as id_per, p.nombre as nombre FROM personajes p, bitacora b where p.id_per = b.id_per group by p.id_per, p.nombre order by p.nombre; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['id_per'].'">'.$rowb['nombre'].'</option>';
				}
				?>
				</select>
				<br>
				Monstruos <select name="mon">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT  m.id_mon as id_mon, m.nombre as nombre FROM monstruos m, bitacora b where m.id_mon = b.id_mon group by m.id_mon, m.nombre order by m.nombre; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['id_mon'].'">'.$rowb['nombre'].'</option>';
				}
				?>
				</select>
				<br>
				Modo <select name="mod">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT  modo FROM bitacora group by modo order by modo; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['modo'].'">'.$rowb['modo'].'</option>';
				}
				?>
				</select>
				<br>
				Aventura <select name="ave">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT  a.id_ave, a.nombre FROM aventuras a, bitacora b where a.id_ave = b.id_ave group by a.id_ave, a.nombre order by a.nombre; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['id_ave'].'">'.$rowb['nombre'].'</option>';
				}
				?>
				</select>
				<br>
				<input value="Buscar" type="submit"></input>
			</form>
		</div>
		<div class="contenido">
		<b class="tituloDetalles">Listado de bit&aacute;coras</b>
		<a href='#' onClick="mostrarBuscar('buscarDiv');"><img src='pics/lupa.png' style='position:absolute;right:30px;margin:15px 15px 30px 0px;'></a>
		<a href='bita_anyadificar.php?padre=0'><img src='pics/add.png' style='position:absolute;right:10px;margin:15px 15px 30px 0px;'></a>
					<div class="titulo"></div>
						<hr style="margin-top:20px;position:relative;">
						<?php 
							if ($count < 1){
									echo "<h2 style='margin-left:140px;'>No se encontr&oacute; ninguna bit&aacute;cora</h2>";
									echo "<hr>";
							}
							while($row = mysql_fetch_array($result))
							{
						?>
								<div class='lista'>									
									<div class='titulolista'>
										<div class='titulolistaimg'>
                                        <?php
											$fecha = cambiarFormatoFecha($row['fecha']);
											printf("
											<form name=\"enlace\" method=\"POST\" action=\"pers_detalle.php\">
												<input class='fotolistaper' type=\"image\" src=\"pics/personajes/".$row['id_per'].".jpg\" />
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_per']."\"/>
											</form>
											<img class = \"bitacoravs\" width = \"30px\" src = \"pics/VS.png\">
											<form name=\"enlace\" method=\"POST\" action=\"mons_detalle.php\">
												<input class='fotobitamon' type=\"image\" src=\"pics/monstruos/".$row['id_mon'].".jpg\" />
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_mon']."\"/>
											</form>
											<form name=\"enlace\" method=\"POST\" action=\"bita_detalle.php\">
												<input class='bitacoraresul' type=\"image\" src = \"pics/".$row['Modo'].".png\" />
												<input type=\"hidden\" name=\"idmon\" value=\"".$row['id_mon']."\"/>
												<input type=\"hidden\" name=\"idper\" value=\"".$row['id_per']."\"/>												<input type=\"hidden\" name=\"idave\" value=\"".$row['id_ave']."\"/>
											</form>
											
		
											<img class = \"bitacorafecha\" height = \"30px\" src = \"pics/datescroll.png\">
											<span class = \"bitacorafechatexto\">".$fecha."</span>
											<span class = \"bitacoraaventura\">".$row['aventura']."</span>
											");
										?>
										</div>
										
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
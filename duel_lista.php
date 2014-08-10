<html>

<head>
	<title>Duelo</title>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
	<script type="text/javascript">
		var tam = 0;
		function mostrarBuscar(capa){ 
			obj = document.getElementById(capa) 
			if(obj.style.visibility== "hidden"){ 
				obj.style.visibility= "visible";
				obj.style.height = "120px";
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
$buscar = " duelo.id_ave = duelo.id_ave ";
}
if(isset($_POST['ave'])){
	$ave = $_POST['ave'];
	$per = $_POST['per'];
	$mod = $_POST['mod'];
	
	if($ave != "" && $ave != null){			
		$buscar = $buscar." and duelo.id_ave = ".$ave."";
	}
	if($per != "" && $per != null){			
		$buscar = $buscar." and ((duelo.id_per1 = ".$per.") or (duelo.id_per2 = ".$per."))";
	}
	if($mod != "" && $mod != null){			
		$buscar = $buscar." and duelo.modo = '".$mod."'";
	}
}
$result = mysql_query("Select duelo.id_per1, duelo.id_per2, duelo.modo, duelo.fecha, aventuras.nombre as aventura, duelo.id_ave from duelo, aventuras WHERE ".$buscar." and aventuras.id_ave = duelo.id_ave group by duelo.id_per1, duelo.id_per2, duelo.modo, duelo.fecha, aventuras.nombre , duelo.id_ave order by duelo.fecha asc;");
$count = mysql_num_rows($result);
$vueltas = $count / 10.0;
if($count%10 != 0){
	$vueltas++;
}

if (isset($_GET['pag'])) {
	$pag = $_GET['pag'];
	$inicio = (($pag-1) *10);
	$fin = 10;
	$result =mysql_query("select id_per1, id_per2, modo, fecha, aventuras.nombre as aventura, duelo.id_ave from duelo, aventuras WHERE ".$buscar." and aventuras.id_ave = duelo.id_ave group by id_per1, id_per2, modo, fecha, aventuras.nombre, duelo.id_ave order by fecha asc LIMIT ".$inicio.",".$fin.";");
	
}else{
	$pag = 1;
	$result =mysql_query("select duelo.id_per1, duelo.id_per2, duelo.modo, duelo.fecha, aventuras.nombre as aventura, duelo.id_ave from duelo, aventuras WHERE ".$buscar." and aventuras.id_ave = duelo.id_ave group by duelo.id_per1, duelo.id_per2, duelo.modo, duelo.fecha, aventuras.nombre, duelo.id_ave order by duelo.fecha asc LIMIT 0,10;");
}
?>
<div class="general">
<div id="buscarDiv" class="buscar" style="margin-left:-130px;width:260px;visibility:hidden;padding-bottom:70px;">
		<h3>Buscar</h3>
	
			<form action="duel_lista.php" method="POST">
				Personajes <select name="per">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT  p.id_per as id_per, p.nombre as nombre FROM personajes p, duelo d where (p.id_per = d.id_per1) or (p.id_per = d.id_per2) group by p.id_per, p.nombre order by p.nombre; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['id_per'].'">'.$rowb['nombre'].'</option>';
				}
				?>
				</select>
				<br>
				Modo <select name="mod">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT  modo FROM duelo group by modo order by modo; ");
				while ($rowb = mysql_fetch_array($resultb)){
					echo '<option  value="'.$rowb['modo'].'">'.$rowb['modo'].'</option>';
				}
				?>
				</select>
				<br>
				Aventura <select name="ave">
				<option value="">Nada</option>
				<?
				$resultb = mysql_query("SELECT  a.id_ave, a.nombre FROM aventuras a, duelo d where a.id_ave = d.id_ave group by a.id_ave, a.nombre	 order by a.nombre; ");
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
		<b class="tituloDetalles">Listado de duelos</b>
		<a href='#' onClick="mostrarBuscar('buscarDiv');"><img src='pics/lupa.png' style='position:absolute;right:30px;margin:15px 15px 30px 0px;'></a>
		<a href='duel_anyadificar.php'><img src='pics/add.png' style='position:absolute;right:10px;margin:15px 15px 30px 0px;'></a>
					<div class="titulo"></div>
						<hr style="margin-top:20px;position:relative;">
						<?php 
							if ($count < 1){
									echo "<h2 style='margin-left:140px;'>No se encontr&oacute; ning&uacute;n duelo</h2>";
									echo "<hr>";
							}
							while($row = mysql_fetch_array($result))
							{
								if ($row['modo'] == "Victoria1"){
									$ganador = $row['id_per1'];
								}
								else if ($row['modo'] == "Victoria2"){
								$ganador = $row['id_per2'];
								}
								else
								{
								$ganador = "empate";
								}

						?>
								<div class='lista'>									
									<div class='titulolista'>
										<div class='titulolistaimg'>
                                        <?php
											$fecha = cambiarFormatoFecha($row['fecha']);
											printf("
											<form name=\"enlace\" method=\"POST\" action=\"pers_detalle.php\">
												<input class='fotolistaper' type=\"image\" src=\"pics/personajes/".$row['id_per1'].".jpg\" />
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_per1']."\"/>
											</form>
											<img class = \"bitacoravs\" width = \"30px\" src = \"pics/VS.png\">
											<form name=\"enlace\" method=\"POST\" action=\"pers_detalle.php\">
												<input class='fotobitamon' type=\"image\" src=\"pics/personajes/".$row['id_per2'].".jpg\" />
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_per2']."\"/>
											</form>
											<form name=\"enlace\" method=\"POST\" action=\"duel_detalle.php\">
												<input class='bitacoraresul' type=\"image\" src = \"pics/personajes/".$ganador.".jpg\" />
												<input type=\"hidden\" name=\"idper2\" value=\"".$row['id_per2']."\"/>
												<input type=\"hidden\" name=\"idper1\" value=\"".$row['id_per1']."\"/>												<input type=\"hidden\" name=\"idave\" value=\"".$row['id_ave']."\"/>
												<input type=\"hidden\" name=\"fecha\" value=\"".$row['fecha']."\"/>
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
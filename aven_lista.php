<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">

<head>
	<title>Aventuras</title>
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
				obj.style.height = "150px";
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
$vuelve = $_SERVER['HTTP_REFERER'];
echo "<br><br>";

if(isset($_POST['nomAve']) or isset($_POST['desAve']) or isset($_POST['objAve']) or isset($_POST['escAve'])){
	if(isset($_POST['nomAve'])){
	$nomAve = $_POST['nomAve'];
	}
	if(isset($_POST['desAve'])){
	$desAve = $_POST['desAve'];
	}
	if(isset($_POST['objAve'])){
	$objAve = $_POST['objAve'];
	}
	if(isset($_POST['escAve'])){
	$escAve = $_POST['escAve'];
	}

		if(($nomAve != "" && $nomAve != null) || ($desAve != "" && $desAve != null ) || ($objAve != "" && $objAve != null) || ($escAve != "" && $escAve != null)){
			$buscar = "select * from aventuras where id_ave = id_ave";
			if($nomAve != "" && $nomAve != null){
				
				$buscar = $buscar." and nombre like '%".$nomAve."%'";
			}
			if($desAve != "" && $desAve != null){
				
				$buscar = $buscar." and descripcion like '%".$desAve."%'";
			}
			if($objAve != "" && $objAve != null){
				
				$buscar = $buscar." and id_obj = ".$objAve."";
			}
			if($escAve != "" && $escAve != null){
				
				$buscar = $buscar." and id_esc = ".$escAve."";
			}
			$buscar1 = $buscar.";";
			$result = mysql_query($buscar1,$link);
		}

	else{
		$buscar = "Select * from aventuras;";
		$result = mysql_query($buscar);
	}
}else{
	$buscar = "Select * from aventuras;";
	$result = mysql_query($buscar);
}
$count = mysql_num_rows($result);
$vueltas = $count / 10.0;

if($count%10 != 0){
	$vueltas++;
}
if (isset($_POST['id_aveb']))
{
		if (!mysql_query("Delete from aventuras where id_ave = '".$_POST['id_aveb']."';",$link)){
			echo 'Error al borrar';
		}
}
	if (isset($_GET['pag'])) {
		$pag = $_GET['pag'];
		$inicio = (($pag-1) *10);
		$fin = 10;
		if(isset($_POST['nomAve']) or isset($_POST['desAve']) or isset($_POST['objAve']) or isset($_POST['escAve'])){
			$result =mysql_query($buscar." order by id_ave asc LIMIT ".$inicio.",".$fin.";");
		}else{
			$result =mysql_query("SELECT * FROM aventuras order by id_ave asc LIMIT ".$inicio.",".$fin.";");
		}
	}else{
		$pag = 1;
		if(isset($_POST['nomAve']) or isset($_POST['desAve']) or isset($_POST['objAve']) or isset($_POST['escAve'])){
			$result =mysql_query($buscar." order by id_ave asc LIMIT 0,10;");
		}else{
			$result =mysql_query("SELECT * FROM aventuras order by id_ave asc LIMIT 0,10;");
		}
	}

?>
<div class="general">
		<div id="buscarDiv" class="buscar" style="width:260px;margin-left:-130px;visibility:hidden;padding-bottom:60px;">
		<h3>Buscar</h3>
			<form action="aven_lista.php" method="POST">
				Nombre : <input  type="text" name="nomAve"></input>
				<br>
				Escenarios <select name="escAve">
				<option value="">Nada</option>
				<?
				$esc = mysql_query("SELECT av.id_esc as id_esc, es.nombre FROM escenarios es, aventuras av where av.id_esc = es.id_esc group by av.id_esc, es.nombre order by es.nombre ; ");
				while ($escenarios = mysql_fetch_array($esc)){
					echo '<option  value="'.$escenarios['id_esc'].'">'.$escenarios['nombre'].'</option>';
				}
				?>
				</select>
				<br>
				Descripci&oacute;n : <input  type="text" name="desAve"></input>
				<br>
				Objetos <select name="objAve">
				<option value="">Nada</option>
				<?
				$obj = mysql_query("SELECT av.id_obj as id_obj, ob.nombre FROM objetos ob, aventuras av where av.id_obj = ob.id_obj group by av.id_obj, ob.nombre order by ob.nombre asc; ");
				while ($objetos = mysql_fetch_array($obj)){
					echo '<option  value="'.$objetos['id_obj'].'">'.$objetos['nombre'].'</option>';
				}
				?>
				</select>
				<br>
				<input value="Buscar" type="submit"></input>
			</form>
		</div>
		<div class="contenido">
		<b class="tituloDetalles">Listado de aventuras</b>
				<a href='#' onClick="mostrarBuscar('buscarDiv');"><img src='pics/lupa.png' style='position:absolute;right:30px;margin:15px 15px 30px 0px;'></a>
				<a href='aven_anyadificar.php'><img src='pics/add.png' style='position:absolute;right:10px;margin:15px 15px 30px 0px;'></a>
				<div class="titulo"></div>
						<hr style="margin-top:20px;position:relative;">
						<?php 
							if ($count < 1){
									echo "<h2 style='margin-left:140px;'>No se encontr&oacute; ninguna aventura</h2>";
									echo "<hr>";
								}
							while($row = mysql_fetch_array($result))
							{
								
								if ($row['id_obj']==null){
								$objeto="Nada";
								$cantidad="0";
								}else{
								$result2 = mysql_query("Select nombre from objetos where id_obj =".$row['id_obj'].";");
								$objeto_asociado = mysql_fetch_array($result2);
								$objeto = $objeto_asociado['nombre'];
								$cantidad = $row['cantidad'];
								}
								echo
								"<div class='lista'>									
									<div class='titulolista'>
										<b style=\"position:absolute;left:120px; \">".$row['nombre']."</b>
										<div class='titulolistaimg'>
											<form name=\"enlace\" method=\"POST\" action=\"aven_detalle.php\">
												<input class='fotolista' type=\"image\" src=\"pics/escenarios/".$row['id_esc'].".jpg\" 
												onerror=\"this.onerror=null;this.src='pics/escenarios/00.jpg';\"/>
												<input  type=\"hidden\" name=\"id\" value=\"".$row['id_ave']."\"/>
											</form>
												
										</div>
										
									</div>

									<div class='listamonstruos'>

									";
									if ($objeto =="Nada"){
										echo "<img title = 'Nada' width = '40px' src = 'pics/escenarios/x.png'>";
									}
									else{
										echo "<img title = '".$objeto." ".$cantidad."%' width = '60px' src = 'pics/objetos/".$row['id_obj'].".jpg'>";
									}
									

									echo"</div>
								</div>
									
									<hr>
								";
						}
echo "<div class='paginaslista'>";
	
	if (isset($_GET['pag'])){
	$i=$_GET['pag'];
	}else{
	$i=1;
	}
	
	?>
		<A style="color:#fff;font-size:small;" HREF="aven_lista.php?pag=1"><img src="pics/BPrimero.png" border="0"></A>
		<?php
		if (($pag-1)<1){
			$i=1;
		}else{																
			$i = $pag - 1; 
		}			
		
		$anterior = $i;
		$i = $pag;
		if (($pag+1)>$vueltas){
			$i=floor($vueltas);
			
		}else{																
			$i = $pag + 1; 	
		
		}
		$posterior=$i;
		?>
		<A style="color:#fff;font-size:small;" HREF="aven_lista.php?pag=<?php echo $anterior; ?>"> <img src="pics/BAtras.png" border="0"></A>
		<?echo " ".$pag." "?>
		<A style="color:#fff;font-size:small;" HREF="aven_lista.php?pag=<?php echo $posterior; ?>"><img src="pics/BSiguiente.png" border="0"></A>
		<A style="color:#fff;font-size:small;" HREF="aven_lista.php?pag=<?echo floor($vueltas);?>"> <img src="pics/BUltimo.png" border="0"></A>
	
	<?	
	
echo "</div>";
?>

				
			</div>

		</div>



</body>
</html>
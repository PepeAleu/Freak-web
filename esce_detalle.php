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
include("librerias/basicas.php");
include("librerias/connect.php");
get_header();
$link=Conectarse();
if (isset($_POST['id'])){
$id = $_POST['id'];
}else{
   header('Location: http://www.saphire-universe.com/2DAI/error404.php' ) ;
}

$id = $_POST['id'];
$result =mysql_query("select * from escenarios where id_esc = ".$id.";");
$row = mysql_fetch_array($result);
$id_uni = $row['id_uni'];
if ($row['esplaneta']==1){
	$esplaneta="Planeta";
}else{
	$esplaneta="No es planeta";
}
if ($row['esc_padre']==null){
	$padre="No tiene padre";
}else{
	$result = mysql_query("Select nombre from escenarios where id_esc =".$row['esc_padre'].";");
	$esc_padre = mysql_fetch_array($result);
	$padre = $esc_padre['nombre'];
}
$result = mysql_query("Select nombre from universos where id_uni =".$row['id_uni'].";");
$row2 = mysql_fetch_array($result);

$consul = mysql_query("select id_esc from escenarios order by id_esc asc limit 1;");
$primero = mysql_fetch_array($consul);

$consul = mysql_query("select id_esc from escenarios order by id_esc desc limit 1;");
$ultimo = mysql_fetch_array($consul);
?>

	<div class="general">
	<div class="ant">
		<?php if ($row['id_esc'] > $primero['id_esc'])	{
				$consul = mysql_query("select id_esc from escenarios where id_esc < ". $row['id_esc'] ." order by id_esc desc limit 1");
				$ant = mysql_fetch_array($consul); 
				?>
							
				<form name="enlace1" method="POST" action="esce_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" type="image" src="pics/escenarios/<?php echo $ant['id_esc']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $ant['id_esc']?>"/>
				</form>
				<?php
			}
		?>
		</div>
		<div class="sig">
		<?php
		if ($row['id_esc'] < $ultimo['id_esc']){
				$consul2 = mysql_query("select id_esc from escenarios where id_esc > ". $row['id_esc'] ." order by id_esc asc limit 1");
				$sig = mysql_fetch_array($consul2);
				?>
				<form name="enlace2" method="POST" action="esce_detalle.php">
				<input onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" type="image" src="pics/escenarios/<?php echo $sig['id_esc']?>.jpg" />
				<input type="hidden" name="id" value="<?php echo $sig['id_esc']?>"/>
				</form>
				<?php
			}
			?>
		</div>	
		<div class="contenido">
			<b class="tituloDetalles"><?php echo $row['nombre']?></b>
			<div class="pregunta_borrado" id="pregunta_borrado2" style="visibility:hidden;">
				<br>
				<center><b>&iquest;Est&aacute;s seguro?</b></center>
				<br><br>
				<FORM method="POST" align="center" action="esce_lista.php">
					<center><INPUT TYPE="submit" value="Aceptar">
					<INPUT TYPE="text" name="id_escb" value="<?php echo $row['id_esc'] ?>" style="visibility:hidden;position:absolute;left:0;">
					<INPUT TYPE="Reset" value="Cancelar" onClick="mostrar();"></center>
				</FORM>
			</div>
			<a href="#" onClick="mostrar();"><img src="pics/borrar.gif" style="float:right;margin:15px 15px 0px 0px;"></a>
			<form name="enlace4" method="POST" style="float:right;margin:15px 15px 0px 0px;" action="esce_anyadificar.php">
				<input type="image" src="pics/modificar.png" />
				<input type="hidden" name="id" value="<?php echo $row['id_esc']?>"/>
			</form>
			<div style="clear:both;"></div>
				<div class="titulo"></div>
				
				<div class="detalles"> 
					<div class="foto">
						<img onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" src="pics/escenarios/<?php echo $row['id_esc']?>.jpg">
					</div>
					<table class="detallestable">
						<tr>
							<td>
								<b>Nombre:</b> 
							</td>
							<td class="datos">
								<?php echo $row['nombre']?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Poblaci&oacute;n:</b>
							</td>
							<td class="datos">
								<?php echo $row['poblacion']?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Poblaci&oacute;n M&aacute;xima:</b>
							</td>
							<td class="datos">
								<?php echo $row['poblacionmaxima']?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Ocupacion:</b>
							</td>
							<td class="datos">
								<?php $var = substr(($row['poblacion']*100)/$row['poblacionmaxima'],0,5);
								echo $var;?>%
							</td>
							<td class="datos">
							<?php 
										if($var>=0 AND $var<=1)
										{
											echo "<img src='pics/poblacion/0.png'>";
										}
										else if ($var>1 AND $var<=10)
										{
											echo "<img src='pics/poblacion/1.png'>";
										}
										else if ($var>10 AND $var<=25)
										{
											echo "<img src='pics/poblacion/2.png'>";
										}
										else if ($var>25 AND $var<=40)
										{
											echo "<img src='pics/poblacion/3.png'>";
										}
										else if ($var>40 AND $var<=60)
										{
											echo "<img src='pics/poblacion/4.png'>";
										}
										else if ($var>60 AND $var<=80)
										{
											echo "<img src='pics/poblacion/5.png'>";
										}
										else if ($var>80 AND $var<100)
										{
											echo "<img src='pics/poblacion/6.png'>";
										}
										else
										{
											echo "<img src='pics/poblacion/7.png'>";
										}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Planeta:</b> 
							</td>
							<td class="datos">
								<?php 
										if($esplaneta=='Planeta')
										{
											echo "<img src='pics/planeta.png'>";
										}
										else
										{
											echo $esplaneta;
										}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<b>Escenario Padre:</b> 
							</td>
							<td class="datos">
								<?php 
									If ($padre == "No tiene padre"){
									echo "<img width = '20' src = 'pics/escenarios/x.png'>";
									}
									else{
									echo $padre;
									}
								?>
							</td>
						</tr>
					</table>
					<div style="clear:both;"></div>
					<hr>	
					<div class="detalles2">	
						<form name="enlace" method="POST" action="univ_detalle.php">
						<input title = "<?php echo $row2['nombre']?>" onerror="this.onerror=null;this.src='pics/escenarios/00.jpg';" class="miniatura" type="image" src="pics/universos/<?php echo $row['id_uni']?>.jpg" />
						<input type="hidden" name="id" value="<?php echo $id_uni?>"/>
						</form>
					</div>
				</div>
		</div>
	</div>
<?

?>
</body>
</html>